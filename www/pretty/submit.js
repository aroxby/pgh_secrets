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

function masterSubmit()
{
	$('#finalSubmit').prop('disabled', true);
	
	$('#SavingText').removeClass('hidden');
	
	$('#completeFormSubmitConrol').click();
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
		}
	});
})();
