<?php
include(dirname(__FILE__).'/authoring.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Create Mission - Pittsburgh Secrets</title>
<link rel="stylesheet" type="text/css" href="authoring.css">
<link rel="stylesheet" type="text/css" href="maps.css">
<link rel="stylesheet" type="text/css" href="imageUpload.css">
<script type="text/javascript" src="authoring.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript" src="imageUpload.js"></script>
<script type="text/javascript" src="maps.js"></script>
</head>

<body>
<div id="mainDiv"><form method="post" id="topForm" action="#">
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
You should enter an estimage of how long it will take to complete your mission.
<? input(10, 'Hours:', 'number', 'estHours', '2', array('skipreturn'=>true)); ?>
<? input(10, 'Minuites:', 'number', 'estMinutes', '43'); ?>
If your mission will only available for a certain date range, enter it below, if not skip this step.
<? input(10, 'Start date:', 'date', 'startdate', '2013-08-15', array('skipreturn'=>true)); ?>
<? input(10, 'End date:', 'date', 'enddate', '2014-05-28'); ?>
</form>
<b>Things get a little harder to demonstrate here, so the right hand side examples end.  Read the text carefully.</b><br/><br/>
Your mission needs some locations!  Drag the red marker to where you want your next location to be and then resize the blue circle to shape the check-in radius (make sure it's large!).  Once you are happy with your choices, click 'Save Location'.  You will see a list of the locations you choose appear on the left.

<div id="MapStuffz">

<div id="locationControls">
<input type="button" value="Save Location" onclick="saveLocaton()" />
<table id="LocationTable">
<tr><th></th><th>Latitude</th><th>Longitude</th><th>Check-In Radius (meters)</th><th></th></tr>
</table>
</div>

<div id="MapContainer">
</div>

</div>
<br/><br/>
You should probably also add images to your mission.  Simply click on the add image button and choose the image you wish to add.
<div id="previewContainer"><form action="imageUploadHandler.php" method="post" id="imgFrm" enctype="multipart/form-data">
	<input type="submit" class="hidden" id="imgFrmSubmit" />
	<input type="file" name="userImage" id="userImage" class="hidden" onchange="document.getElementById('imgFrmSubmit').click()" accept="image/*">
	<input type="button" value="Add Image" onclick="document.getElementById('userImage').click()" />
</form>
</div>

</div>
</body>
</html>