<?php
include($_SERVER['DOCUMENT_ROOT'].'/scripts/common.php');
noCache();
echo "<pre>";
print_r($_FILES['images']);
echo "</pre>";
?>