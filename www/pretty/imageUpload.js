function generateNextPreviewID()
{
	var id = generateNextPreviewID.baseString + generateNextPreviewID.nextID;
	generateNextPreviewID.nextID++
	return id;
}
generateNextPreviewID.baseString = 'previewAutoID';
generateNextPreviewID.nextID = 0;

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
	
	rev.src = 'x.png';
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

function validateFileInput(inputID)
{
	var input = document.getElementById(inputID);
	
	if(!input.files || input.files.length != 1) return false;
	
	//!4MB
	if(input.files[0].size > 4194304)
	{
		//!4MB
		alert('File is too large!  Maximum size if 4 megabytes');
		return false;
	}

	return true;
}

(function()
{
	var bar;
	$('#ajaxImgFrm').ajaxForm({
		beforeSubmit: function()
		{
			if(!validateFileInput('userImage'))
			{
				$('#userImage').val('');
				return false;
			}
			bar = $( addUploadNode('previewContainer') );
		},
		uploadProgress: function(event, position, total, percentComplete)
		{
			var percentVal = percentComplete + '%';
			bar.width(percentVal);
		},
		success: function(responseText, xhr)
		{
			var percentVal = '100%';
			bar.width(percentVal);
			bar.parent().parent().remove();
			$('#userImage').val('');
			var id = addPreviewNode('previewContainer', responseText);
			getImageJSON.Obj[id] = responseText;
		},
		error: function(xhr)
		{
			if(xhr.status==413)
			{
				//!4MB
				alert('File is too large!  Maximum size if 4 megabytes');
			}
			else if(xhr.status==415)
			{
				alert('That image type is not supported.');
			}
			else if(xhr.status==500)
			{
				alert('Server error, please try again later (or right now).');
			}
			else
			{
				alert('Upload failed!  Either the server is down or you have lost your internet connection.');
			}
			
			bar.parent().parent().remove();
			$('#userImage').val('');
		}
	});
})();


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