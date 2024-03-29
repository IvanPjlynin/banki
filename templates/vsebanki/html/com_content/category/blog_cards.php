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
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create a shortcut for params.
$params = $this->item->params;
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
	|| ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);

?>
<?php
         $this->item->extrafields = array();
         if (isset($this->item->jcfields) && is_array($this->item->jcfields)) {
            foreach ($this->item->jcfields as $field) {
		       if (!empty($field->rawvalue)) {
			      $this->item->extrafields[$field->name] = $field;
		       }
	        }
         }
      ?>

<div class="item-content row eq cards" data-summ='<?php echo $this->item->extrafields['kreditnyj-limit']->value; ?>' data-stavka='<?php echo $this->item->extrafields['stavka-kredit']->value; ?>' data-sroc='<?php echo $this->item->extrafields['lgotnyj-period']->value; ?>' data-id='<?php echo $this->item->id; ?>'>
    <?php if ($isUnpublished) : ?>
    <div class="system-unpublished">
        <?php endif; ?>
        <?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>

        <div class="col-12 col-sm-12 col-md-3 column bank-logo">
            <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
            <?php if ($this->item->extrafields['nazvanie-produkta']->value) : ?>
            <h4 class="fs-4"><?php echo $this->item->extrafields['nazvanie-produkta']->value; ?></h4>
            <?php endif; ?>
        </div>
        <div class="col-12 col-sm-12 col-md-4 column bank-fields">

            <div class="bank-field summa">
                <div class="bank-field-name"><?php echo $this->item->extrafields['kreditnyj-limit']->title; ?></div>
                <div class="bank-field-value">до <?php echo number_format($this->item->extrafields['kreditnyj-limit']->value, 0, ',', ' '); ?> ₽</div>
            </div>
            <div class="bank-field srok">
                <div class="bank-field-name"><?php echo $this->item->extrafields['lgotnyj-period']->title; ?></div>
                <div class="bank-field-value">до <?php echo $this->item->extrafields['lgotnyj-period']->value; ?> дн.</div>
            </div>
            <div class="bank-field stavka">
                <div class="bank-field-name">Ставка</div>
                <div class="bank-field-value">от <?php if ($this->item->extrafields['stavka-kredit']->value){ echo $this->item->extrafields['stavka-kredit']->value; } else { echo '0';} ?> %</div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-5 column bank-tags">
            <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
            <?php endif; ?>
            <div class="buttons">
                <a class="button-full" href="<?php echo Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)); /*echo $this->item->category_route.'/'.$this->item->alias;*/ ?>"><?php echo JText::_('BANK_FULL_LINK'); ?></a>
                <a class="button-full-send" href="<?php echo $this->item->extrafields['ssylka-na-ofer-banka']->value; ?>"><?php echo JText::_('BANK_FULL_SEND_LINK'); ?></a>
            </div>
        </div>


        <?php if ($canEdit) : ?>
        <?php echo LayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item)); ?>
        <?php endif; ?>

        <?php // Todo Not that elegant would be nice to group the params ?>
        <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

        <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
        <?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
        <?php endif; ?>

        <?php if (!$params->get('show_intro')) : ?>
        <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
        <?php echo $this->item->event->afterDisplayTitle; ?>
        <?php endif; ?>

        <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
        <?php echo $this->item->event->beforeDisplayContent; ?>

        <?php echo $this->item->introtext; ?>

        <?php if ($info == 1 || $info == 2) : ?>
        <?php if ($useDefList) : ?>
        <?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
        <?php endif; ?>
        <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
        <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
        <?php endif; ?>
        <?php endif; ?>

        <?php if ($params->get('show_readmore') && $this->item->readmore) :
		if ($params->get('access-view')) :
			$link = Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
		else :
			$menu = Factory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
		endif; ?>

        <?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

        <?php endif; ?>

        <?php if ($isUnpublished) : ?>
    </div>
    <?php endif; ?>

    <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
    <?php echo $this->item->event->afterDisplayContent; ?>
</div>
