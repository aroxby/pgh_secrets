<?php
//include relevant PHP code
include(dirname(__FILE__).'/authoring.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Create Mission - Pittsburgh Secrets</title>
<!-- For each phase (general/author, images, maps, and submission) there is a .css and .js (and .php) -->
<link rel="stylesheet" type="text/css" href="authoring.css">
<link rel="stylesheet" type="text/css" href="imageUpload.css">
<link rel="stylesheet" type="text/css" href="maps.css">
<link rel="stylesheet" type="text/css" href="submit.css">
<script type="text/javascript" src="authoring.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript" src="imageUpload.js"></script>
<script type="text/javascript" src="maps.js"></script>
<script type="text/javascript" src="submit.js"></script>
</head>

<body>
<div id="mainDiv"><form method="post" id="missionForm" action="#">
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
You can also include "Tags" which serve as and keywords for the mission.  Tags are seperated by commas.<br/>Below, you can see how your input will become tags.
<? input(50, 'Tags:', 'text', 'tags', 'Music, Banjo, Elks',
array('userhtml'=>tagSpan('tagSpan'), 'examplehtml'=> tagSpan('tagSpanEx'))
); ?>
Your mission also needs a description, to let players know what it's about and what they should do.
<? input(7, 'Description:', 'textarea', 'description', 'Come to the Elk\'s lodge and sing along with the banjo!'); ?>
You will need to choose a category for your mission to help user's find mission that intrest them.
<? input(7, 'Category:', 'select', 'type', typeList('Art & Culture'), array('userVal' => typeList('')) ); ?>
You should enter an estimage of how long it will take to complete your mission.
<? input(10, 'Hours:', 'number', 'estHours', '2', array('skipreturn'=>true)); ?>
<? input(10, 'Minuites:', 'number', 'estMinutes', '43'); ?>
If your mission will only available for a certain date range, enter it below, if not skip this step.
<? input(10, 'Start date:', 'date', 'startdate', '2013-08-15', array('skipreturn'=>true)); ?>
<? input(10, 'End date:', 'date', 'enddate', '2014-05-28'); ?>
Should the user 'check in' to this mission by taking photographs?  If so, check this box.
<? input(10, 'Photo-Based Check in', 'checkbox', 'photo', ''); ?>
Should the user be able to see the locations on the map?  If you only want the user to see the mission area and have to search for the exact locations, clear this box.
<? input(10, 'Show locations', 'checkbox', 'shown', 'true',  array('userVal' => 'true')); ?>
</form>
<h3>Things get a little harder to demonstrate here, so the right hand side examples end.  Read the text carefully.</h3><br/>
Your mission needs some locations!  Drag the red marker to where you want your next location to be and then resize the blue circle to shape the check-in radius (make sure it's large!  The iPhone GPS is only accurate to 5 meters, so you should add 10m of padding to your radius).  Once you are happy with your choices, click 'Save Location'.  You will see a list of the locations you chose appear on the left.  You can click on the <img src="Magnify.gif" /> to review a location or the <span class="deleteText">X</span> to remove a location.
<br/>Due to technical limitations on the GPS the please ensure your radius at least 10 meters (smaller radii may work but this is not guaranteed).
<br/><b>DON'T FORGET</b> to name your location, this name show up on the map annotation in the app.

<div id="MapStuffz">

<div id="locationControls">
<div id="locationFormControls">
<form id="locationForm">
<input type="button" value="Save Location" onclick="saveLocaton()" />
<div id="orderingCheckbox">
<label>User must visit locations in this exact order</label>
<input type="checkbox" id="ordered"/></div>
</form>
</div>
<div id="locationTableContainer">
<table id="LocationTable">
</table>
</div></div>

<div id="MapContainer">
<!-- Google Map goes here -->
</div>

</div>
<br/><br/>
You should probably also add images to your mission.  Simply click on the add image button and choose the image you wish to add.
<div id="previewContainer">
<form action="imageUpload.php" method="post" id="ajaxImgFrm" enctype="multipart/form-data">
	<input type="submit" class="hiddenForImage" id="imgFrmSubmit" />
	<input type="file" name="userImage" id="userImage" class="hiddenForImage" onchange="document.getElementById('imgFrmSubmit').click()" accept="image/*">
	<input type="button" value="Add Image" onclick="document.getElementById('userImage').click()" />
</form>
</div>

<br/><br/>
When you're finished, press the 'Save Mission' button (only once).
<!-- These fields hold the actual data used to create the mission -->
<form id="completeForm" method="POST" action="postMission.php">
<input type="hidden" id="final_name" name="name" />
<input type="hidden" id="final_neighborhood" name="neighborhood" />
<input type="hidden" id="final_tags" name="tags" />
<input type="hidden" id="final_type" name="type" />
<input type="hidden" id="final_description" name="description" />
<input type="hidden" id="final_estHours" name="estHours" />
<input type="hidden" id="final_estMinutes" name="estMinutes" />
<input type="hidden" id="final_startdate" name="startdate" />
<input type="hidden" id="final_enddate" name="enddate" />
<input type="hidden" id="final_ordered" name="ordered" />
<input type="hidden" id="final_photo" name="photo" />
<input type="hidden" id="final_shown" name="shown" />
<input type="hidden" id="final_imageJSON" name="imageJSON" />
<input type="hidden" id="final_locationJSON" name="locationJSON" />
<input type="submit" class="hiddenForSubmit" id="completeFormSubmitConrol" />

<?
//This debugging step will allow a mission to be submission multiple times in a row, use with caution.
//Set ?debug=1 to activate
if($_GET['debug']==1)
{
echo '<input type="button" class="finalSubmit" id="finalSubmit" value="Save Mission!" onclick="masterSubmit(1)"/>';
}
else
echo '<input type="button" class="finalSubmit" id="finalSubmit" value="Save Mission!" onclick="masterSubmit(0)"/>';
?>

</form>

<h3 id="SavingText" class="hiddenForSubmit submitStatus">Saving your mission DON'T LEAVE THIS PAGE</h3>
<h3 id="FinishedText" class="hiddenForSubmit submitStatus">Finished!  Your mission is saved.</h3>

<?
if($_GET['debug']==1)
{
	//This debugging step will you to see the text response the server after submitting a mission
	echo '<textarea style="width:100%;height:500px" id="php-sql"></textarea>';
}
?>

</div>
</body>
</html>
