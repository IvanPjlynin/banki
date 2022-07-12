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
<?php $item->tags = new JHelperTags; ?>
<?php $item->tags->getItemTags('com_content.article', $item->id); ?>
<?php if (!empty($item->tags->itemTags)) : ?>
    <?php foreach ($item->tags->itemTags as $tag) : ?>
      <?php $tagBgColor = ''; ?>
      <?php if ($tag->title === 'ОСАГО'): ?>
         <div class="article-tag purple"><?php echo $tag->title; ?></div>
      <?php elseif ($tag->title === 'Здоровье'): ?>
         <div class="article-tag pink"><?php echo $tag->title; ?></div>
      <?php else: ?>
         <div class="article-tag orange"><?php echo $tag->title; ?></div>
      <?php endif; ?>
    <?php endforeach; ?>
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

<?php if ($params->get('img_intro_full') !== 'none' && !empty($item->imageSrc)) : ?>
	<figure class="newsflash-image">
		<?php echo LayoutHelper::render(
			'joomla.html.image',
			[
				'src' => $item->imageSrc,
				'alt' => $item->imageAlt,
			]
		); ?>
		<img src="<?php echo $item->imageSrc; ?>" alt="<?php echo $item->imageAlt; ?>">
		<?php if (!empty($item->imageCaption)) : ?>
			<figcaption>
				<?php echo $item->imageCaption; ?>
			</figcaption>
		<?php endif; ?>
	</figure>
<?php endif; ?>

<?php if (!$params->get('intro_only')) : ?>
	<?php echo $item->afterDisplayTitle; ?>
<?php endif; ?>

<?php echo $item->beforeDisplayContent; ?>

<?php if ($params->get('show_introtext', 1)) : ?>
	<?php echo $item->introtext; ?>
<?php endif; ?>

<?php echo $item->afterDisplayContent; ?>

<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
	<?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $item->params, 'link' => $item->link)); ?>
<?php endif; ?>
