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

<form id="mod-finder-searchform-<?php echo $module->id; ?>" action="<?php echo $action; ?>" method="<?php echo $form_method; ?>" class="form-search filter-credit-nalichumi">
    <div class="jlcontentfieldsfilter<?php echo $moduleclass_sfx; ?> row">

        <div class="col-md-3 block-filter">
            <label class="filter-label">Cashback</label>
            <select name="jlcontentfieldsfilter[47]" id="kredit-pod-zalog-137" class="jlmf-select filter-dropdown-toggle">
                <option value="1">Нет</option>
                <option value="2">Да</option>
            </select>

        </div>

        <div class="col-md-3 block-filter">
            <label class="filter-label">Льготный период, дн.</label>
            <input type="text" class="filter-input" id="input-credit-range-two" value="500000" />

            <div class="range single"><input type="text" id="credit-range-two" value="" /></div>

        </div>

        <div class="col-md-3 block-filter">
            <div class="dropdown">
                <button class="btn dropdown-toggle filter-dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    Фильтры поиска <span>(0)</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <div class="col-md-12 block-filter">
                        <label class="filter-label">Возраст, от и до</label>
                        <input type="text" class="filter-input" id="input-credit-vozrast-ot" value="" />
                        <input type="text" class="filter-input" id="input-credit-vozrast-do" value="" />

                        <div class="range"><input type="text" id="credit-filter-vozrast" value="" /></div>
                    </div>
                    <br>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Есть российский паспорт с регистрацией в любом регионе</h4>
                        <label class="jlmf-sublabel switch" for="est-rossijskij-pasport-s-registratsiej-v-lyubom-regione-109">Да <input type="checkbox" value="1" id="est-rossijskij-pasport-s-registratsiej-v-lyubom-regione-109" name="jlcontentfieldsfilter[5]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Стаж на последнем месте работы более 3-х месяцев</h4>
                        <label class="jlmf-sublabel switch" for="stazh-na-poslednem-meste-raboty-bolee-3-kh-mesyatsev-109">Да <input type="checkbox" value="1" id="stazh-na-poslednem-meste-raboty-bolee-3-kh-mesyatsev-109" name="jlcontentfieldsfilter[6]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Общий трудовой стаж более одного года</h4>
                        <label class="jlmf-sublabel switch" for="obshchij-trudovoj-stazh-bolee-odnogo-goda-109">Да <input type="checkbox" value="1" id="obshchij-trudovoj-stazh-bolee-odnogo-goda-109" name="jlcontentfieldsfilter[7]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Смогу подтвердить доход справкой 2-НДФЛП или справкой по форме банка?</h4>
                        <label class="jlmf-sublabel switch" for="podtverzhdenie-dokhoda-109">Да <input type="checkbox" value="1" id="podtverzhdenie-dokhoda-109" name="jlcontentfieldsfilter[41]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
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
        <div class="jlmf-section ">
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
            return 0.01;
        });






        var $filter_range1 = $("#credit-range-one");
        var $input_filter_range1 = $("#input-credit-range-one");
        var instance_filter_range1;

        $("#kreditnyj-limit-from-142").trigger("keypress").val(function(i, val) {
            return 0;
        });

        $("#kreditnyj-limit-to-142").trigger("keypress").val(function(i, val) {
            return 3000000;
        });



        $filter_range1.ionRangeSlider({
            type: "single",
            grid: false,
            min: 0,
            from: 50000,
            postfix: '',
            step: 1000,
            grid_snap: '',
            max: 3000000,
            onStart: function(data) {
                $input_filter_range1.prop("value", data.from);
                $("#kreditnyj-limit-from-142").trigger("keypress").val(function(i, val) {
                    return data.from;
                });

            },
            onChange: function(data) {
                $input_filter_range1.prop("value", data.from);
                $("#kreditnyj-limit-from-142").trigger("keypress").val(function(i, val) {
                    return data.from;
                });

            }
        });

        instance_filter_range1 = $filter_range1.data("ionRangeSlider");

        $input_filter_range1.on("input", function() {
            var value = $(this).prop("value");

            $("#kreditnyj-limit-from-142").trigger("keypress").val(function(i, val) {
                return value;
            });


            instance_filter_range1.update({
                from: value
            });
        });

        //срок кредита

        var $filter_range2 = $("#credit-range-two");
        var $input_filter_range2 = $("#input-credit-range-two");
        var instance_filter_range2;

        $("#lgotnyj-period-from-142").trigger("keypress").val(function(i, val) {
            return 0;
        });

        $("#lgotnyj-period-to-142").trigger("keypress").val(function(i, val) {
            return 180;
        });



        $filter_range2.ionRangeSlider({
            type: "single",
            grid: false,
            from: 30,
            postfix: '',
            min: 5,
            step: 1,
            grid_num: 4,
            grid_snap: '',
            max: 180,
            onStart: function(data) {
                $input_filter_range2.prop("value", data.from);
                $("#lgotnyj-period-from-142").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            },
            onChange: function(data) {
                $input_filter_range2.prop("value", data.from);
                $("#lgotnyj-period-from-142").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            }
        });

        instance_filter_range2 = $filter_range2.data("ionRangeSlider");

        $input_filter_range2.on("input", function() {
            var value = $(this).prop("value");

            $("#lgotnyj-period-from-142").trigger("keypress").val(function(i, val) {
                return value;
            });

            instance_filter_range2.update({
                from: value
            });
        });

        //возраст
        var $filter_vozrast = $("#credit-filter-vozrast");
        var $input_filter_vozrastFrom = $("#input-credit-vozrast-ot");
        var $input_filter_vozrastTo = $("#input-credit-vozrast-do");
        var instance_filter_vozrast;

        $("#vozrast-from-142").trigger("keypress").val(function(i, val) {
            return 18;
        });

        $("#vozrast-to-142").trigger("keypress").val(function(i, val) {
            return 80;
        });


        $filter_vozrast.ionRangeSlider({
            skin: "round",
            type: "double",
            grid: false,
            from: 18,
            to: 80,
            postfix: '',
            min: 18,
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

            $("#vozrast-from-142").trigger("keypress").val(function(i, val) {
                return from;
            });

            $("#vozrast-to-142").trigger("keypress").val(function(i, val) {
                return to;
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
            $('button.filter-dropdown-toggle span').html('(+' + n + ')');
        });


    });

</script>
