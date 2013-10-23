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

function inputLabel($label, $class)
{
	echo '<label class="'.$class.'">'.$label.'</label>';
}

function inputText($class, $length, $label, $type, $name, $value, $extraAttributes, $extraHTML)
{
	echo '<input class="'.$class.'" size="'.$length.'" type="'.$type,'" id="'.$name.'" value="'.$value.'" '.$extraAttributes.' />'.$extraHTML.'</td>';
}

function inputArea($class, $size, $label, $type, $name, $value, $extraAttributes, $extraHTML)
{
	echo '<textarea class="'.$class.'" style="width:98%" rows="'.$size.'" " id="'.$name.'" '.$extraAttributes.' >'.$value.'</textarea>'.$extraHTML.'</td>';
}

function inputClose()
{
	echo '</tr></table><br/>';
}

function inputAllText($size, $label, $type, $name, $exampleValue, $extraUser='', $extraExample='')
{
	inputTable();
	inputCell('inputCell');
	inputLabel($label, 'inputItem');
	inputText('inputItem', $size, $label, $type, $name, '', '', $extraUser);
	inputCell('inputCell grayed');
	inputLabel($label, 'inputItem');
	inputText('inputItem grayed', $size, $label, $type, $name.'Ex', $exampleValue, 'readonly="readonly"', $extraExample);
	inputClose();
}

function inputAllArea($size, $label, $type, $name, $exampleValue, $extraUser='', $extraExample='')
{
	inputTable();
	inputCell('inputCell');
	inputLabel($label, 'inputItem');
	inputArea('inputItem', $size, $label, $type, $name, '', '', $extraUser);
	inputCell('inputCell grayed');
	inputLabel($label, 'inputItem');
	inputArea('inputItem grayed', $size, $label, $type, $name.'Ex', $exampleValue, 'readonly="readonly"', $extraExample);
	inputClose();
}

function tagSpan($id)
{
	return '<br/>&#x21B3;<span id="'.$id.'"></span>';
}

?>
