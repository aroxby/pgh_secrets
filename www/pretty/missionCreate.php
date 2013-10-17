<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/db.php');
noCache();

function input($label, $type, $name, $exampleValue)
{
	echo
'<label>'.$label.'</label><input type="'.$type.'" name="'.$name.'" />
<span style="width:100px" />
<label>'.$label.'</label><input type="'.$type,'" value="'.$exampleValue.'" />';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create Mission - Pittsburgh Secrets</title>
<link rel="stylesheet" type="text/css" href="authoring.css">
</head>
<body>

<div id="mainDiv">
<h2>So you want to author a mission?</h2>
Creating a mission is some what confusing and time consuming, so get yourself some a coffee or a snack before we get started.  Go ahead, I'll wait.
Got it?<br/>OK, let's get started.<br/><br/>
In order to help you understand the creation process whenever you are prompted for information you'll be able to enter it on the left hand side and see an example on the right hand side.  Like this:<br/>
<? input('Enter some text:', 'text', '', 'Some Text :-)'); ?>

</div>

</body>
</html>