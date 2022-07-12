<?php
/**
 * JL Content Fields Filter
 *
 * @version 	2.0.0
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
$doc->addScript('/modules/mod_jlcontentfieldsfilter/assets/javascript/sliders.js');
$doc->addStyleSheet('/modules/mod_jlcontentfieldsfilter/assets/css/nouislider.min.css');
$doc->addStyleSheet('/modules/mod_jlcontentfieldsfilter/assets/css/range.css');

?>
<div class="col-md-4">
   <div class="jlmf-list-2 range-sliders">
      <div id="credit" class="jlmf-range-block">
         <div class="range-group two">
            <ul class="range-text">
               <li><label>На какой срок, мес.</label></li>
               <li class="range-place">
                  <div class="range-value"><span class="range-summary">30</span></div>
                  <div class="range-input">
                     <input id="<?php echo $field->name.'-to-'.$moduleId; ?>" type="text" name="jlcontentfieldsfilter[<?php echo $field->id; ?>][to]" class="form-price form-number jlmf-input input-max" min="10" max="500" step="10" value="30" data-to="<?php echo $to ?>" data-min="<?php echo $min ?>" data-max="<?php echo $max ?>" />
                  </div>
               </li>
            </ul>
            <div class="range-control">
               <div class="range"><input type="text" id="range-two" name="Срок" value="" /></div>
            </div>
         </div>
      </div>
   </div>
</div>
