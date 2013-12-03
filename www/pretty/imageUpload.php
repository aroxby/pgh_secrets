<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/common.php');
noCache();

function mt_rand_str($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890')
{
	for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
	return $s;
}

function checkName($imageName)
{
	if(file_exists('temp_images/'.$imageName)) return false;
	if(file_exists('../images/mcTool/'.$imageName)) return false;
	return true;
}

function generateName($prefix, $suffix)
{
	/* WARNING WARNING WARNING
	There is a chance of collision here, you can fix this by
	Making sure that only one  thread ever executes this function
	at once and adding a usleep(1) to the end.
	Accomplishing this behavior would be easier if you create
	and external tool and call it with exec()
	
	In the mean time we just use checkName() instead
	
	WARNING WARNING WARNING */
	
	for(;;)
	{
		$r = mt_rand_str(16);
		$name = $prefix.$r.$suffix;
		if(checkName($name)) return $name;
	}
}

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
	
	//Do not allow php extensions
	$isPHP = preg_match('/\.ph(p3?|tml)$/', $img['name']);
	$isPHPS = preg_match('/\.phps$/', $img['name']);
	if($isPHP!=0 || $isPHPS!=0)
	{
		header('HTTP/1.0 415 Unsupported Media Type');
		exit;
	}
	
	$ext = end(explode('.', $img['name']));
	$temp_folder = 'temp_images';
	$path = dirname(__FILE__).'/'.$temp_folder;
	
	//$newfile = tempnam($path, 'mc_img_tmp').'.'.$ext;
	$newfilebase = generateName('mc_img_', '.'.$ext);
	$newfile = $path.'/'.$newfilebase;
	
	move_uploaded_file($file, $newfile);
	
	//Resize image
	$resizer = new Imagick($newfile);
	$resizer->cropThumbnailImage(200,200);
	$resizer->writeImage($newfile);
	
	//Delete this file in 6 hours
	//there are many better ways to accomplish this task but they are exponentially more complex
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
