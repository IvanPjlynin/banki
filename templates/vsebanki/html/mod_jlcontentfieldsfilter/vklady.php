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
            <label class="filter-label">Сумма, ₽</label>
            <input type="text" class="filter-input" id="input-credit-range-one" value="500000" />

            <div class="range single"><input type="text" id="credit-range-one" value="" /></div>

        </div>

        <div class="col-md-3 block-filter">
            <label class="filter-label">Срок, мес.</label>
            <input type="text" class="filter-input" id="input-credit-range-two" value="500000" />

            <div class="range single"><input type="text" id="credit-range-two" value="" /></div>

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

        //разделитель на 1 000
        function number_format(num, format) {
            num = (num + "").replace(/(\s)+/g, "");
            return format ? num.replace(/(\d{1,3})(?=(?:\d{3})+$)/g, "$1 ") : num
        }

        //сумма вклада
        var $filter_range1 = $("#credit-range-one");
        var $input_filter_range1 = $("#input-credit-range-one");
        var instance_filter_range1;




        //получаем GET параметры в url
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
        var fromSumm = 500000;
        if (getUrlParameter('summ')) {
            fromSumm = getUrlParameter('summ');
        }
        var fromSroc = 12;
        if (getUrlParameter('sroc')) {
            fromSroc = getUrlParameter('sroc');
        }



        $("#summa-vklada-from-144").trigger("keypress").val(function(i, val) {
            return 1000;
        });

        $("#summa-vklada-to-144").trigger("keypress").val(function(i, val) {
            return 5000000;
        });



        $filter_range1.ionRangeSlider({
            type: "single",
            grid: false,
            min: 1000,
            from: fromSumm,
            postfix: '',
            step: 1000,
            grid_snap: '',
            max: 5000000,
            onStart: function(data) {
                $input_filter_range1.prop("value", number_format(data.from, true));
                $("#summa-vklada-to-144").trigger("keypress").val(function(i, val) {
                    return data.from;
                });

            },
            onChange: function(data) {
                $input_filter_range1.prop("value", number_format(data.from, true));
                $("#summa-vklada-to-144").trigger("keypress").val(function(i, val) {
                    return data.from;
                });

            }
        });

        instance_filter_range1 = $filter_range1.data("ionRangeSlider");

        $input_filter_range1.on("focus", function() {
            this.value = number_format(this.value, true);
            this.focus();
            this.selectionStart = this.value.length
        }).on("input", function() {
            var value = $(this).prop("value");

            $("#summa-vklada-to-144").trigger("keypress").val(function(i, val) {
                return number_format(value);
            });


            instance_filter_range1.update({
                from: number_format(value)
            });
        });

        //срок 

        var $filter_range2 = $("#credit-range-two");
        var $input_filter_range2 = $("#input-credit-range-two");
        var instance_filter_range2;

        $("#srok-vklada-ot-from-144").trigger("keypress").val(function(i, val) {
            return 1;
        });

        $("#srok-vklada-ot-to-144").trigger("keypress").val(function(i, val) {
            return 12;
        });

        $("#srok-vklada-do-from-144").trigger("keypress").val(function(i, val) {
            return 12;
        });

        $("#srok-vklada-do-to-144").trigger("keypress").val(function(i, val) {
            return 1000;
        });



        $filter_range2.ionRangeSlider({
            type: "single",
            grid: false,
            from: fromSroc,
            postfix: '',
            min: 1,
            step: 1,
            grid_num: 4,
            grid_snap: '',
            max: 120,
            onStart: function(data) {
                $input_filter_range2.prop("value", data.from);
                $("#srok-vklada-ot-to-144").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
                $("#srok-vklada-do-from-144").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            },
            onChange: function(data) {
                $input_filter_range2.prop("value", data.from);
                $("#srok-vklada-ot-to-144").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
                $("#srok-vklada-do-from-144").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            }
        });

        instance_filter_range2 = $filter_range2.data("ionRangeSlider");

        $input_filter_range2.on("input", function() {
            var value = $(this).prop("value");

            $("#srok-vklada-ot-to-144").trigger("keypress").val(function(i, val) {
                return value;
            });
            $("#srok-vklada-do-from-144").trigger("keypress").val(function(i, val) {
                return value;
            });

            instance_filter_range2.update({
                from: value
            });
        });




    });

</script>

<style>
    .blog .tabsmenu a:nth-child(1)~div {
        transform: translate(0px);
        -webkit-transform: translate(0px);
        background: #56C182;
        transition: all .33s linear;
        -webkit-transition: all .33s linear;
        width: 80px;
        color: #002D4F;
    }

    .blog .tabsmenu a:nth-child(2):hover~div {
        transform: translate(130px);
        -webkit-transform: translate(130px);
        background: #56C182;
        transition: all .33s linear;
        -webkit-transition: all .33s linear;
        width: 125px;
        color: #002D4F;
    }

    .blog .tabsmenu a:nth-child(1) {
        color: #56c182;
    }

</style>
