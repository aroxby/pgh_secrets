<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/common.php');
noCache();

function convert_to_bytes($input)
{
	preg_match('/(\d+)(\w+)/', $input, $matches);
	$type = strtolower($matches[2]);
	switch ($type) {
	default:
	case "b":
		$output = $matches[1];
		break;
	case "k":
		$output = $matches[1]*1024;
		break;
	case "m":
		$output = $matches[1]*1024*1024;
		break;
	case "g":
		$output = $matches[1]*1024*1024*1024;
		break;
	}
	return $output;
}

if($_SERVER['CONTENT_LENGTH'] > convert_to_bytes(ini_get('post_max_size')))
{
	header('HTTP/1.0 413 Request Entity Too Large');
	exit;
}

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
	
	$temp_folder = 'temp_images';
	$path = dirname(__FILE__).'/'.$temp_folder;
	$newfile = tempnam($path, 'mc_img_tmp');
	move_uploaded_file($file, $newfile);
	//Delete this file in 6 hours
	//there are manybetter ways to accomplish this task but they are exponentially more complex
	exec('(sleep 21600; rm -f '.escapeshellarg($newfile).') > /dev/null 2>&1 &');
	
	//This should probably use some type of encoding
	echo $temp_folder.'/'.basename($newfile);
}
else
{
	header('HTTP/1.0 500 Internal Server Error');
	exit;
}
?>
