<?
function get404($path)
{
	$pre404 = "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL ";
$post404 = " was not found on this server.</p>
<hr>
<address>Apache/2.2.22 (Ubuntu) Server at ".$_SERVER['HTTP_HOST']." Port ".$_SERVER['SERVER_PORT']."</address>
</body></html>
";

return $pre404.$path.$post404;
}

function getMy404()
{
	return get404($_SERVER['PHP_SELF']);
}

function dropDirectRequest($me)
{
	if(basename($me)===basename($_SERVER['PHP_SELF']))
	{
		header('HTTP/1.1 404 Not Found');
		exit(getMy404());
	}
}

function copyArray($arr)
{
	$keys = array_keys($arr);
	foreach ($keys as $key)
	{
		$return[$key] = $arr[$key];
	}
	return $return;
}

dropDirectRequest(__FILE__);

?>