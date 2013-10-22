<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/db.php');
dropDirectRequest(__FILE__);
noCache();

function inputTable()
{
	echo '<table class="inputGroupTable"><tr>';
}

function inputCell($class)
{
	echo '<td class="'.$class.'">';
}

function inputLabel($label)
{
	echo '<label>'.$label.'</label>';
}

function inputText($length, $label, $type, $name, $value, $extraAttributes, $extraHTML)
{
	echo '<input size="'.$length.'" type="'.$type,'" id="'.$name.'" value="'.$value.'" "'.$extraAttributes.'" />'.$extraHTML.'</td>';
}

function inputArea($size, $label, $type, $name, $value, $extraAttributes, $extraHTML)
{
	echo '<textarea rows="'.$length.'" " id="'.$name.'" "'.$extraAttributes.'" >'.$value.'</textarea>'.$extraHTML.'</td>';
}

function inputClose()
{
	echo '</tr></table><br/>';
}

function inputAllText($size, $label, $type, $name, $exampleValue, $extraUser='', $extraExample='')
{
	inputTable();
	inputCell('leftText inputItem');
	inputLabel($label);
	inputText($size, $label, $type, $name, '', '', $extraUser);
	inputCell('leftText inputItem grayed');
	inputLabel($label);
	inputText($size, $label, $type, $name.'Ex', $exampleValue, 'readonly="readonly" class="grayed"', $extraExample);
	inputClose();
}

function inputAllArea($size, $label, $type, $name, $exampleValue, $extraUser='', $extraExample='')
{
	inputTable();
	inputCell('leftText inputItem');
	inputLabel($label);
	inputArea($size, $label, $type, $name, '', '', $extraUser);
	inputCell('leftText inputItem grayed');
	inputLabel($label);
	inputArea($size, $label, $type, $name.'Ex', $exampleValue, 'readonly="readonly" class="grayed"', $extraExample);
	inputClose();
}

function tagSpan($id)
{
	return '<br/>&#x21B3;<span id="'.$id.'"></span>';
}

?>
