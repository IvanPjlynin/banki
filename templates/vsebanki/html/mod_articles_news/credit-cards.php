<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

if (!$list)
{
	return;
}

?>
<div class="mod-articlesnews newsflash row eq">
	<?php foreach ($list as $item) : ?>
		<div class="col-12 col-sm-12 col-md-4 mod-articlesnews__item" itemscope itemtype="https://schema.org/Article">
			<div class="article-wrapper">
			   <?php require ModuleHelper::getLayoutPath('mod_articles_news', '_item-credit-cards'); ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<div class="row">
   <div class="col-12 col-sm-12 col-md-4 offset-md-4">
      <a class="articles-button" href="karty/kreditnye-karty" target="_blank">Все предложения</a>
   </div>
</div>
