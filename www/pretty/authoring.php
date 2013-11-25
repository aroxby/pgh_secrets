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

function inputField($class, $size, $label, $type, $name, $value, $extraAttributes, $extraHTML)
{
	if($type=='textarea') echo '<textarea class="'.$class.'" style="width:98%" rows="'.$size.'" " id="'.$name.'" '.$extraAttributes.' >'.$value.'</textarea>'.$extraHTML.'</td>';
	else echo '<input class="'.$class.'" min="0" size="'.$size.'" type="'.$type,'" id="'.$name.'" value="'.$value.'" '.$extraAttributes.' />'.$extraHTML.'</td>';
}

function inputClose($sayReturn)
{
	echo '</tr></table>';
	if($sayReturn) echo '<br/>';
}

function input($size, $label, $type, $name, $exampleValue, $extra = array())
{
	inputTable();
	inputCell('inputCell');
	inputLabel($label, 'inputItem');
	inputField('inputItem', $size, $label, $type, $name, '', '', @$extra['userhtml']);
	inputCell('inputCell grayed');
	inputLabel($label, 'inputItem');
	$exampleReadOnly = 'readonly="readonly"';
	if($type=='checkbox') $exampleReadOnly = 'disabled="disabled"';
	inputField('inputItem grayed', $size, $label, $type, $name.'Ex', $exampleValue, $exampleReadOnly, @$extra['examplehtml']);
	inputClose(!isset($extra['skipreturn']));
}

function tagSpan($id)
{
	return '<br/>&#x21B3;<span id="'.$id.'"></span>';
}

?>
