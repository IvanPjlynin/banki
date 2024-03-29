<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Layout\LayoutHelper;
?>
<?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
	<figure class="newsflash-image">
		<img src="<?php echo $item->imageSrc; ?>" alt="<?php echo $item->imageAlt; ?>">
		<?php if (!empty($item->imageCaption)) : ?>
			<figcaption>
				<?php echo $item->imageCaption; ?>
			</figcaption>
		<?php endif; ?>
	</figure>
<?php endif; ?>

<?php if ($params->get('item_title')) : ?>

	<?php $item_heading = $params->get('item_heading', 'h4'); ?>
	<<?php echo $item_heading; ?> class="newsflash-title">
	<?php if ($item->link !== '' && $params->get('link_titles')) : ?>
		<a href="<?php echo $item->link; ?>">
			<?php echo $item->title; ?>
		</a>
	<?php else : ?>
		<?php echo $item->title; ?>
	<?php endif; ?>
	</<?php echo $item_heading; ?>>
<?php endif; ?>

<?php if (!$params->get('intro_only')) : ?>
	<?php echo $item->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $item->beforeDisplayContent; ?>

<?php if ($params->get('show_introtext', 1)) : ?>
	<?php echo $item->introtext; ?>
<?php endif; ?>

<?php echo $item->afterDisplayContent; ?>

<?php
         $item->extrafields = array();
         if (isset($item->jcfields) && is_array($item->jcfields)) {
            foreach ($item->jcfields as $field) {
		       if (!empty($field->rawvalue)) {
			      $item->extrafields[$field->name] = $field;
		       }
	        }
         }
      ?>
      <div class="bank-field summa">
         <div class="bank-field-name"><?php echo $item->extrafields['kreditnyj-limit']->title; ?></div>
         <div class="bank-field-value"><?php echo number_format($item->extrafields['kreditnyj-limit']->value, 0, ',', ' '); ?></div>
      </div>
      <div class="bank-field srok credit-cards">
         <div class="bank-field-name"><?php echo $item->extrafields['lgotnyj-period']->title; ?></div>
         <div class="bank-field-value"><?php echo $item->extrafields['lgotnyj-period']->value; ?></div>
      </div>
      <div class="bank-field stavka credit-cards">
         <div class="bank-field-name">Проценты</div>
         <div class="bank-field-value"><?php echo $item->extrafields['stavka-kredit']->value; ?> %</div>
      </div>
<?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $item->params, 'link' => $item->link)); ?>