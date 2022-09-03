<?php
/**
 * JL Content Fields Filter
 *
 * @version 	2.0.2
 * @author		Joomline
 * @copyright	(C) 2017-2019 Arkadiy Sedelnikov, Joomline. All rights reserved.
 * @license 	GNU General Public License version 2 or later; see	LICENSE.txt
 */

defined('_JEXEC') or die;
$doc = JFactory::getDocument();
if ($params->get('enable_no_jq', 0)) {
	JHtml::_('jquery.framework');
	$doc->addScript(JUri::root().'modules/mod_jlcontentfieldsfilter/assets/javascript/jlcontentfilter.js', array('version' => 'auto'));
} else {
	$doc->addScript(JUri::root().'modules/mod_jlcontentfieldsfilter/assets/javascript/nojq_jlcontentfilter.js', array('version' => 'auto'));
}

$doc->addScriptDeclaration('
	JlContentFieldsFilter.init({
		"autho_send" : '.$autho_send.',
		"form_identifier" : "mod-finder-searchform-'.$module->id.'",
		"ajax" : '.$ajax.',
		"ajax_selector" : "'.$ajax_selector.'",
		"ajax_loader" : "'.$ajax_loader.'",
		"ajax_loader_width" : '.$ajax_loader_width.'
	});
');

if ($params->get('enable_css', 1)) {
	$doc->addStyleSheet(JUri::root().'modules/mod_jlcontentfieldsfilter/assets/css/jlcontentfilter.css', array('version' => 'auto'));
}

?>

<form id="mod-finder-searchform-<?php echo $module->id; ?>" action="<?php echo $action; ?>" method="<?php echo $form_method; ?>" class="form-search">
    <div class="jlcontentfieldsfilter<?php echo $moduleclass_sfx; ?>">

        <?php foreach($fields as $v) : ?>
        <?php if($v):?>
        <div class="jlmf-section">

            <div class="col-md-4 ">
                <label class="filter-label">Сумма кредита, ₽</label>
                <div class="range"><input type="text" id="credit-range-one" name="Сумма" value="" /></div>

                <div class="jlmf-list-2 range-sliders">
                    <div id="credit" class="jlmf-range-block">
                        <div class="range-group one">
                            <ul class="range-text">
                                <li><label>Сумма кредита, ₽</label></li>
                                <li class="range-place">
                                    <div class="range-value"><span class="range-summary">250 000</span></div>
                                    <div class="range-input">
                                        <input id="<?php echo $field->name.'-to-'.$moduleId; ?>" type="text" name="jlcontentfieldsfilter[<?php echo $field->id; ?>][to]" class="form-price form-number jlmf-input input-max" min="20000" max="1000000" step="10000" value="250000" data-to="<?php echo $to ?>" data-min="<?php echo $min ?>" data-max="<?php echo $max ?>" />
                                    </div>
                                </li>
                            </ul>
                            <div class="range-control">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php echo $v; ?>
        </div>
        <?php endif;?>
        <?php endforeach; ?>

        <?php if($enableOrdering) : ?>
        <div class="jlmf-section">
            <?php echo $orderingSelect; ?>
        </div>
        <?php endif; ?>

        <div class="jlmf-section">
            <?php if (!$autho_send) : ?>
            <button type="submit" class="jlmf-button"><?php echo JText::_('MOD_JLCONTENTFIELDSFILTER_SUBMIT'); ?></button>
            <?php endif; ?>
            <div><button type="button" class="jlmf-link" onclick="return JlContentFieldsFilter.clearForm(this);"><?php echo JText::_('MOD_JLCONTENTFIELDSFILTER_RESET'); ?></button></div>
        </div>

    </div>
    <?php if($option == 'com_tags'){ ?>
    <input type="hidden" name="tag_category_id" value="<?php echo $catid; ?>">
    <?php } ?>
    <input type="hidden" name="jlcontentfieldsfilter[is_filter]" value="1">
</form>
