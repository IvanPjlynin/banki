<?php

/**
 *
 * @extension       YRvote installer
 * @author          Lev Milicenco<support@marlev.it>
 * @link            http://www.marlev.it
 * @copyright       Copyright 2014 marlev.it All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

 */
defined('_JEXEC') or die('Restricted access');
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
//jimport('joomla.filesystem.folder');
//jimport('joomla.filesystem.file');
//jimport('joomla.installer.helper');

class plgContentYrvoteInstallerScript {

    function postflight($type, $parent) {
        $installer = new JInstaller();

        $installer->_overwrite = true;
        $pkg_path = dirname(__FILE__) . DS . 'marlevupdate' . DS;
        if (!$installer->install($pkg_path)){
              $message_error = "ERROR: Could not install correcty Marlev Automatic Update Plugin. Please contact Marlev Support.";
        }
        else {
            $message = JText::_("YRVOTE_INSTALLED_DONE");
        }


        $enable = array("marlevupdate","yrvote");
        $enable_marlevupdate = $this->enable_extensions($enable);
        // JInstallerHelper::cleanupInstall($pkg_path);
        if (isset($message_error)) {
            JFactory::getApplication()->enqueueMessage($message_error, 'error');
        } else {
            
            JFactory::getApplication()->enqueueMessage($message, 'message');
            $parent->getParent()->setRedirectURL('index.php?option=com_plugins&view=plugins&filter[search]=yrvote');
        }
        return false;
    }

 


    protected function enable_extensions($extension) {

        $db = JFactory::getDbo();
        $prepare = array();
        foreach ($extension as $key => $ext) {
            if (!empty($ext))
                $prepare[] = $db->quote($ext);
        }
        $elements = implode(",", $prepare);
        $query = $db->getQuery(true);
        $query = 'UPDATE #__extensions' . ' SET enabled = 1 WHERE element IN ( ' . $elements . '  )';
        $db->setQuery($query);
        $result = $db->execute();
    }

}
