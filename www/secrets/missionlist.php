<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

$db = connectDB();
$result['OK'] = 1;

$stmt = $db->prepare("select id, name from mission ".
"where (year(startDate)<=0) or (year(startDate)>0 and now() between startDate and endDate)");
$stmt->execute();
bind_array($stmt, $rows);
while($stmt->fetch())
{
	$result[] = copyArray($rows);
}

$stmt->close();
$db->close();

echo '['.json_encode($result).']';

?>