<?php

function bind_array($stmt, &$row) {
    $md = $stmt->result_metadata();
    $params = array();
    while($field = $md->fetch_field()) {
        $params[] = &$row[$field->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
}


$db = new mysqli("localhost", "pgh-challenge", "5NdSW4FaAqQXthqs", "game");
if(mysqli_connect_errno())
{
	echo "Database error. Try again later.";
	Die();
}


//echo missions from here
$stmt = $db->prepare("select id, name, description from mission");
$stmt->execute();
$stmt->bind_result($id, $name, $description);

$rows = array();
bind_array($stmt, $rows);
$stmt->fetch();
echo json_encode($rows);

//$result = $stmt->get_result();
//echo "s4";
/*
while ($row = $result->fetch_array(MYSQLI_ASSOC))
{
	$rows[] = $row;
}
echo "success";
//echo json_encode($rows);*/
$stmt->close();
$db->close();
?>