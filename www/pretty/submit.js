function dump(x)
{
	var s = '';
	for(y in x)
	{
		s += '' + y + '->' + x[y] + '\n';
	}
	alert(s);
}

window.onbeforeunload = function()
{
	//return "If you leave this page now your mission will not be saved!  Are you sure you want to leave?";
}

function pulseTextStep(node)
{
	var o = node.css('opacity');
	o -= 0.05;
	if(o<0.1) o = 1;
	node.css('opacity', o);
}

function startPulseText(jqNode)
{
	setInterval(function(){pulseTextStep(jqNode);}, 50);
}

function copyElements()
{
	//var ids = ['name', 'neighborhood', 'tags', 'description', 'estHours', 'estMinutes', 'startdate', 'enddate', 'ordered', 'photo', 'imageJSON', 'locationJSON'];
	var ids = ['name', 'neighborhood', 'tags', 'description', 'estHours', 'estMinutes', 'startdate', 'enddate', 'ordered', 'photo'];
	for(var i = 0; i<ids.length; i++)
	{
		var node = document.getElementById(ids[i]);
		var val = node.type=='checkbox'?node.checked:node.value;
		document.getElementById('final_'+ids[i]).value = val;
	}
	
	document.getElementById('final_imageJSON').value = getImageJSON();
	document.getElementById('final_locationJSON').value = getLocationJSON();
}

function masterSubmit()
{
	$('#finalSubmit').prop('disabled', true);
	
	$('#SavingText').removeClass('hiddenForSubmit');
	
	copyElements();
	
	$('#completeFormSubmitConrol').click();
}

function complete(success)
{
	$('#SavingText').addClass('hiddenForSubmit');
	
	if(success)
	{
		$('#FinishedText').removeClass('hiddenForSubmit');
	}
	else
	{
		$('#finalSubmit').prop('disabled', false);
	}
}

(function()
{
	$('#completeForm').ajaxForm({
		beforeSubmit: function()
		{
		},
		uploadProgress: function(event, position, total, percentComplete)
		{
		},
		success: function(responseText, xhr)
		{
			//alert(responseText);
			//complete(true);
		},
		error: function(xhr)
		{
			if(xhr.status==500)
			{
				alert('Server error, please try again later (or right now).');
			}
			else
			{
				alert('Upload failed!  Either the server is down or you have lost your internet connection.');
			}
			
			complete(false);
		}
	});
})();

window.addEventListener("load", function(){startPulseText($('#SavingText'));}, false);
