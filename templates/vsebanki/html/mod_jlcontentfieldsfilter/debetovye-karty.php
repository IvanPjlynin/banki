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

<form id="mod-finder-searchform-<?php echo $module->id; ?>" action="<?php echo $action; ?>" method="<?php echo $form_method; ?>" class="form-search filter-debit-card">
    <div class="jlcontentfieldsfilter<?php echo $moduleclass_sfx; ?> row">

        <div class="col-md-3 block-filter">
            <label class="filter-label">Cashback</label>
            <select name="" id="carta-cashback" class="jlmf-select filter-select">
                <option value="2">Да</option>
                <option value="1">Нет</option>
            </select>

        </div>

        <div class="col-md-3 block-filter">
            <label class="filter-label">Проценты на остаток</label>
            <select name="" id="procent-ostatok" class="jlmf-select filter-select">
                <option value="2">Да</option>
                <option value="1">Нет</option>
            </select>

        </div>

        <div class="col-md-3 block-filter">
            <div class="dropdown">
                <button class="btn dropdown-toggle filter-dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    Фильтры поиска <span></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <div class="col-md-12 block-filter">
                        <label class="filter-label">Возраст, лет</label>
                        <input type="text" class="filter-input" id="input-credit-vozrast-ot" value="" />

                        <div class="range"><input type="text" id="credit-filter-vozrast" value="" /></div>
                    </div>




                </div>
            </div>
        </div>

        <div class="col-md-3 jlmf-section">
            <?php if (!$autho_send) : ?>
            <button type="submit" class="jlmf-button" id="filter-buttom"><?php echo JText::_('MOD_JLCONTENTFIELDSFILTER_SUBMIT'); ?></button>
            <?php endif; ?>
            <!--<div><button type="button" class="jlmf-link" onclick="return JlContentFieldsFilter.clearForm(this);"><?php echo JText::_('MOD_JLCONTENTFIELDSFILTER_RESET'); ?></button></div>-->
        </div>

        <?php foreach($fields as $v) : ?>
        <?php if($v):?>
        <div class="jlmf-section visually-hidden">
            <?php echo $v; ?>
        </div>
        <?php endif;?>
        <?php endforeach; ?>

        <?php if($enableOrdering) : ?>
        <div class="jlmf-section">
            <?php echo $orderingSelect; ?>
        </div>
        <?php endif; ?>



    </div>
    <?php if($option == 'com_tags'){ ?>
    <input type="hidden" name="tag_category_id" value="<?php echo $catid; ?>">
    <?php } ?>
    <input type="hidden" name="jlcontentfieldsfilter[is_filter]" value="1">
</form>


<script>
    jQuery(document).ready(function($) {
        //Cashback
        $("#cashback-from-143").trigger("keypress").val(function(i, val) {
            return 0;
        });
        $("#cashback-to-143").trigger("keypress").val(function(i, val) {
            return 1000;
        });

        $('#carta-cashback').change(function() {
            var value;
            var keyVal;
            if ($(this).val() == 1) {
                value = 0.01;
                $("#cashback-to-143").trigger("keypress").val(function(i, val) {
                    return value;
                });
            } else {
                value = 1000;
                $("#cashback-to-143").trigger("keypress").val(function(i, val) {
                    return value;
                });
            }
        });
        //процент на остаток
        $("#debet-proc-na-ostatok-143").trigger("keypress").val(function(i, val) {
            return '';
        });
        /*$("#protsent-na-ostatok-to-143").trigger("keypress").val(function(i, val) {
            return 0.01;
        });*/

        $('#procent-ostatok').change(function() {
            var value;
            if ($(this).val() == 1) {
                value = 0.01;
                $("#debet-proc-na-ostatok-143").trigger("keypress").val(function(i, val) {
                    return 'нет';
                });
            } else {
                value = 1000;
                $("#debet-proc-na-ostatok-143").trigger("keypress").val(function(i, val) {
                    return '';
                });
            }
        });




        //возраст
        var $filter_vozrast = $("#credit-filter-vozrast");
        var $input_filter_vozrastFrom = $("#input-credit-vozrast-ot");
        var $input_filter_vozrastTo = $("#input-credit-vozrast-do");
        var instance_filter_vozrast;

        $("#vozrast-from-143").trigger("keypress").val(function(i, val) {
            return 10;
        });

        $("#vozrast-to-143").trigger("keypress").val(function(i, val) {
            return 80;
        });


        $filter_vozrast.ionRangeSlider({
            skin: "round",
            type: "single",
            grid: false,
            from: 18,
            to: 80,
            postfix: '',
            min: 8,
            step: 1,
            grid_num: 4,
            grid_snap: '',
            max: 80,
            onStart: updateInputs,
            onChange: updateInputs,
            onFinish: updateInputs
        });

        instance_filter_vozrast = $filter_vozrast.data("ionRangeSlider");

        function updateInputs(data) {
            from = data.from;
            to = data.to;

            $input_filter_vozrastFrom.prop("value", from);
            $input_filter_vozrastTo.prop("value", to);

            /*$("#vozrast-from-143").trigger("keypress").val(function(i, val) {
                return from;
            });*/

            $("#vozrast-to-143").trigger("keypress").val(function(i, val) {
                return from;
            });
        }

        $input_filter_vozrastFrom.on("change", function() {
            var val = $(this).prop("value");

            instance_filter_vozrast.update({
                from: val
            });

            $(this).prop("value", val);

        });

        $input_filter_vozrastTo.on("change", function() {
            var val = $(this).prop("value");

            instance_filter_vozrast.update({
                to: val
            });

            $(this).prop("value", val);
        });

        //подсчет чебоксов
        $('.dropdown-menu .jlmf-checkbox').change(function() {
            var n = $(".dropdown-menu input:checked").length;
            $('button.filter-dropdown-toggle span').html('(+' + (1 - n) + ')');
        });


    });

</script>
<style>
    .blog .tabsmenu a:nth-child(2)~div,
    .blog .tabsmenu a:nth-child(2):hover~div {
        transform: translate(226px);
        -webkit-transform: translate(226px);
        background: #56C182;
        transition: all .33s linear;
        -webkit-transition: all .33s linear;
        width: 180px;
        color: #002D4F;
    }

    .blog .tabsmenu a:nth-child(1):hover~div {
        transform: translate(0px);
        -webkit-transform: translate(0px);
        background: #56C182;
        transition: all .33s linear;
        -webkit-transition: all .33s linear;
        width: 180px;
        color: #002D4F;
    }

    .blog .tabsmenu a:nth-child(2) {
        color: #56c182;
    }

</style>
