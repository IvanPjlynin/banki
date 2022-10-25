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

use Joomla\CMS\Factory;
$assetManager = Factory::getApplication()->getDocument()->getWebAssetManager();
$assetManager->registerAndUseScript('tinysort', 'https://cdnjs.cloudflare.com/ajax/libs/tinysort/3.2.5/tinysort.min.js', []);

?>

<form id="mod-finder-searchform-<?php echo $module->id; ?>" action="<?php echo $action; ?>" method="<?php echo $form_method; ?>" class="form-search filter-credit-nalichumi">
    <div class="jlcontentfieldsfilter<?php echo $moduleclass_sfx; ?> row">

        <div class="col-md-3 block-filter">
            <label class="filter-label">Сумма кредита, ₽</label>
            <input type="text" class="filter-input" id="input-credit-range-one" value="500000" />

            <div class="range single"><input type="text" id="credit-range-one" value="" /></div>

        </div>

        <div class="col-md-3 block-filter">
            <label class="filter-label">На какой срок, дн.</label>
            <input type="text" class="filter-input" id="input-credit-range-two" value="500000" />

            <div class="range single"><input type="text" id="credit-range-two" value="" /></div>

        </div>

        <div class="col-md-3 block-filter">
            <div class="dropdown">
                <button class="btn dropdown-toggle filter-dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    Фильтры поиска <span>(+5)</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <div class="col-md-12 block-filter">
                        <label class="filter-label">Возраст, лет</label>
                        <input type="text" class="filter-input" id="input-credit-vozrast-ot" value="" />

                        <div class="range"><input type="text" id="credit-filter-vozrast" value="" /></div>
                    </div>
                    <br>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Есть российский паспорт с регистрацией в любом регионе</h4>
                        <label class="jlmf-sublabel switch" for="est-rossijskij-pasport-s-registratsiej-v-lyubom-regione-109">Да <input type="checkbox" value="1" id="est-rossijskij-pasport-s-registratsiej-v-lyubom-regione-109" name="jlcontentfieldsfilter[5][]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Стаж на последнем месте работы более 3-х месяцев</h4>
                        <label class="jlmf-sublabel switch" for="stazh-na-poslednem-meste-raboty-bolee-3-kh-mesyatsev-109">Да <input type="checkbox" value="1" id="stazh-na-poslednem-meste-raboty-bolee-3-kh-mesyatsev-109" name="jlcontentfieldsfilter[6][]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Общий трудовой стаж более одного года</h4>
                        <label class="jlmf-sublabel switch" for="obshchij-trudovoj-stazh-bolee-odnogo-goda-109">Да <input type="checkbox" value="1" id="obshchij-trudovoj-stazh-bolee-odnogo-goda-109" name="jlcontentfieldsfilter[7][]" class="jlmf-checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <hr>

                    <div class="col-md-12 block-filter">
                        <h4>Смогу подтвердить доход справкой 2-НДФЛ или справкой по форме банка?</h4>
                        <label class="jlmf-sublabel switch" for="podtverzhdenie-dokhoda-109">Да <input type="checkbox" value="4" id="podtverzhdenie-dokhoda-109" name="jlcontentfieldsfilter[41][]" class="jlmf-checkbox">
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


        <div class="jlmf-section filtr-sort">
            <label class="jlmf-label" for="jlcontentfieldsfilter-ordering-109">Сортировка</label>
            <select id="jlcontentfieldsfilter-ordering-109" name="jlcontentfieldsfilter[ordering]" class="jlmf-select filtr-sort-select">
                <option value="id.desc" selected="selected">По умолчанию</option>
                <option value="summ.asc">Сумма (по возрастанию)</option>
                <option value="summ.desc">Сумма (по убыванию)</option>
                <option value="stavka.asc">Ставка (по возрастанию)</option>
                <option value="stavka.desc">Ставка (по убыванию)</option>
                <option value="sroc.asc">Срок (по возрастанию)</option>
                <option value="sroc.desc">Срок (по убыванию)</option>

                <!--<option value="title.asc">Заголовок (по возрастанию)</option>
                <option value="title.desc">Заголовок (по убыванию)</option>
                <option value="hits.asc">Популярность (по возрастанию)</option>
                <option value="hits.desc">Популярность (по убыванию)</option>-->

            </select>
        </div>


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

        //сумма кредита
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
        var fromSumm = 5000;
        if (getUrlParameter('summ')) {
            fromSumm = getUrlParameter('summ');
        }
        var fromSroc = 30;
        if (getUrlParameter('sroc')) {
            fromSroc = getUrlParameter('sroc');
        }



        $("#summa-zajma-ot-from-140").trigger("keypress").val(function(i, val) {
            return 0;
        });

        $("#summa-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
            return 5000;
        });



        $("#summa-zajma-from-140").trigger("keypress").val(function(i, val) {
            return 5000;
        });

        $("#summa-zajma-to-140").trigger("keypress").val(function(i, val) {
            return 100000;
        });


        $filter_range1.ionRangeSlider({
            type: "single",
            grid: false,
            min: 500,
            from: fromSumm,
            postfix: '',
            step: 500,
            grid_snap: '',
            max: 100000,
            onStart: function(data) {
                $input_filter_range1.prop("value", number_format(data.from, true));
                $("#summa-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
                $("#summa-zajma-from-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            },
            onChange: function(data) {
                $input_filter_range1.prop("value", number_format(data.from, true));
                $("#summa-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
                $("#summa-zajma-from-140").trigger("keypress").val(function(i, val) {
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

            $("#summa-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
                return number_format(value);
            });
            $("#summa-zajma-from-140").trigger("keypress").val(function(i, val) {
                return number_format(value);
            });

            instance_filter_range1.update({
                from: number_format(value)
            });
        });

        //срок кредита

        var $filter_range2 = $("#credit-range-two");
        var $input_filter_range2 = $("#input-credit-range-two");
        var instance_filter_range2;

        $("#srok-zajma-ot-from-140").trigger("keypress").val(function(i, val) {
            return 0;
        });

        $("#srok-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
            return 30;
        });



        $("#srok-zajma-from-140").trigger("keypress").val(function(i, val) {
            return 30;
        });

        $("#srok-zajma-to-140").trigger("keypress").val(function(i, val) {
            return 366;
        });


        $filter_range2.ionRangeSlider({
            type: "single",
            grid: false,
            from: fromSroc,
            postfix: '',
            min: 5,
            step: 1,
            grid_num: 4,
            grid_snap: '',
            max: 366,
            onStart: function(data) {
                $input_filter_range2.prop("value", data.from);
                $("#srok-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
                $("#srok-zajma-from-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            },
            onChange: function(data) {
                $input_filter_range2.prop("value", data.from);
                $("#srok-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
                $("#srok-zajma-from-140").trigger("keypress").val(function(i, val) {
                    return data.from;
                });
            }
        });

        instance_filter_range2 = $filter_range2.data("ionRangeSlider");

        $input_filter_range2.on("input", function() {
            var value = $(this).prop("value");

            $("#srok-zajma-ot-to-140").trigger("keypress").val(function(i, val) {
                return value;
            });
            $("#srok-zajma-from-140").trigger("keypress").val(function(i, val) {
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

        $("#vozrast-from-140").trigger("keypress").val(function(i, val) {
            return 14;
        });

        $("#vozrast-to-140").trigger("keypress").val(function(i, val) {
            return 80;
        });

        $("#vozrast-dlya-pogasheniya-from-140").trigger("keypress").val(function(i, val) {
            return 65;
        });

        $("#vozrast-dlya-pogasheniya-to-140").trigger("keypress").val(function(i, val) {
            return 99;
        });


        $filter_vozrast.ionRangeSlider({
            skin: "round",
            type: "single",
            grid: false,
            from: 21,
            to: 65,
            postfix: '',
            min: 18,
            step: 1,
            grid_num: 4,
            grid_snap: '',
            max: 85,
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

            /*$("#vozrast-from-109").trigger("keypress").val(function(i, val) {
                return from;
            });*/

            $("#vozrast-to-140").trigger("keypress").val(function(i, val) {
                return from;
            });

            $("#vozrast-dlya-pogasheniya-from-140").trigger("keypress").val(function(i, val) {
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
            $('button.filter-dropdown-toggle span').html('(+' + (5 - n) + ')');
        });


        //сортировка
        function SortOfers(data, order) {
            var divOfers = 'div.com-content-category-blog__item.blog-item';
            tinysort(divOfers, {
                selector: 'div.item-content',
                data: data,
                order: order
            });
        }

        $('select.filtr-sort-select').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;

            let arr = valueSelected.split('.');
            let data = arr[0];
            let order = arr[1];
            //console.log(data, order);

            SortOfers(data, order);

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
        width: 120px;
        color: #002D4F;
    }

    .blog .tabsmenu a:nth-child(2):hover~div {
        transform: translate(168px);
        -webkit-transform: translate(168px);
        background: #56C182;
        transition: all .33s linear;
        -webkit-transition: all .33s linear;
        width: 110px;
        color: #002D4F;
    }

    .blog .tabsmenu a:nth-child(1) {
        color: #56c182;
    }

</style>
