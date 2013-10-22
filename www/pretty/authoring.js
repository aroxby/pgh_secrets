function setupTags()
{
	var input = document.getElementById('tagsEx');
	var output = document.getElementById('tagSpanEx');
	processTagElements(input,output);
	
	var userInput = document.getElementById('tags');
	var userOutput = document.getElementById('tagSpan');
	userInput.addEventListener("keyup", function(){processTagElements(userInput,userOutput);}, false);
}

function processTagElements(input, output)
{
	output.innerHTML = processTagString(input.value);
}

function processTagString(str)
{
	var ret = '';
	var tags = str.split(',');
	for(var i = 0; i<tags.length; i++)
	{
		var s = tags[i].trim();
		if(s.length!=0) ret += '<span class="tagSpan">'+s+'</span><span>&nbsp;</span>';
	}
	
	return ret;
}

document.addEventListener("DOMContentLoaded", setupTags, false);
