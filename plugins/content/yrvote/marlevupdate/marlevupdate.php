<?php

/**
 *
 * @extension       MarlevUpdate - Marlev Extensions Automatic Update
 * @author          Lev Milicenco<support@marlev.it>
 * @link            http://www.marlev.it
 * @copyright       Copyright 2017 marlev.it All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

class plgInstallerMarlevupdate extends JPlugin {

    public function onInstallerBeforePackageDownload(&$url, &$headers) {


        $uri = JUri::getInstance($url);
        $host = $uri->getHost();
        if (!in_array($host, $this->update_servers())) {
            return true;
        }

        $extension = trim($uri->getVar("extension"));
        $plg = trim($uri->getVar("plugintype"));
        $explode_ext = explode("_", $extension);



        $param = new JRegistry();
        if ($explode_ext[0] == "com") {
            JLoader::import('joomla.application.component.helper');

            $com_params = JComponentHelper::getParams($extension);
            $gets = $com_params->get("params");
            $get_params = $param->loadArray($com_params->get("params"));
        } else if ($explode_ext[0] == "tpl") {
            $get_templatekey = $this->get_marlevtemplate($explode_ext[1]);
            $get_params = $param->loadString($get_templatekey);
        } else if ($explode_ext[0] == "plg" && !empty($plg)) {
            $plugin = JPluginHelper::getPlugin($plg, $explode_ext[1]);
            $get_params = $param->loadString($plugin->params);
        } else {
            return true;
        }

        $update_key = $get_params->get('product_key');
        $private_key = $get_params->get('private_key');


        if (empty($update_key) || empty($private_key)) {
            $app = JFactory::getApplication();
            $app->enqueueMessage(JText::_('<strong>Update Key & Private Key are required for automatic update of Marlev Extensions</strong>'), 'notice');
            return false;
        }

        $uri->setVar('product_key', $update_key);
        $uri->setVar('private_key', $private_key);

        $url = $uri->toString();
        return true;
    }

    private function get_marlevtemplate($template) {
        $return = '';
        if (JComponentHelper::getComponent('com_tmarlev', true)->enabled) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('params');
            $query->from('#__tmarlev_update');
            $query->where('template=' . $db->Quote($template));
            $db->setQuery($query);
            $return = $db->loadResult();
        }
        if (JComponentHelper::getComponent('com_tmarlevv2', true)->enabled && empty($return)) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('params');
            $query->from('#__tmarlevv2_update');
            $query->where('template=' . $db->Quote($template));
            $db->setQuery($query);
            $return = $db->loadResult();
        }
        return $return;
    }

    protected function update_servers() {
        return array("marlev.it", "itroom.it");
    }

}
