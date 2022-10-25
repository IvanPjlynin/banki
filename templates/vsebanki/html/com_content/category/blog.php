<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout; 

$app = Factory::getApplication();
$menu = $app->getMenu()->getActive()->id;


$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

jimport('joomla.application.module.helper');
$moduleTabs = JModuleHelper::getModules('tab-menu');
$moduleFilter = JModuleHelper::getModules('filter');
$moduleSubzag = JModuleHelper::getModules('subzag');
$moduleBestdeals = JModuleHelper::getModules('bestdeals-blog');
$attribs['style'] = 'none';

?>
<div class="com-content-category-blog blog menu_id_<? echo $menu;?>" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>

        <?php echo JModuleHelper::renderModule($moduleSubzag[0], $attribs); ?>

        <?php 
        $id_menu = '114,115,118,122,123,124,125,130,131,134,142,145';
        if(in_array($menu, explode(',',$id_menu)) )
        /*if (($menu == '118') || ($menu == '145') || ($menu == '114') || ($menu == '142') || ($menu == '115') || ($menu == '122') || ($menu == '123') || ($menu == '124'))*/ : ?>
        <?php echo '<h3 class="cat-subzag">Сравнить предложения</h3>'; ?>
        <?php endif; ?>




    </div>
    <?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1)) : ?>
    <<?php echo $htag; ?>>
        <?php echo $this->category->title; ?>
    </<?php echo $htag; ?>>
    <?php endif; ?>
    <?php echo $afterDisplayTitle; ?>

    <?php echo JModuleHelper::renderModule($moduleTabs[0], $attribs); ?>
    <?php echo JModuleHelper::renderModule($moduleFilter[0], $attribs); ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
    <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
    <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items) && ($menu != '129') && ($menu != '128') && ($menu != '127')) : ?>
    <?php if ($this->params->get('show_no_articles', 1)) : ?>
    <!--<div class="alert alert-info">
        <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
        <?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
    </div>-->

    <div class="com-content-category-blog__items blog-items ">
        <div class="com-content-category-blog__item blog-item" itemprop="blogPost" itemscope="" itemtype="https://schema.org/BlogPosting">


        </div>
    </div>



    <?php endif; ?>
    <?php endif; ?>

    <?php $leadingcount = 0; ?>
    <?php if (!empty($this->lead_items)) : ?>
    <div class="com-content-category-blog__items blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>">
        <?php foreach ($this->lead_items as &$item) : ?>
        <div class="com-content-category-blog__item blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
            <?php $this->item = & $item; 
                           echo $this->loadTemplate('item');
                        ?>
        </div>
        <?php $leadingcount++; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

    <?php if (!empty($this->intro_items)) : ?>
    <?php $blogClass = $this->params->get('blog_class', ''); ?>
    <?php if ((int) $this->params->get('num_columns') > 1) : ?>
    <?php $blogClass .= (int) $this->params->get('multi_column_order', 0) === 0 ? ' masonry-' : ' columns-'; ?>
    <?php $blogClass .= (int) $this->params->get('num_columns'); ?>
    <?php endif; ?>


    <?php if ($menu == '134') : ?>

    <?php
            $assetManager = Factory::getApplication()->getDocument()->getWebAssetManager();
            $assetManager->registerAndUseScript('tinysort', 'https://cdnjs.cloudflare.com/ajax/libs/tinysort/3.2.5/tinysort.min.js', []);
        ?>


    <div class="jlmf-section filtr-sort no-filter">
        <label class="jlmf-label" for="jlcontentfieldsfilter-ordering-109">Сортировка</label>
        <select id="jlcontentfieldsfilter-ordering-109" name="jlcontentfieldsfilter[ordering]" class="jlmf-select filtr-sort-select">
            <option value="id.desc" selected="selected">По умолчанию</option>
            <option value="summ.asc">Стоимость (по возрастанию)</option>
            <option value="summ.desc">Стоимость (по убыванию)</option>
        </select>
    </div>


    <?php endif; ?>



    <div class="com-content-category-blog__items blog-items <?php echo $blogClass; ?>">



        <?php foreach ($this->intro_items as $key => &$item) : ?>
        <div class="com-content-category-blog__item blog-item" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">

            <?php /*print_r($menu);*/ ?>

            <?php $this->item = & $item; ?>
            <?php if (($menu == '109') || ($menu == '114') || ($menu == '115') || ($menu == '142')) : ?>
            <?php echo $this->loadTemplate('item'); ?>
            <?php elseif (($menu == '118') || ($menu == '145')) : ?>
            <?php echo $this->loadTemplate('zajm'); ?>
            <?php elseif ($menu == '122') : ?>
            <?php echo $this->loadTemplate('cards'); ?>
            <?php elseif ($menu == '123') : ?>
            <?php echo $this->loadTemplate('cards-debit'); ?>
            <?php elseif ($menu == '124') : ?>
            <?php echo $this->loadTemplate('vklady'); ?>
            <?php elseif ($menu == '125') : ?>
            <?php echo $this->loadTemplate('investicii'); ?>
            <?php elseif (($menu == '127') || ($menu == '128') || ($menu == '129')) : ?>
            <?php echo $this->loadTemplate('strahovka'); ?>
            <?php elseif (($menu == '130') || ($menu == '131')) : ?>
            <?php echo $this->loadTemplate('ipoteka'); ?>
            <?php elseif ($menu == '134') : ?>
            <?php echo $this->loadTemplate('rco'); ?>
            <?php else: ?>
            <?php echo $this->loadTemplate('news'); ?>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
    <div class="category-desc clearfix">
        <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
        <?php $alt = empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? '' : 'alt="' . htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8') . '"'; ?>
        <img src="<?php echo $this->category->getParams()->get('image'); ?>" <?php echo $alt; ?>>
        <?php endif; ?>
        <?php echo $beforeDisplayContent; ?>
        <?php if ($this->params->get('show_description') && $this->category->description) : ?>
        <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
        <?php endif; ?>
        <?php echo $afterDisplayContent; ?>
    </div>
    <?php endif; ?>

    <div class="bestdeals">
        <div class="container">
            <?php echo JModuleHelper::renderModule($moduleBestdeals[0], $attribs); ?>
        </div>
    </div>

    <?php if (!empty($this->link_items)) : ?>
    <div class="items-more">
        <?php echo $this->loadTemplate('links'); ?>
    </div>
    <?php endif; ?>

    <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
    <div class="com-content-category-blog__children cat-children">
        <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
        <h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
        <?php endif; ?>
        <?php echo $this->loadTemplate('children'); ?>
    </div>
    <?php endif; ?>
    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
    <div class="com-content-category-blog__navigation w-100">
        <?php if ($this->params->def('show_pagination_results', 1)) : ?>
        <p class="com-content-category-blog__counter counter float-end pt-3 pe-2">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php endif; ?>
        <div class="com-content-category-blog__pagination">
            <?php echo $this->pagination->getPagesLinks(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
