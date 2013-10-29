<?php
include(dirname(__FILE__).'/authoring.php');
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
<? input(50, 'Enter some text:', 'text', '', 'Some Text :-)'); ?>
Makes sense right?  Great, time to finally get off the ground!<br/>
Your mission needs a name, something short that will help players figure out the main idea.
<? input(20, 'Mission Name:', 'text', 'name', 'Elks Lodge Banjo Night'); ?>
Next, you should include the neighborhood or general area where this mission takes players.
<? input(20, 'Neighborhood:', 'text', 'neighborhood', 'North Side'); ?>
You can also include "Tags" which serve as both categories and keywords for the mission.  Tags are seperated by commas.<br/>Below, you can see how your input will become tags.
<? input(50, 'Tags:', 'text', 'tags', 'Music, Banjo, Elks',
array('userhtml'=>tagSpan('tagSpan'), 'examplehtml'=> tagSpan('tagSpanEx'))
); ?>
Your mission also needs a description, to let players know what it's about and what they should do.
<? input(7, 'Description:', 'textarea', 'description', 'Come to the Elk\'s lodge and sing along with the banjo!'); ?>
If you're mission will only available for a certain date range, enter it below, if not skip this step.
<? input(10, 'Start date:', 'date', 'startdate', '2013-08-15', array('skipreturn'=>true)); ?>
<? input(10, 'End date:', 'date', 'enddate', '2014-05-28'); ?>
If you're mission has a time limit (must be completed in short time frame after accepting), enter it below, if not skip this step.
<? input(10, 'Days:', 'number', 'limitday', '1', array('skipreturn'=>true)); ?>
<? input(10, 'Hours:', 'number', 'limithour', '2', array('skipreturn'=>true)); ?>
<? input(10, 'Minuites:', 'number', 'limitmin', '42'); ?>
</form></div>

</body>
</html>