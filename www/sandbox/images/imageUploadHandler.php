<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/common.php');
noCache();

/*
413 Request Entity Too Large
415 Unsupported Media Type
*/

echo "<pre>";
print_r($_FILES);
echo "</pre>";
?>