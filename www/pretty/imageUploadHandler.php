<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/common.php');
noCache();

/*
413 Request Entity Too Large
415 Unsupported Media Type
500 Internal Server Error
$f = tempnam('/tmp', 'img_tmp');
exec('(sleep 20; rm -f '.escapeshellcmd($f).') > /dev/null 2>&1 &');
*/

@$img = $_FILES['userImage'];
if(isset($img))
{
	$err = $img['error'];
	if($err===UPLOAD_ERR_INI_SIZE || $err===UPLOAD_ERR_FORM_SIZE)
	{
		header('HTTP/1.0 413 Request Entity Too Large');
		exit;
	}
	
	if($err===UPLOAD_ERR_NO_FILE) exit;
	if($err!==UPLOAD_ERR_OK)
	{
		header('HTTP/1.0 500 Internal Server Error');
		exit;
	}

	$file = $img['tmp_name'];
	if(exif_imagetype($file)===false)
	{
		header('HTTP/1.0 415 Unsupported Media Type');
		exit;
	}
	
	//later use that crazy command to return the name of a file that will be saved for 24hrs
	//Also, some type of encoding is called for, instead of just using the plain text
	echo $file;
}
?>