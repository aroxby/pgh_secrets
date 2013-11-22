<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

$db = connectDB();
$result['OK'] = 1;

//the crazy 'replace' here removed spaces from around tags
$stmt = $db->prepare("select id, name, type, replace(replace(tags,', ',','),' ,',','), neighborhood from mission ".
"where (year(startDate)<=0) or (year(startDate)>0 and now() between startDate and endDate) order by sortOrder asc");
$stmt->execute();
bind_array($stmt, $rows);
while($stmt->fetch())
{
	$this_row = copyarray($rows);
	renameKey($this_row, "replace(replace(tags,', ',','),' ,',',')", "tags");
	$result['missions'][] = $this_row;
}

$stmt->close();
$db->close();

echo '['.json_encode($result).']';

?>