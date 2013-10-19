<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/db.php');
noCache();

function input($length, $label, $type, $name, $exampleValue, $event)
{
	echo '
<table class="inputGroupTable"><tr>
<td class="leftText inputItem">
	<label>'.$label.'</label>
	<input size="'.$length.'" type="'.$type.'" name="'.$name.'" onkeypress="'.$event.'" />
</td>
<td class="leftText inputItem grayed">
	<label>'.$label.'</label>
	<input size="'.$length.'" type="'.$type,'" value="'.$exampleValue.'" readonly="readonly" class="grayed" />
</td>
</tr></table>
';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create Mission - Pittsburgh Secrets</title>
<link rel="stylesheet" type="text/css" href="authoring.css">
<script type="text/javascript" src="authoring.js"></script>
</head>
<body>

<div id="mainDiv"><form method="post">
<h2>So you want to author a mission?</h2>
Creating a mission is some what confusing and time consuming, so get yourself some coffee or a snack before we get started.  Go ahead, I'll wait.
Got it?<br/>OK, let's get started.<br/><br/>
In order to help you understand the creation process whenever you are prompted for information you'll be able to enter it on the left hand side and see an example on the right hand side.  Like this:<br/>
<? input(50, 'Enter some text:', 'text', '', 'Some Text :-)', ''); ?>
Makes sense right?  Great, time to finally get off the ground!<br/>
Your mission needs a name, something short that will help players figure out the main idea.
<? input(20, 'Mission Name:', 'text', 'name', 'Elks Lodge Banjo night', ''); ?>
Next, you should include the neighborhood or general area where this mission takes players.
<? input(20, 'Neighborhood:', 'text', 'neighborhood', 'North Side', ''); ?>
You can also include "Tags" which serve as both categories and keywords for the mission.
<? input(20, 'Tags:', 'text', 'neighborhood', 'Music, Banjo, Elks', 'tagKeyPress()'); ?>
<form></div>

</body>
</html>