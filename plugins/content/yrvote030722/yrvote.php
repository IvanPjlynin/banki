<?php

/**
 * @extensione  YRVote Plugin for Marlev Template ONLY!
 * @author      Lev Milicenco
 * @copyright   (c) Marlev.it - Itroom SRLS - 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * WARNING - Don't use it without Template by Marlev
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class plgContentYrvote extends JPlugin
{

    protected $homepage = false;
    protected $getparams = false;
    protected $show_yrvote = 0;

    function onContentPrepareForm($form, $data)
    {
        $app = JFactory::getApplication();
        $option = $app->input->get('option');
        $view = $app->input->get('view');
        if ($app->isClient('administrator')) {
            if ($option == "com_menus" && isset($data->request["view"]) && in_array($data->request["view"], ["article", "archive", "category", "featured", "categories"])) {
                $this->load_lang_file();
                JForm::addFormPath(JPATH_SITE . '/plugins/content/yrvote/forms');
                $form->loadFile('menu', false);
            }
            if ($option == "com_content") {
                $this->load_lang_file();
                JForm::addFormPath(JPATH_SITE . '/plugins/content/yrvote/forms');
                $form->loadFile('article', false);
            }
        }

        return true;
    }

    public function onContentPrepare($context, &$article, &$params, $limitstart = 0)
    {

        $content = $this->check_if_content($context, $article);
        if ($content == false)
            return false;

        $regex = "#{yrvote}#";
        preg_match_all($regex, $article->text, $matches, PREG_PATTERN_ORDER);

        if (isset($matches[0][0])) {
            $this->get_params($article, $params);
            $this->show_yrvote = 1;
            $this->homepage = $this->if_is_homepage();
            $document = $this->add_head();
            $vars = $this->prepare_vars($article, $params);

            foreach ($matches[0] as $value) {
                $string = $this->insert_stars($vars, $article);
                $article->text = str_replace($value, $string, $article->text);
            }
            $this->sctipt_to_html($document, $vars);
        }
    }

    public function onContentBeforeDisplay($context, &$article, &$params, $page = 0)
    {
        $vote_plugin = JPluginHelper::getPlugin('content', 'vote');
        $content = $this->check_if_content($context, $article);
        if ($content == false || $vote_plugin)
            return false;

        $this->get_params($article, $params);
        if (!empty($params) && $this->show_yrvote == 1) {
            $this->homepage = $this->if_is_homepage();
            $document = $this->add_head();
            $vars = $this->prepare_vars($article, $params);
            $this->sctipt_to_html($document, $vars);
            $string = $this->insert_stars($vars, $article);
            return $string;
        }

    }


    protected function sctipt_to_html($document, $vars)
    {
        if ($this->homepage == false) {
            $input = JFactory::getApplication()->input;
            if ($input->getString('view', '') === 'article') { //Aded
                $this->insert_script($document, $vars);
            }
        }
    }

    protected function if_is_homepage()
    {
        $app = JFactory::getApplication();
        $menu = $app->getMenu();
        $lang = JFactory::getLanguage();

        if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
            return true;
        } else {
            return false;
        }
    }

    protected function add_head()
    {
        JPlugin::loadLanguage('yrvote');
        $document = Factory::getApplication()->getDocument();
        $input = Factory::getApplication()->input;
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

        if ($this->homepage == false && $input->getString('view', '') === 'article') { //Added
            JHtml::_('jquery.framework');
            $wa->registerAndUseScript('js_yrvote', 'plugins/content/yrvote/incl/js.js', [], ['defer' => true]);
        }
        $wa->registerAndUseStyle('css_yrvote', 'plugins/content/yrvote/incl/css.css');
        $wa->useStyle('fontawesome');
        $document->addStyleDeclaration('.yrvote-star span{font-size: ' . $this->params->get('yrvotestarsize', 20) . 'px}');
        return $document;
    }

    protected function check_if_content($context, $article)
    {
        $parts = explode(".", $context);
        if ($parts[0] === 'com_content' && (isset($article->state) && $article->state == 1)) { //aded
            return true;
        } else
            return false;
    }


    protected function get_params($article, $params)
    {
        $name_default = array("show_yrvote" => $this->show_yrvote);
        $xml = simplexml_load_file(JPATH_SITE . '/plugins/content/yrvote/yrvote.xml');
        foreach ($xml->{'config'}->{'fields'} as $fields) {
            foreach ($fields as $fieldset) {
                foreach ($fieldset as $field) {
                    $name = (string)$field->attributes()->name[0];
                    $default = (string)$field->attributes()->default[0];
                    $name_default[$name] = $default;
                }
            }
        }

        //Define yrvotes
        $this->show_yrvote = 1;
        $decode_art = json_decode($article->attribs);
        if (!$params->get("show_yrvote", null) || (isset($decode_art->show_yrvote) && !($decode_art->show_yrvote))) {
            $this->show_yrvote = 0;
        }
        //Get menu params
        $this->getparams = new stdClass();
        $input = JFactory::getApplication()->input;
        foreach ($name_default as $key => $value) {
            if ($params && $params->get($key, null)) {
                if ($input->getString('view', '') === 'article' && isset($decode_art->$key) && !in_array($decode_art->$key, ["use_global", ""])) {
                    $this->getparams->$key = $decode_art->$key;

                } else if ($params->get($key, null) == "use_article" || $params->get($key, null) == "use_global") {
                    $this->getparams->$key = $this->assign_params($decode_art, $key, $value);
                } else {
                    $this->getparams->$key = $params->get($key, null);

                }
            } else {
                $this->getparams->$key = $this->assign_params($decode_art, $key, $value);

            }
        }
        $this->show_yrvote = $this->getparams->show_yrvote;
//        echo "<pre>";
//        print_r($this->getparams);
        return $this->getparams;
    }

    protected function assign_params($decode_art, $key, $value)
    {
        if (!isset($decode_art->$key) || $decode_art->$key == "use_global") {
            $app = Factory::getApplication();
            $menu = $app->getMenu()->getActive();
            $menuParams = $menu->getParams();
            $param = $menuParams->get($key);

            if ($param == "use_global" || ($param == "use_article" && (!isset($decode_art->$key) || $decode_art->$key == "use_global")) || empty($param)) {
                return $this->params->get($key, $value);
            }

            return $param;
        } else {

            if (empty($decode_art->$key)) {
                return $this->params->get($key, $value);
            }
            return $decode_art->$key;
        }
    }

    protected function prepare_vars($article, $params)
    {
        if (isset($_COOKIE["yrvotestyle"])) {
            $this->getparams->yrvotestyle = (string)preg_replace('/[^A-Z0-9_\.-]/i', '', $_COOKIE["yrvotestyle"]);
        }
        $this->getparams->active = 'yractive fa fa-star ' . $this->getparams->yrvotestyle;
        $this->getparams->half_active = 'yrhalf fa fa-star ' . $this->getparams->yrvotestyle;
        $this->getparams->off = 'yroff fa fa-star ' . $this->getparams->yrvotestyle;
        // $this->getparams->yrvotecount = $this->getparams->count;
        $this->getparams->title = $article->title;
        $get_rats = $this->rating_sum($article->id);

        $this->getparams->ratingCount = (isset($get_rats[0]->rating_count)) ? $get_rats[0]->rating_count : 0;
        if ($this->getparams->ratingCount > 0) {
            $this->getparams->ratingValue = round(($get_rats[0]->rating_sum) / $this->getparams->ratingCount, 1);
        } else {
            $this->getparams->ratingValue = "0.0";
        }


        $make_rating = explode(".", $this->getparams->ratingValue);
        $this->getparams->int_rate = $make_rating[0];
        $dec_rate = (isset($make_rating[1])) ? $make_rating[1] : 0;
        $this->getparams->half_rate = false;
        if ($dec_rate > 0) {

            $this->getparams->half_rate = true;
            if ($dec_rate <= 3) {
                $this->getparams->half_active = 'yrhalf3 fa fa-star ' . $this->getparams->yrvotestyle;
            } elseif ($dec_rate <= 5) {
                $this->getparams->half_active = 'yrhalf5 fa fa-star ' . $this->getparams->yrvotestyle;
            } elseif ($dec_rate <= 9) {
                $this->getparams->half_active = 'yrhalf7 fa fa-star ' . $this->getparams->yrvotestyle;
            }
        } else {
            $this->getparams->int_rate = $this->getparams->int_rate;
        }

        $this->getparams->votes = ($this->getparams->ratingCount == 1) ? JText::_("YRVOTE_VOTE") : JText::_("YRVOTE_VOTES");

        return $this->getparams;
    }

    protected function rating_sum($artid)
    {
        $artid = (int)$artid;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('rating_sum,rating_count');
        $query->from('#__content_rating');
        $query->where('content_id=' . $db->Quote($artid));
        $db->setQuery($query);
        $sum = $db->loadObjectList();
        return $sum;
    }


    protected function get_stars($vars,$article){
        $string = '  <div class="yrvote_box" style="height: ' . ($vars->yrvotestarsize + 20) . 'px"  data-rating="' . number_format($vars->ratingValue, 1) . '"><div class="yrvote ' . $vars->yrvotealign . '" data="" id="yrvote" >';
        $string .= '<div class="yrvoteimg" style="width:' . $vars->yrvotestarsize * 6 . 'px" data-text="' . $vars->yrvotetext . '" data-textcolor="' . $vars->yrvotetextcolor . '" data-active="' . $vars->active . '" data-off="' . $vars->off . '">';
        for ($i = 1; $vars->int_rate >= $i; $i++) {

            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->active . '"><span  style="font-size: ' . $vars->yrvotestarsize . 'px" class="' . $vars->active . '"></span></span>';
        }
        if ($vars->half_rate == true) {
            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->half_active . '"><span  style="font-size: ' . $vars->yrvotestarsize . 'px" class="' . $vars->half_active . '"></span></span>';
            $i++;
        }
        for ($i; 5 >= $i; $i++) {
            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->off . '"><span  style="font-size: ' . $vars->yrvotestarsize . 'px" class="' . $vars->off . '"></span></span>';
        }

        $string .= '</div>';
        $show = 1;
        if (isset($_COOKIE["yrvotevotes"])) {
            $show = (int)$_COOKIE["yrvotevotes"];
        }
        $hide_show = ($show == 1) ? "" : "display:none;";
        if ($vars->yrvotecount == 1 && $this->homepage == false)
            $string .= '<div class="yrvotetotal"  style="color:' . $vars->yrvotetextcolor . '; ' . $hide_show . '">' . $vars->ratingValue . ' ' . JText::_("YRVOTE_OF") . ' 5 (' . $vars->ratingCount . ' ' . $vars->votes . ')</div>';

        $string .= '<input type="hidden" class="ittoken" value="1" name="' . JSession::getFormToken() . '">';
        $string .= '</div></div>';
        return $string;
    }

    protected function insert_stars($vars, $article){
        $string = $this->get_stars($vars,$article);
        switch ($vars->contenttype) {
            case "product" :
                $string .= $this->product_type($vars, $article);
                break;
            case "creativeworkseason" :
                $string .= $this->creativeworkseason_type($vars, $article);
                break;
            case "course" :
                $string .= $this->course_type($vars, $article);
                break;
            default : $string .= $this->creativeworkseason_type($vars, $article);
        }
        return $string;
    }

    protected function course_type($vars, $article)
    {
        $string = "";
        if ($vars->ratingCount > 0) {
            $string .= '<script type="application/ld+json">{
      "@context": "https://schema.org/",
      "@type": "Course",
      "name": "'.$vars->pname.'",
      "description": "'.$vars->pdescription.'",
      "provider": {
        "@type": "Organization",
        "name": "'.$vars->yrvotebrand.'",
        "sameAs": "'.JUri::base().'"
      },
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "' . $vars->ratingValue . '",
        "bestRating": "5",
        "worstRating": "1",
        "ratingCount": "' . $vars->ratingCount . '"
      }
      }
}</script>';
        }
        return $string;
    }

    protected function creativeworkseason_type($vars, $article)
    {
        $string = "";
        if ($vars->ratingCount > 0) {
            $string .= ' <script type="application/ld+json">{"@context":"http://schema.org","@type":"CreativeWorkSeason","name":"' . $article->title . '","aggregateRating":{"@type":"AggregateRating","ratingValue":"' . $vars->ratingValue . '","ratingCount":"' . $vars->ratingCount . '","bestRating":"5","worstRating":"1"}}</script>';
        }
        return $string;
    }

    protected function product_type($vars, $article){
        $string = "";
         if ($vars->ratingCount > 0) {
             $string .= '<script type="application/ld+json">{
      "@context": "https://schema.org/",
      "@type": "Product",
      "brand": {
        "@type": "Brand",
        "name": "' . $vars->yrvotebrand . '"
      },
      "description": "' . $vars->pdescription . '",
      "name": "' . $vars->pname . '",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "' . $vars->ratingValue . '",
        "bestRating": "5",
        "worstRating": "1",
        "ratingCount": "' . $vars->ratingCount . '"
      }
      }
}</script>';
         }
         return $string;

    }

//    protected function insert_stars($vars, $article)
//    {
//        $agregate = ($vars->ratingCount > 0) ? 'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"' : "";
//        // itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
//
//        $string = '<div itemscope itemtype="https://schema.org/Product">
//       <div class="yrvote_box" style="height: '. ($vars->yrvotestarsize + 20) . 'px"  data-rating="' . number_format($vars->ratingValue, 1) . '"><div class="yrvote '.$vars->yrvotealign.'" data="" id="yrvote" ' . $agregate . ' >';
//        $string .= '<meta itemprop="ratingValue" content="' . $vars->ratingValue . '">';
//        $string .= '<meta content="' . $vars->ratingCount . '" itemprop="ratingCount">';
//
//        $string .= '<div class="yrvoteimg" style="width:'. $vars->yrvotestarsize * 6 .'px" data-text="'.$vars->yrvotetext.'" data-textcolor="'.$vars->yrvotetextcolor.'" data-active="' . $vars->active . '" data-off="' . $vars->off . '">';
//        for ($i = 1; $vars->int_rate >= $i; $i++) {
//
//            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->active . '"><span  style="font-size: '.$vars->yrvotestarsize.'px" class="' . $vars->active . '"></span></span>';
//        }
//        if ($vars->half_rate == true) {
//            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->half_active . '"><span  style="font-size: '.$vars->yrvotestarsize.'px" class="' . $vars->half_active . '"></span></span>';
//            $i++;
//        }
//        for ($i; 5 >= $i; $i++) {
//            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->off . '"><span  style="font-size: '.$vars->yrvotestarsize.'px" class="' . $vars->off . '"></span></span>';
//        }
//
//        $string .= '<meta itemprop="bestRating" content="5" />
//    <meta itemprop="worstRating" content="1" /></div>';
//        $show = 1;
//        if (isset($_COOKIE["yrvotevotes"])) {
//            $show = (int)$_COOKIE["yrvotevotes"];
//        }
//        $hide_show = ($show == 1) ? "" : "display:none;";
//        if ($vars->yrvotecount == 1 && $this->homepage == false)
//            $string .= '<div class="yrvotetotal"  style="color:' . $vars->yrvotetextcolor . '; ' . $hide_show . '">' . $vars->ratingValue . ' ' . JText::_("YRVOTE_OF") . ' 5 (' . $vars->ratingCount . ' ' . $vars->votes . ')</div>';
//
//        $string .= '<input type="hidden" class="ittoken" value="1" name="' . JSession::getFormToken() . '">';
//        $string .= '</div></div>';
//        $string .= '<span style="visibility:hidden;" itemprop="brand">' . $this->getparams->yrvotebrand . '</span><meta itemprop="name" content="' . $article->title . '" />';
//        $string .= "</div>";
//
//        return $string;
//    }

    protected function insert_script($document, $vars)
    {
        $function = ' jQuery.thankyou = function thankyou(data,yrvoteimgclass) {
                setTimeout(function(){
                    var itrating = jQuery(data).find("#yrvote:first");
                    if (itrating.length > 0) {
                    
                    yrvoteimgclass.find(".yrvote-star").off("click").off("hover");
                    yrvoteimgclass.parents(".yrvote_box").html(itrating);
                    }
<<<<<<< HEAD
                },1000);
=======

                },1000); 
>>>>>>> 4e3203d44bc7626be500224e5ca6fc46ce906c25
               }';
        $document->addScriptDeclaration($function);
        $uri = clone JUri::getInstance();
        $uri->setVar('hitcount', '0');
        $url = htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8');
        $script = 'jQuery(document).ready(function () {';
        $script .= 'function clicc_rating(){jQuery(".yrvoteimg").find(".yrvote-star").click(function(){';
        $script .= 'var datadiv = jQuery(this).parents(".yrvoteimg");';
        $script .= 'var textcolor = jQuery(datadiv).data("textcolor");';
        $script .= 'var texttext = jQuery(datadiv).data("text");';
        $script .= 'var yrvoteimgclass = jQuery(this).parents(".yrvoteimg:first");';
        $script .= 'var h = yrvoteimgclass.height();';
        $script .= 'yrvoteimgclass.css({"height": h, "color":textcolor}).html(texttext);';
        $script .= 'var vote = jQuery(this).data("vote");';
        $script .= 'jQuery.ajax({';
        $script .= 'url: "' . $url . '",';
        $script .= 'dataType: "html",';
        $script .= 'type: "POST",';
        $script .= 'data: {user_rating: vote, task: "article.vote", hitcount:0, submit_vote: "val", url:"' . $url . '", "' . JSession::getFormToken() . '":1},';
        $script .= 'success: function (data) {';
        $script .= ' jQuery.thankyou(data,yrvoteimgclass);';
        $script .= ' }';
        $script .= '     });';
        $script .= '});';
        $script .= '}clicc_rating();';
        $script .= '});';
        $document->addScriptDeclaration($script);
    }

    protected function load_lang_file()
    {
        $lang = Factory::getApplication()->getLanguage();
        switch ($lang->get("tag")) {
            case "it-IT":
                $language_tag = 'it-IT';
                break;
            case "ru-RU":
                $language_tag = 'ru-RU';
                break;
            default :
                $language_tag = 'en-GB';
                break;
        }
        $reload = true;
        $lang->load("plg_content_yrvote", JPATH_SITE . "/plugins/content/yrvote", $language_tag, $reload);
    }
}

?>
