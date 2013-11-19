<html><body>
<pre>
<?
echo 'post_max_size = ' . ini_get('post_max_size') . "\n";
echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . "\n";
?>
</pre>
<form action="files_print.php" method="post" id="imgFrm" enctype="multipart/form-data">
	<input type="file" name="userImage" id="userImage">
	<input type="submit" id="imgFrmSubmit" />
</form>
</body></html>