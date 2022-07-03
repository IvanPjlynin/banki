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
use Joomla\CMS\Factory;

class plgContentYrvoteInstallerScript {
    function update($parent)
    {
        if(file_exists(JPATH_SITE . '/plugins/content/yrvote/yrvote.xml')) {
            $xml = simplexml_load_file(JPATH_SITE . '/plugins/content/yrvote/yrvote.xml');
            $yourversion = strstr($xml->{'version'},".",true);
            if($yourversion < 3){
                $mess = 'This version introduces its own parameters in the menu configuration and in the article. YRVote from this version no longer uses Joomla\'s Voting parameter. ';
                $mess .= 'Please read the following article  <a href="https://marlev.it/en/faq-en/29-yrvote.html?faq=111>" target="_blank">How to display YRVote in Article</a>. ';
                $mess .= 'If you used shortcodes to display YRVote, you don\'t need to do anything, but we recommend read in our FAQ how YRVote works now. ';
                JFactory::getApplication()->enqueueMessage($mess, 'warning');
            }
        }
    }
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
        $update = $this->update_updateserver();
        // JInstallerHelper::cleanupInstall($pkg_path);
        if (isset($message_error)) {
            JFactory::getApplication()->enqueueMessage($message_error, 'error');
        } else {

            JFactory::getApplication()->enqueueMessage($message, 'message');
            $parent->getParent()->setRedirectURL('index.php?option=com_plugins&view=plugins&filter[search]=yrvote');
        }
        return false;
    }

   private function update_updateserver()
    {
        if(file_exists(JPATH_SITE . '/plugins/content/yrvote/yrvote.xml')) {
            $xml = simplexml_load_file(JPATH_SITE . '/plugins/content/yrvote/yrvote.xml');
            $link = $xml->{'updateservers'}->{'server'};
            $name = $link->attributes()->name[0];
            $db = Factory::getDbo();
            $query = $db->getQuery(true);
            $query = 'UPDATE #__update_sites' . ' SET location = ' . $db->quote($link) . ' WHERE name =' . $db->quote($name);
            $db->setQuery($query);
            $result = $db->execute();
        }
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
