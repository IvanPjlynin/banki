<?php

/**
 * @extensione  YRVote Plugin for Marlev Template ONLY!
 * @author      Lev Milicenco
 * @copyright   (c) Marlev.it - Itroom SRLS - 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * WARNING - Don't use it without Template by Marlev
 */
defined('_JEXEC') or die;

class plgContentYrvote extends JPlugin {

    protected $homepage = false;

    public function onContentPrepare($context, &$article, &$params, $limitstart = 0) {

        $content = $this->check_if_content($context, $article);
        if ($content == false)
            return false;

        $regex = "#{yrvote}#";
        preg_match_all($regex, $article->text, $matches, PREG_PATTERN_ORDER);

        if (isset($matches[0][0])) {
            $this->homepage = $this->if_is_homepage();
            $document = $this->add_head();
            $vars = $this->prepare_vars($article, $params);

            foreach ($matches[0] as $value) {
                $string = $this->insert_stars($vars);
                $article->text = str_replace($value, $string, $article->text);
            }
            $this->sctipt_to_html($document, $vars);
        }
    }
    

    public function onContentBeforeDisplay($context, &$article, &$params, $page = 0) {
        $vote_plugin = JPluginHelper::getPlugin('content', 'vote');
        $content = $this->check_if_content($context, $article);

        if ($content == false || $vote_plugin)
            return false;

        if (!empty($params) && $params->get('show_vote', null)) {

            $this->homepage = $this->if_is_homepage();
            $document = $this->add_head();
            $vars = $this->prepare_vars($article, $params);


            $this->sctipt_to_html($document, $vars);
            $string = $this->insert_stars($vars);
            return $string;
        }
    }
    
    public function onContentAfterDisplay($context, &$article, &$params, $limitstart = 0) {

        $content = $this->check_if_content($context, $article);
        if ($content == false)
            return false;

        $regex = "#{yrvote}#";
        preg_match_all($regex, $article->text, $matches, PREG_PATTERN_ORDER);

        if (isset($matches[0][0])) {
            $this->homepage = $this->if_is_homepage();
            $document = $this->add_head();
            $vars = $this->prepare_vars($article, $params);

            foreach ($matches[0] as $value) {
                $string = $this->insert_stars($vars);
                $article->text = str_replace($value, $string, $article->text);
            }
            $this->sctipt_to_html($document, $vars);
        }
    }


    protected function sctipt_to_html($document, $vars) {
        if ($this->homepage == false) {
            $input = JFactory::getApplication()->input;
            if ($input->getString('view', '') === 'article') { //Aded
                $this->insert_script($document, $vars);
            }
        }
    }

    protected function if_is_homepage() {
        $app = JFactory::getApplication();
        $menu = $app->getMenu();
        $lang = JFactory::getLanguage();

        if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
            return true;
        } else {
            return false;
        }
    }

    protected function add_head() {
        JPlugin::loadLanguage('yrvote');
        $document = JFactory::getDocument();
        $input = JFactory::getApplication()->input;
        if ($this->homepage == false && $input->getString('view', '') === 'article') { //Added
            JHtml::_('jquery.framework');
            $document->addScript(JURI::base() . "plugins/content/yrvote/incl/js.js");
        }
        $document->addStyleSheet('plugins/content/yrvote/incl/css.css');
        $document->addStyleSheet('plugins/content/yrvote/awesome/css/font-awesome.min.css');
        return $document;
    }

    protected function check_if_content($context, $article) {
        $parts = explode(".", $context);
        if ($parts[0] === 'com_content' && (isset($article->state) && $article->state == 1)) { //aded
            return true;
        } else
            return false;
    }

    protected function get_params() {
        $return = new stdClass();
        $return->style = $this->params->get('yrvotestyle', "blue");
        $return->count = $this->params->get('yrvotecount', 1);
        $return->color = $this->params->get('yrvotetextcolor', "#a6adb3");
        $return->message = $this->params->get('yrvotetext', JText::_("YRVOTE_THANKS"));
        return $return;
    }

    protected function prepare_vars($article, $params) {

        $tparam = $this->get_params();
        $return = $tparam;
        if (isset($_COOKIE["yrvotestyle"])){
            $tparam->style = (string) preg_replace('/[^A-Z0-9_\.-]/i', '', $_COOKIE["yrvotestyle"]);
        }

        $return->active = 'yractive fa fa-star ' . $tparam->style;
        $return->half_active = 'yrhalf fa fa-star ' . $tparam->style;
        $return->off = 'yroff fa fa-star ' . $tparam->style;
        $return->showcount = $tparam->count;
        $return->title = $article->title;
        $get_rats = $this->rating_sum($article->id);

        $return->ratingCount = (isset($get_rats[0]->rating_count)) ? $get_rats[0]->rating_count : 0;
        if ($return->ratingCount > 0) {
            $return->ratingValue = round(($get_rats[0]->rating_sum) / $return->ratingCount, 1);
        } else {
            $return->ratingValue = "0.0";
        }


        $make_rating = explode(".", $return->ratingValue);
        $return->int_rate = $make_rating[0];
        $dec_rate = (isset($make_rating[1])) ? $make_rating[1] : 0;
        $return->half_rate = false;
        
            //setcookie("lg", "ro");

        if ($dec_rate > 0) {

            $return->half_rate = true;
            if ($dec_rate <= 3) {
                $return->half_active = 'yrhalf3 fa fa-star ' . $tparam->style;
            } elseif ($dec_rate <= 5) {
                $return->half_active = 'yrhalf5 fa fa-star ' . $tparam->style;
            } elseif ($dec_rate <= 9) {
                $return->half_active = 'yrhalf7 fa fa-star ' . $tparam->style;
            }
        } else {
            $return->int_rate = $return->int_rate;
        }

        $return->votes = ($return->ratingCount == 1) ? JText::_("YRVOTE_VOTE") : JText::_("YRVOTE_VOTES");

        return $return;
    }

    protected function rating_sum($artid) {
        $artid = (int) $artid;
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('rating_sum,rating_count');
        $query->from('#__content_rating');
        $query->where('content_id=' . $db->Quote($artid));
        $db->setQuery($query);
        $sum = $db->loadObjectList();
        return $sum;
    }

    protected function insert_stars($vars) {
        $agregate = ($vars->ratingCount > 0)? 'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"':"";
        // itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        $string = '<div class="yrvote_box" data-rating="' . number_format($vars->ratingValue, 1) . '"><div class="yrvote" data="" id="yrvote" '.$agregate.' >
';

        $string .= '<meta itemprop="bestRating" content="5" />
    <meta itemprop="worstRating" content="1" />';
        $show = 1;
         if (isset($_COOKIE["yrvotevotes"])){
            $show = (int) $_COOKIE["yrvotevotes"];
        }
        $hide_show = ($show == 1)?"":"display:none;";
        if ($vars->count == 1 && $this->homepage == false)
            $string .= '<div class="yrvotetotal"  style="color:' . $vars->color . '; '.$hide_show.'">' . $vars->ratingValue . '</div>';

       $string .= '<meta itemprop="ratingValue" content="' . $vars->ratingValue . '">';
        $string .= '<meta content="' . $vars->ratingCount . '" itemprop="ratingCount">';
        
        $string .= '<div class="yrvoteimg" data-active="' . $vars->active . '" data-off="' . $vars->off . '">';
        for ($i = 1; $vars->int_rate >= $i; $i++) {

            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->active . '"><span class="' . $vars->active . '"></span></span>';
        }
        if ($vars->half_rate == true) {
            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->half_active . '"><span class="' . $vars->half_active . '"></span></span>';
            $i++;
        }
        for ($i; 5 >= $i; $i++) {
            $string .= '<span class="yrvote-star yrstar-' . $i . '" data-vote="' . $i . '" data-default="' . $vars->off . '"><span class="' . $vars->off . '"></span></span>';
        }
        $string .= '<input type="hidden" class="ittoken" value="1" name="' . JSession::getFormToken() . '">';
        $string .= '</div></div></div>';

        return $string;
    }

    protected function insert_script($document, $vars) {
        $function = ' jQuery.thankyou = function thankyou(data,yrvoteimgclass) {


                setTimeout(function(){
                    var itrating = jQuery(data).find("#yrvote:first");
                    if (itrating.length > 0) {
                    
                    yrvoteimgclass.find(".yrvote-star").off("click").off("hover");
                    yrvoteimgclass.parents(".yrvote_box").html(itrating);
                    }

                },1000); 
               }';
        $document->addScriptDeclaration($function);
        $uri = clone JUri::getInstance();
        $uri->setVar('hitcount', '0');
        $url = htmlspecialchars($uri->toString(), ENT_COMPAT, 'UTF-8');
        $script = 'jQuery(document).ready(function () {';
        $script .= 'function clicc_rating(){jQuery(".yrvoteimg").find(".yrvote-star").click(function(){';
        $script .= 'var yrvoteimgclass = jQuery(this).parents(".yrvoteimg:first");';
        $script .= 'var h = yrvoteimgclass.height();';
        $script .= 'yrvoteimgclass.css({"height": h, color:"' . $vars->color . '"}).html("' . $vars->message . '");';
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

}

?>
