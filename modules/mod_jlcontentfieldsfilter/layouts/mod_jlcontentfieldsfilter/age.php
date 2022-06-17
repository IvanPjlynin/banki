<?php
/**
 * JL Content Fields Filter
 *
 * @version 	@version@
 * @author		Joomline
 * @copyright	(C) 2017-2020 Arkadiy Sedelnikov, Joomline. All rights reserved.
 * @license 	GNU General Public License version 2 or later; see	LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Factory;

if (!key_exists('field', $displayData))
{
    return;
}

$moduleId = $displayData['moduleId'];
$min = $displayData['min'];
$max = $displayData['max'];
$field = $displayData['field'];
if(!empty($field->hidden)){
    return;
}
$label = JText::_($field->label);
$value = $field->value;
$from = !empty($value['from']) ? $value['from'] : $min;
$to =  !empty($value['to']) ? $value['to'] : $max;

$fromPlaceholder = $min !== '' ? JText::sprintf('MOD_JLCONTENTFIELDSFILTER_MIN', $min) : '';
$toPlaceholder = $max !== '' ? JText::sprintf('MOD_JLCONTENTFIELDSFILTER_MAX', $max) : '';

$doc = Factory::getDocument();
$doc->addScript('/modules/mod_jlcontentfieldsfilter/assets/javascript/nouislider.min.js');
//$doc->addScript('/modules/mod_jlcontentfieldsfilter/assets/javascript/cash-credit.js');
$doc->addStyleSheet('/modules/mod_jlcontentfieldsfilter/assets/css/nouislider.min.css');
$doc->addStyleSheet('/modules/mod_jlcontentfieldsfilter/assets/css/range.css');

?>
<div class="col-md-12">
    <div class="jlmf-list-2 range-sliders">
        <div id="credit" class="jlmf-range-block">
            <div class="range-group three">
                <ul class="range-text">
                    <li><label>Возраст</label></li>
                    <li class="range-place">
                        <div class="range-value"><span class="range-summary">25</span></div>
                        <div class="range-input">
                            <input id="<?php echo $field->name.'-to-'.$moduleId; ?>" type="text" name="jlcontentfieldsfilter[<?php echo $field->id; ?>][to]" class="form-age form-number jlmf-input input-max" min="18" max="85" step="1" value="25" data-to="<?php echo $to ?>" data-min="18" data-max="85" /></div>
                    </li>
                </ul>
                <div class="range-control">
                    <div class="range"><input type="text" id="range-three" name="Возраст" value="" /></div>
                </div>
            </div>
        </div>
    </div>
</div>




