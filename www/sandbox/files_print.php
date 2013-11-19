<html><body><pre>
<?
function convert_to_bytes($input)
{
	$output = 'xydsf';
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
	echo "File over size!\n";
}
else
{
	echo "File size OK!\n";
}
echo $_SERVER['CONTENT_LENGTH'].' vs '.convert_to_bytes(ini_get('post_max_size'))."\n";

print_r($_POST);
echo '<hr/>';
print_r($_FILES);
echo '<hr/>';
$type = exif_imagetype($_FILES['userImage']['tmp_name']);
if($type===false) $type = 'terabyte_false';
echo 'type = '.$type."\n";
echo '<hr/>';
?>
</pre>
</body></html>