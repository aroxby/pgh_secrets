function dump(x)
{
	var s = '';
	for(y in x)
	{
		s += '' + y + '->' + x[y] + '\n';
	}
	alert(s);
}

function generateNextPreviewID()
{
	var id = generateNextPreviewID.baseString + generateNextPreviewID.nextID;
	generateNextPreviewID.nextID++
	return id;
}
generateNextPreviewID.baseString = 'previewAutoID';
generateNextPreviewID.nextID = 0;

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
	
	rev.src = 'x.png';
	rev.className = 'removeIcon';
	rev.onclick = function()
	{
		document.getElementById(div.id).remove();
		//An ajax post could be made to tell the server to delete the file
		//but the risk out weighs the reward in this setup.
	};
	
	anchor.href='javascript:void(0)';
	anchor.appendChild(rev);
	
	div.appendChild(img);
	div.appendChild(anchor);
	document.getElementById(parentID).appendChild(div)
}

(function()
{
	var bar = $('.bar');
	var percent = $('.percent');
	$('#imgFrm').ajaxForm({
		beforeSend: function()
		{
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		uploadProgress: function(event, position, total, percentComplete)
		{
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		success: function(responseText, xhr)
		{
			var percentVal = '100%!';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		error: function(xhr)
		{
			//Also need handlers for 413 and 500
			if(xhr.status==415)
			{
				alert("That image type is not supported.");
			}
			else
			{
				alert("Upload failed!  Either the server is down or you have lost your internet connection.");
			}
		}
	});

})();