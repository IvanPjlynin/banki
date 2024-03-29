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
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create shortcuts to some parameters.
$params  = $this->item->params;
$canEdit = $params->get('access-edit');
$user    = Factory::getUser();
$info    = $params->get('info_block_position', 0);
$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

// Check if associations are implemented. If they are, define the parameter.
$assocParam        = (Associations::isEnabled() && $params->get('show_associations'));
$currentDate       = Factory::getDate()->format('Y-m-d H:i:s');
$isNotPublishedYet = $this->item->publish_up > $currentDate;
$isExpired         = !is_null($this->item->publish_down) && $this->item->publish_down < $currentDate;

//Custom fields generated
$this->item->extrafields = array();
if (isset($this->item->jcfields) && is_array($this->item->jcfields)) {
   foreach ($this->item->jcfields as $field) {
      if (!empty($field->rawvalue)) {
         $this->item->extrafields[$field->name] = $field;
      }
   }
}
//Module position generated
jimport('joomla.application.module.helper');
$moduleBestdeals = JModuleHelper::getModules('bestdeals-blog');
$attribs['style'] = 'none';
?>
<div class="com-content-article item-page<?php echo $this->pageclass_sfx; ?> credit kreditnye-karty" itemscope itemtype="https://schema.org/Article">
    <meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? Factory::getApplication()->get('language') : $this->item->language; ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
        <h1><?php echo $this->item->extrafields['nazvanie-organizatsii']->value; ?> <?php echo ($this->item->extrafields['nazvanie-produkta']->value) ? ' - '.$this->item->extrafields['nazvanie-produkta']->value : '';?></h1>
        <h3>Получите ипотеку в <?php echo $this->item->extrafields['nazvanie-organizatsii']->value; ?> в Санкт-Петербурге</h3>

        <?php if ($this->item->extrafields['kredit-pod-zalog']->value) : ?>
        <h3>Под залог - <?php echo $this->item->extrafields['kredit-pod-zalog']->value; ?></h3>
        <?php endif; ?>

    </div>
    <?php endif;
	if (!empty($this->item->pagination) && !$this->item->paginationposition && $this->item->paginationrelative)
	{
		echo $this->item->pagination;
	}
	?>

    <?php $useDefList = $params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam; ?>

    <?php if ($params->get('show_title')) : ?>
    <div class="page-header">
        <<?php echo $htag; ?> itemprop="headline">
            <?php echo $this->escape($this->item->title); ?>
        </<?php echo $htag; ?>>
        <?php if ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED) : ?>
        <span class="badge bg-warning text-light"><?php echo Text::_('JUNPUBLISHED'); ?></span>
        <?php endif; ?>
        <?php if ($isNotPublishedYet) : ?>
        <span class="badge bg-warning text-light"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
        <?php endif; ?>
        <?php if ($isExpired) : ?>
        <span class="badge bg-warning text-light"><?php echo Text::_('JEXPIRED'); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($canEdit) : ?>
    <?php echo LayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item)); ?>
    <?php endif; ?>

    <?php // Content is generated by content plugin event "onContentAfterTitle" ?>
    <?php echo $this->item->event->afterDisplayTitle; ?>

    <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
    <?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
    <?php endif; ?>

    <?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
    <?php echo $this->item->event->beforeDisplayContent; ?>

    <?php if ((int) $params->get('urls_position', 0) === 0) : ?>
    <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    <?php if ($params->get('access-view')) : ?>

    <?php
	if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative) :
		echo $this->item->pagination;
	endif;
	?>
    <?php if (isset ($this->item->toc)) :
		echo $this->item->toc;
	endif; ?>
    <div itemprop="articleBody" class="com-content-article__body">
        <div class="bank-info">
            <div class="row bank-info-row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 column rating">
                    <div class="rating-title"><?php echo JText::_('RATING'); ?></div>
                    <?php echo $this->item->extrafields['rejting']->value; ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 column bank-logo">
                    <?php echo LayoutHelper::render('joomla.content.full_image', $this->item); ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 column bank-fields">
                    <div class="bank-field summa">
                        <div class="bank-field-name">Сумма кредита</div>
                        <div class="bank-field-value">до <?php echo number_format($this->item->extrafields['summa-ipoteka']->value, 0, ',', ' '); ?> ₽</div>
                    </div>
                    <div class="bank-field srok">
                        <div class="bank-field-name">Срок</div>
                        <div class="bank-field-value">до <?php echo $this->item->extrafields['srok-2']->value; ?> мес.</div>
                    </div>

                    <div class="bank-field stavka">
                        <div class="bank-field-name">Ставка</div>
                        <div class="bank-field-value">
                            от <?php echo $this->item->extrafields['stavka-bez-strakhovki-ot-4']->value; ?> %
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bank-tags">
                    <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                    <?php $this->item->tagLayout = new FileLayout('joomla.content.tags'); ?>
                    <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="bank-info-full">
            <?php /*echo $this->item->text;*/ ?>

            <div class="rl_tabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-stavki" data-bs-toggle="tab" data-bs-target="#tab-stavki-tab" type="button" role="tab" aria-controls="tab-stavki" aria-selected="true">Ставки</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-trebovaniya" data-bs-toggle="tab" data-bs-target="#tab-trebovaniya-tab" type="button" role="tab" aria-controls="tab-trebovaniya" aria-selected="false">Требования</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab-dopolnitelno" data-bs-toggle="tab" data-bs-target="#tab-dopolnitelno-tab" type="button" role="tab" aria-controls="tab-dopolnitelno" aria-selected="false">Дополнительно</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tab-stavki-tab" role="tabpanel" aria-labelledby="tab-stavki">
                        <div class="row tab-text">


                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Сумма</h3>
                                <p class="tab-text-block-content">
                                    <?php
                                    if($this->item->extrafields['summa-ot']->value){
                                        echo 'от '.number_format($this->item->extrafields['summa-ot']->value, 0, ',', ' ').' ₽ <br>';
                                    }
                                    
                                    if($this->item->extrafields['summa-ipoteka']->value){
                                        echo 'до '.number_format($this->item->extrafields['summa-ipoteka']->value, 0, ',', ' ').' ₽ ';
                                    }
                                    ?>
                                </p>
                            </div>


                            <?php if ($this->item->extrafields['srok-ot-2']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Срок</h3>
                                <p class="tab-text-block-content">от <?php echo $this->item->extrafields['srok-ot-2']->value; ?> до <?php echo $this->item->extrafields['srok-2']->value; ?> мес.</p>
                            </div>
                            <?php endif; ?>


                            <?php if ($this->item->extrafields['stavka-bez-strakhovki-ot']->value || $this->item->extrafields['stavka-bez-strakhovki-ot-2']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Ставка без страховки</h3>
                                <p class="tab-text-block-content">
                                    <?php if ($this->item->extrafields['stavka-bez-strakhovki-ot']->value) : ?>
                                    от <?php echo $this->item->extrafields['stavka-bez-strakhovki-ot']->value; ?> %
                                    <?php endif; ?>
                                    <?php if ($this->item->extrafields['stavka-bez-strakhovki-ot-2']->value) : ?>
                                    до <?php echo $this->item->extrafields['stavka-bez-strakhovki-ot-2']->value; ?> %
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['stavka-bez-strakhovki-ot-4']->value || $this->item->extrafields['stavka-bez-strakhovki-ot-3']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Ставка со страховкой</h3>
                                <p class="tab-text-block-content">
                                    <?php if ($this->item->extrafields['stavka-bez-strakhovki-ot-4']->value) : ?>
                                    от <?php echo $this->item->extrafields['stavka-bez-strakhovki-ot-4']->value; ?> %
                                    <?php endif; ?>
                                    <?php if ($this->item->extrafields['stavka-bez-strakhovki-ot-3']->value) : ?>
                                    до <?php echo $this->item->extrafields['stavka-bez-strakhovki-ot-3']->value; ?> %
                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['pervonachalnyj-vznos-ot']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Первоначальный взнос</h3>
                                <p class="tab-text-block-content">от <?php echo $this->item->extrafields['pervonachalnyj-vznos-ot']->value; ?> %</p>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-trebovaniya-tab" role="tabpanel" aria-labelledby="tab-trebovaniya">
                        <div class="row tab-text">

                            <?php if (($this->item->extrafields['vozrast-ot']->value)||($this->item->extrafields['vozrast-do']->value)) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Возраст</h3>
                                <p class="tab-text-block-content">
                                    <?php if ($this->item->extrafields['vozrast-ot']->value){ echo 'от '.$this->item->extrafields['vozrast-ot']->value;} ?>
                                    <?php if ($this->item->extrafields['vozrast-do']->value){ echo 'до '.$this->item->extrafields['vozrast-do']->value;} ?>
                                    лет
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['obshii-stag-rab']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Общий стаж</h3>
                                <p class="tab-text-block-content">
                                    от <?php echo $this->item->extrafields['obshii-stag-rab']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['stazh-raboty-na-poslednem-meste']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Стаж работы на последнем месте</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['stazh-raboty-na-poslednem-meste']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['vash-sovokupnyj-dokhod']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Ваш совокупный доход</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['vash-sovokupnyj-dokhod']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['grazhdanstvo']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Гражданство РФ</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['grazhdanstvo']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['registratsiya']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Регистрация РФ</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['registratsiya']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-dopolnitelno-tab" role="tabpanel" aria-labelledby="tab-dopolnitelno">
                        <div class="row tab-text">

                            <?php if ($this->item->extrafields['ipoteka-doks']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Обязательные документы</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['ipoteka-doks']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['2ndfl']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Подтверждение дохода</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['2ndfl']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['ipoteka-sposob-poluchenia']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Способ получения</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['ipoteka-sposob-poluchenia']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['srok-rassmotreniya']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Срок рассмотрения</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['srok-rassmotreniya']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($this->item->extrafields['litsenziya']->value) : ?>
                            <div class="col-12 col-sm-12 col-md-3 col-lg-3 tab-text-block">
                                <h3 class="tab-text-block-title">Лицензия</h3>
                                <p class="tab-text-block-content">
                                    <?php echo $this->item->extrafields['litsenziya']->value;?>
                                </p>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="button text-center" style="margin-bottom: 40px;"><a class="btn-green" target="_blank" href="<?php echo $this->item->extrafields['ssylka-na-ofer-banka']->value; ?>" style="max-width: 403px;">Оформить ипотеку</a></div>

            <div class="article-content">
                <div class="row">
                    <div class="col-12">
                        <h2>Кредиты в банках Санкт-Петербурга</h2>

                        <p>Кредиты в Санкт-Петербурге отличаются своим разнообразием. Можно найти предложение с минимальными процентными ставками, минимальным набором документов. Взять кредит в Санкт-Петербурге могут люди, которые ранее не пользовались подобным банковским продуктом, граждане с разной КИ.</p>

                        <h3>Как и где оформить кредит в Санкт-Петербурге?</h3>

                        <p>Получить кредит в Санкт-Петербурге можно в:</p>
                        <ul>
                            <li>крупных холдингах (Сбербанк, ВТБ, Альфа банк, Совкомбанк, Почта Банк, Тинькофф);</li>
                            <li>небольших петербургских банках.</li>
                        </ul>
                        <p>При выборе ориентируйтесь на рейтинг и оценку ЦБ РФ. Для физических лиц есть программы, предусматривающие оформление онлайн кредита в Санкт-Петербурге или с выдачей наличных в филиале. Разные требования предъявляются и к пакету документов.</p>
                        <p>В одном случае для потребительского кредита в Санкт-Петербурге достаточно предоставить паспорт и второй документ, в другом — справку о доходах и информацию о постоянном месте работы. Банки Санкт-Петербурга рассматривают вопрос о процентной ставке индивидуально.</p>
                        <h3>Способы оформления заявки на кредит в СПб: онлайн или поход в банк</h3>

                        <p>Проще подается онлайн-заявка на кредит в Санкт-Петербурге. Заполнить анкету можно на нашем сайте или на официальной странице. Вы можете выбрать выгодное предложение, процентную ставку. Сроки рассмотрения кандидатуры для кредита в банках Санкт-Петербурга составляют до недели.</p>

                        <p>Получить кредит в Санкт-Петербурге можно и с оформлением заявки в банке. Принесите в отделение сразу все необходимые документы. Вам предложат лучший кредит с учетом ваших индивидуальных особенностей и КИ.</p>

                        <h3>Как подобрать подходящий кредит в Санкт-Петербурге?</h3>

                        <p>Выгодный кредит в Санкт-Петербурге найдете на сайте Bankiros.ru. Воспользуйтесь калькулятором кредитов для быстрой сортировки по заданным параметрам. Останется:</p>

                        <ul>
                            <li>перейти на страницу понравившегося предложения;</li>
                            <li>подробно изучить условия;</li>
                            <li>нажать «Подать заявку»;</li>
                            <li>заполнить заявку;</li>
                            <li>получить кредит наличными в Санкт-Петербурге..</li>
                        </ul>
                        <p>Оформить кредит в Санкт-Петербурге по такой схеме просто, поскольку есть возможность отправить заявку в несколько учреждений для гарантированного получения одобрения.</p>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <?php if ($info == 1 || $info == 2) : ?>
    <?php if ($useDefList) : ?>
    <?php echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
    <?php endif; ?>
    <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
    <?php $this->item->tagLayout = new FileLayout('joomla.content.tags'); ?>
    <?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
    <?php endif; ?>
    <?php endif; ?>

    <?php
	if (!empty($this->item->pagination) && $this->item->paginationposition && !$this->item->paginationrelative) :
		echo $this->item->pagination;
	?>
    <?php endif; ?>
    <?php if ((int) $params->get('urls_position', 0) === 1) : ?>
    <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    <?php // Optional teaser intro text for guests ?>
    <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
    <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
    <?php echo HTMLHelper::_('content.prepare', $this->item->introtext); ?>
    <?php // Optional link to let them register to see the whole article. ?>
    <?php if ($params->get('show_readmore') && $this->item->fulltext != null) : ?>
    <?php $menu = Factory::getApplication()->getMenu(); ?>
    <?php $active = $menu->getActive(); ?>
    <?php $itemId = $active->id; ?>
    <?php $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
    <?php $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language))); ?>
    <?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>
    <?php endif; ?>
    <?php endif; ?>
    <?php
	if (!empty($this->item->pagination) && $this->item->paginationposition && $this->item->paginationrelative) :
		echo $this->item->pagination;
	?>
    <?php endif; ?>
    <?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
    <?php echo $this->item->event->afterDisplayContent; ?>
</div>
<div class="bestdeals">
    <div class="container">
        <?php echo JModuleHelper::renderModule($moduleBestdeals[0], $attribs); ?>
    </div>
</div>
