<?php
/**
 * @package         Sourcerer
 * @version         9.2.3
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2022 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class PlgEditorsXtdSourcererInstallerScript extends PlgEditorsXtdSourcererInstallerScriptHelper
{
	public $alias          = 'sourcerer';
	public $extension_type = 'plugin';
	public $name           = 'SOURCERER';
	public $plugin_folder  = 'editors-xtd';

	public function onAfterInstall($route)
	{
		$this->deleteJoomla3Files();

		return parent::onAfterInstall($route);
	}

	public function uninstall($adapter)
	{
		$this->uninstallPlugin($this->extname, 'system');
	}

	private function deleteJoomla3Files()
	{
		$this->delete(
			[
				JPATH_SITE . '/plugins/editors-xtd/' . $this->extname . '/layouts',
				JPATH_SITE . '/plugins/editors-xtd/' . $this->extname . '/fields.xml',
				JPATH_SITE . '/plugins/editors-xtd/' . $this->extname . '/helper.php',
				JPATH_SITE . '/plugins/editors-xtd/' . $this->extname . '/popup.php',
				JPATH_SITE . '/plugins/editors-xtd/' . $this->extname . '/popup.tmpl.php',
			]
		);
	}
}
