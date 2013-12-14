<?php
//Include or basic functions
include($_SERVER['DOCUMENT_ROOT'].'/scripts/common.php');
//Do not cache this page
noCache();

//Generates a random string
function mt_rand_str($l, $c = 'abcdefghijklmnopqrstuvwxyz0123456789')
{
	for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
	return $s;
}

//Check to see if a valid name will be vaild for both locations
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
	
	In the mean time we just use checkName() instead, the chances of collision are less than the chances of the sun expanding the swallow the earth
	
	WARNING WARNING WARNING */
	
	//Keep generatign filename until one works for us
	for(;;)
	{
		$r = mt_rand_str(16);
		$name = $prefix.$r.$suffix;
		if(checkName($name)) return $name;
	}
}

//Convert a string the form of 5MB to a number for bytes
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

//The file was over maximum size for the web server (no other data will be available)
if($_SERVER['CONTENT_LENGTH'] > convert_to_bytes(ini_get('post_max_size')))
{
	header('HTTP/1.0 413 Request Entity Too Large');
	exit;
}

@$img = $_FILES['userImage'];
if(isset($img))
{
	//The file is over maximum size for PHP engine
	$err = $img['error'];
	if($err===UPLOAD_ERR_INI_SIZE || $err===UPLOAD_ERR_FORM_SIZE)
	{
		header('HTTP/1.0 413 Request Entity Too Large');
		exit;
	}
	
	//The upload did not contain a file
	if($err===UPLOAD_ERR_NO_FILE) exit;
	
	//Some other error
	if($err!==UPLOAD_ERR_OK)
	{
		header('HTTP/1.0 500 Internal Server Error');
		exit;
	}

	//Make sure file is an iamge
	$file = $img['tmp_name'];
	if(exif_imagetype($file)===false)
	{
		header('HTTP/1.0 415 Unsupported Media Type');
		exit;
	}
	

	//Generate a new  name for it
	$temp_folder = 'temp_images';
	$path = dirname(__FILE__).'/'.$temp_folder;	
	$newfilebase = generateName('mc_img_', '.jpg');
	$newfile = $path.'/'.$newfilebase;
	
	move_uploaded_file($file, $newfile);
	
	//Resize image
	$resizer = new Imagick($newfile);
	$resizer->cropThumbnailImage(200,200);
	$resizer->setImageFormat('jpeg');
	$resizer->setCompressionQuality(90);
	$resizer->writeImage($newfile);
	
	//Delete this file in 6 hours
	//there are many better ways to accomplish this task but they are exponentially more complex
	exec('(sleep 21600; rm -f '.escapeshellarg($newfile).') > /dev/null 2>&1 &');
	
	//This should probably use some type of encoding
	echo $temp_folder.'/'.basename($newfile);
}
else
{
	//The upload did not contain a the correct field
	header('HTTP/1.0 500 Internal Server Error');
	exit;
}
?>
