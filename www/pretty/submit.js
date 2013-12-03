function confirmExit()
{
	if(!confirmExit.submitted) return "If you leave this page now your mission will not be saved!  Are you sure you want to leave?";
}
confirmExit.submitted = false;
window.onbeforeunload = confirmExit;

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
	var ids = ['name', 'neighborhood', 'type', 'description', 'tags', 'shown', 'estHours', 'estMinutes', 'startdate', 'enddate', 'ordered', 'photo'];
	var requiredRange = 4;
	for(var i = 0; i<ids.length; i++)
	{
		var node = document.getElementById(ids[i]);
		var val = node.type=='checkbox'?node.checked:node.value;
		//Possible optimization point: use two loops
		if(i<requiredRange && val=='')
		{
			var name = ids[i];
			//HACK
			if(name=='type') name = 'category';
			alert('You MUST enter a value for ' + name + '!');
			return false;
		}
		
		document.getElementById('final_'+ids[i]).value = val;
	}
	
	document.getElementById('final_imageJSON').value = getImageJSON();

	var locJson = getLocationJSON();
	if(locJson===0)
	{
		return false;
	}
	else if(locJson==='[]')
	{
		alert('You must save at least one location!');
		return false;
	}
	document.getElementById('final_locationJSON').value = locJson;
	
	return true;
}

function masterSubmit(keepBtn)
{
	if(keepBtn==0) $('#finalSubmit').prop('disabled', true);
	if( confirm('Are you sure you want to submit your mission?  You will not be able to change your mission once submitted, so be sure!') && copyElements() )
	{
		$('#SavingText').removeClass('hiddenForSubmit');
		$('#completeFormSubmitConrol').click();
	}
	else
	{
		$('#finalSubmit').prop('disabled', false);
	}
}

function complete(success)
{
	$('#SavingText').addClass('hiddenForSubmit');
	
	if(success)
	{
		$('#FinishedText').removeClass('hiddenForSubmit');
		confirmExit.submitted = true;
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
			node = document.getElementById('php-sql');
			if(node) node.innerText = responseText;
			
			complete(true);
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
