<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2022 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

/** @noinspection PhpUnused */

defined('_JEXEC') || die;

use Akeeba\Component\AkeebaBackup\Administrator\Model\UpgradeModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Installer\Adapter\PackageAdapter;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\DatabaseInterface;

/**
 * Akeeba Backup package extension installation script file.
 *
 * @see https://docs.joomla.org/Manifest_files#Script_file
 * @see UpgradeModel
 */
class Pkg_AkeebabackupInstallerScript
{
	/**
	 * @var   DatabaseDriver|DatabaseInterface|null
	 * @since 9.3.0
	 */
	protected $dbo;

	public function preflight($type, $parent)
	{
		$this->setDboFromAdapter($parent);

		// Do not run on uninstall.
		if ($type === 'uninstall')
		{
			return true;
		}

		define('AKEEBABACKUP_INSTALLATION_PRO', is_file($parent->getParent()->getPath('source') . '/com_akeebabackup-pro.zip'));

		// Prevent users from installing this on Joomla 3
		if (version_compare(JVERSION, '3.999.999', 'le'))
		{
			$msg = "<p>This version of Akeeba Backup cannot run on Joomla 3. Please download and install Akeeba Backup 8 instead. Kindly note that our site's Downloads page clearly indicates which version of our software is compatible with Joomla 3 and which version is compatible with Joomla 4.</p>";

			Log::add($msg, Log::WARNING, 'jerror');

			return false;
		}

		return true;
	}

	/**
	 * Called after any type of installation / uninstallation action.
	 *
	 * @param   string          $type    Which action is happening (install|uninstall|discover_install|update)
	 * @param   PackageAdapter  $parent  The object responsible for running this script
	 *
	 * @return  bool
	 * @since   9.0.0
	 */
	public function postflight(string $type, PackageAdapter $parent): bool
	{
		$this->setDboFromAdapter($parent);

		// Do not run on uninstall.
		if ($type === 'uninstall')
		{
			return true;
		}

		$model = $this->getUpgradeModel();

		if (empty($model))
		{
			return true;
		}

		return $model->postflight($type, $parent);
	}

	/**
	 * Get the UpgradeModel of the installed component
	 *
	 * @return  UpgradeModel|null  The upgrade Model. NULL if it cannot be loaded.
	 * @since   9.0.0
	 */
	private function getUpgradeModel(): ?UpgradeModel
	{
		// Make sure the latest version of the Model file will be loaded, regardless of the OPcache state.
		$filePath = JPATH_ADMINISTRATOR . '/components/com_akeebabackup/src/Model/UpgradeModel.php';

		if (function_exists('opcache_invalidate'))
		{
			opcache_invalidate($filePath = JPATH_ADMINISTRATOR . '/components/com_akeebabackup/src/Model/UpgradeModel.php');
		}

		// Can I please load the model?
		if (!class_exists('\Akeeba\Component\AkeebaBackup\Administrator\Model\UpgradeModel'))
		{
			if (!file_exists($filePath) || !is_readable($filePath))
			{
				return null;
			}

			/** @noinspection PhpIncludeInspection */
			include_once $filePath;
		}

		if (!class_exists('\Akeeba\Component\AkeebaBackup\Administrator\Model\UpgradeModel'))
		{
			return null;
		}

		try
		{
			$upgradeModel = new UpgradeModel();
		}
		catch (Throwable $e)
		{
			return null;
		}

		if (method_exists($upgradeModel, 'setDbo'))
		{
			$upgradeModel->setDbo($this->dbo ?? Factory::getContainer()->get('DatabaseDriver'));
		}

		return $upgradeModel;
	}

	/**
	 * Set the database object from the installation adapter, if possible
	 *
	 * @param   InstallerAdapter|mixed  $adapter  The installation adapter, hopefully.
	 *
	 * @since   9.3.0
	 * @return  void
	 */
	private function setDboFromAdapter($adapter): void
	{
		$this->dbo = null;

		if (class_exists(InstallerAdapter::class) && ($adapter instanceof InstallerAdapter))
		{
			/**
			 * If this is Joomla 4.2+ the adapter has a protected getDatabase() method which we can access with the
			 * magic property $adapter->db. On Joomla 4.1 and lower this is not available. So, we have to first figure
			 * out if we can actually use the magic property...
			 */

			try
			{
				$refObj = new ReflectionObject($adapter);

				if ($refObj->hasMethod('getDatabase'))
				{
					$this->dbo = $adapter->db;

					return;
				}
			}
			catch (Throwable $e)
			{
				// If something breaks we will fall through
			}
		}

		$this->dbo = Factory::getContainer()->get('DatabaseDriver');
	}
}