//This function generates HTML IDs for autogenerated elements
function generateNextPreviewID()
{
	var id = generateNextPreviewID.baseString + generateNextPreviewID.nextID;
	generateNextPreviewID.nextID++
	return id;
}
generateNextPreviewID.baseString = 'previewAutoID';
generateNextPreviewID.nextID = 0;

//This function creates an 'uploading' graphic in the image gallery
function addUploadNode(parentID)
{
	var div = document.createElement('div');
	var img = document.createElement('img');
	var barContainer = document.createElement('div');
	var bar = document.createElement('div');
	//Unicode char of nbsp
	var dummyText = document.createTextNode('\u00a0');

	div.id = generateNextPreviewID();
	div.className = 'uploadPreview';

	img.src = 'uploading.gif';
	img.className = 'uploadingImage';
	
	barContainer.className = 'progressBarContainer';
	
	bar.className = 'progressBar';
	
	bar.appendChild(dummyText);
	barContainer.appendChild(bar);
	div.appendChild(img);
	div.appendChild(barContainer);
	document.getElementById(parentID).appendChild(div);
	
	return bar;
}

//This function adds an uploaded image to the image gallery
function addPreviewNode(parentID, src)
{
	var div = document.createElement('div');
	var img = document.createElement('img');
	var rev = document.createElement('img');
	var anchor = document.createElement('a');
	
	div.id = generateNextPreviewID();
	div.className = 'uploadPreview';
	anchor.className = 'removeAnchor';
	
	img.src = src;
	img.className = 'previewImage';
	
	rev.src = 'x.gif';
	rev.className = 'removeIcon';
	rev.onclick = function()
	{
		div.parentNode.removeChild(div);
		//An ajax post could be made to tell the server to delete the file
		//but the risk out weighs the reward in this setup.
		delete getImageJSON.Obj[div.id]
	};
	
	anchor.href='javascript:void(0)';
	anchor.appendChild(rev);
	
	div.appendChild(img);
	div.appendChild(anchor);
	document.getElementById(parentID).appendChild(div);
	
	return div.id;
}

//This function validates that the selected file will be able to upload
function validateFileInput(inputID)
{
	var input = document.getElementById(inputID);
	
	if(!input.files || input.files.length != 1) return false;
	
	//FIXME: UPLOAD MAX HAS BEEN HARDCODED!
	if(input.files[0].size > 4194304)
	{
		//FIXME: UPLOAD MAX HAS BEEN HARDCODED!
		alert('File is too large!  Maximum size if 4 megabytes');
		return false;
	}

	return true;
}

//This crazy block of code allows images to upload without leaving this page
(function()
{
	var bar;
	$('#ajaxImgFrm').ajaxForm({
		beforeSubmit: function()
		{
			//Validates the input
			if(!validateFileInput('userImage'))
			{
				//If the upload failed, we need to clear the hidden field to prevent it from tring again if the user presses enter
				$('#userImage').val('');
				return false;
			}
			//create upload graghic
			bar = $( addUploadNode('previewContainer') );
		},
		uploadProgress: function(event, position, total, percentComplete)
		{
			var percentVal = percentComplete + '%';
			bar.width(percentVal);
		},
		success: function(responseText, xhr)
		{
			//We're done
			var percentVal = '100%';
			//Remove the upload grahic
			bar.width(percentVal);
			bar.parent().parent().remove();
			//we need to clear the hidden field to prevent it from tring again if the user presses enter
			$('#userImage').val('');
			//Add the uploaded image
			var id = addPreviewNode('previewContainer', responseText);
			//Store this image name for later retrieval
			getImageJSON.Obj[id] = responseText;
		},
		error: function(xhr)
		{
			//Failure, 413 Request Entity Too Large
			if(xhr.status==413)
			{
				//FIXME: UPLOAD MAX HAS BEEN HARDCODED!
				alert('File is too large!  Maximum size if 4 megabytes');
			}
			//Failure, 415 Unsupported Media Type
			else if(xhr.status==415)
			{
				alert('That image type is not supported.');
			}
			//Failure, 500 Internal Server Error
			else if(xhr.status==500)
			{
				alert('Server error, please try again later (or right now).');
			}
			//Failure, other/unknown, most likely cause is an interrupted connection
			else
			{
				alert('Upload failed!  Either the server is down or you have lost your internet connection.');
			}
			
			//Remove the upload graphic
			bar.parent().parent().remove();
			//we need to clear the hidden field to prevent it from tring again if the user presses enter
			$('#userImage').val('');
		}
	});
})();

//Retrieves a JSON array of uploaded images for final submission
function getImageJSON()
{
	var newObj = [];
	for(i in getImageJSON.Obj)
	{
		newObj.push(getImageJSON.Obj[i]);
	}
	return JSON.stringify(newObj);
}
getImageJSON.Obj = {};
