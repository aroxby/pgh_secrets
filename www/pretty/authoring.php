<?php
//Include over basic and database functions
include($_SERVER['DOCUMENT_ROOT'].'/scripts/db.php');
//Do not allow users to navigate to this file
dropDirectRequest(__FILE__);
//Do not cache this file
noCache();

//These functions simply the writing of input fields
//This function creates the main table
function inputTable()
{
	echo '<table class="inputGroupTable"><tr>';
}

//This function creates a table cell for an input field
function inputCell($class)
{
	echo '<td class="'.$class.'">';
}
//This function creates the label for an input field
function inputLabel($label, $class)
{
	echo '<label class="'.$class.'">'.$label.'</label>';
}

//This function creates an input field
//It makes various decisions about the needed HTML based on the type
//Sometimes additional attributes the field are specified, or additional HTML for after the field
function inputField($class, $size, $label, $type, $name, $value, $extraAttributes, $extraHTML)
{
	$valueHTML = '';
	if($type=='checkbox')
	{
		if($value=='true') $valueHTML = 'checked="checked"';
		else $valueHTML = '';
	}
	else if($type=='select')
	{
		$valueHTML = $value;
	}
	else $valueHTML = 'value="'.$value.'"';
	if($type==='textarea') echo '<textarea class="'.$class.'" style="width:98%" rows="'.$size.'" " id="'.$name.'" '.$extraAttributes.' >'.$value.'</textarea>'.$extraHTML.'</td>';
	else if($type==='select') echo '<select class="'.$class.'" id="'.$name.'" '.$extraAttributes.'>'.$valueHTML.'</select>'.$extraHTML.'</td>';
	else echo '<input class="'.$class.'" min="0" size="'.$size.'" type="'.$type,'" id="'.$name.'" '.$valueHTML.' '.$extraAttributes.' />'.$extraHTML.'</td>';
}

//This function closes the table cell
function inputClose($sayReturn)
{
	echo '</tr></table>';
	if($sayReturn) echo '<br/>';
}

//This function creates an input field on the right with an example field on the left
function input($size, $label, $type, $name, $exampleValue, $extra = array())
{
	inputTable();
	inputCell('inputCell');
	inputLabel($label, 'inputItem');
	inputField('inputItem', $size, $label, $type, $name, @$extra['userVal'], '', @$extra['userhtml']);
	inputCell('inputCell grayed');
	inputLabel($label, 'inputItem');
	$exampleReadOnly = 'readonly="readonly"';
	if($type=='checkbox' || $type=='select') $exampleReadOnly = 'disabled="disabled"';
	inputField('inputItem grayed', $size, $label, $type, $name.'Ex', $exampleValue, $exampleReadOnly, @$extra['examplehtml']);
	inputClose(!isset($extra['skipreturn']));
}

//This function creates and styles a span for mission tags
function tagSpan($id)
{
	return '<br/>&#x21B3;<span id="'.$id.'"></span>';
}

//This function returns a list of valid mission types
function typeList($default)
{
	$types = array('', 'Art & Culture', 'Education & Kids', 'Health & Fitness', 'Food & Drink', 'Sports', 'Uniquely Pittsburgh');
	$list = '';
	foreach($types as $type)
	{
		if($type===$default) $list .= '<option value="'.$type.'" selected="selected">'.$type.'</option>';
		else $list .= '<option value="'.$type.'">'.$type.'</option>';
	}
	return $list;
}

?>
