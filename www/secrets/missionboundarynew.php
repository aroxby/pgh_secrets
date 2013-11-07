<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

class Point{
	public $lat;//x
	public $lng;//y
}

function mult($sp,$ep,$op){
	return ($sp->lat - $op->lat) * ($ep->lng - $op->lng)  
        >= ($ep->lat - $op->lat) * ($sp->lng - $op->lng); 
}

function cmp($l,$r){
	return $l->lng < $r->lng || ($l->lng == $r->lng && $l->lat < $r->lat);  
}

    if(1){//$_POST['missionID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error.";
	
	$stmt = $db->prepare("select location.lat, location.lng from location, missionlocation where missionlocation.missionID=1 and missionlocation.locationID=location.id");
	//$stmt->bind_param('i', $_POST['missionID']);
	$stmt->execute();
	//$stmt->bind_result($lattemp, $lngtemp);
    bind_array($stmt, $row);
    $point_NUM = 0;
	while($stmt->fetch()){
        $points[] = copyArray($row);
        $point_NUM ++;
	}
    //echo $points[0][lat];
    //echo $points[5][lat];
	$stmt->close();
    
    
    /*
	usort($points, "cmp");
	$vertices = array();
	$top = 1;
	
	if($point_NUM == 0 ){ $result[vertice_NUM] = 0;}
	else if ( $point_NUM == 1){$result[vertice_NUM] = 1;$vertices[0] = $points[0];}
	else if ( $point_NUM == 2){$result[vertice_NUM] = 2;$vertices[0] = $points[0];$vertices[1] = $points[1];}
	else{
		$vertices[0] = $points[0];
		$vertices[1] = $points[1];
		$vertices[2] = $points[2];
		for($i = 2; $i < $point_NUM; $i++){
			while ($top && mult($points[$i], $vertices[$top], $vertices[$top-1])){  
				$top--;
			}  
			$vertices[++$top] = $points[$i];
		}
		$length = $top;
		$vertices[++$top] = $points[$point_NUM-2];
		for($i = $point_NUM-3; $i >= 0; $i--){
			while(top!=length && mult($points[$i], $vertices[top], $vertices[$top-1])){
				$top--;				
			}
			$vertices[++$top] = $points[$i];
		}
		$result[vertice_NUM] = $top;
	}	
	for($i = 0;$i < count($vertices);$i++){
		$result[] = $vertices[$i];
	}*/
}
else
{
	$result['OK'] = 0;
	$result['error'] = "Not enough data";
}

//echo '['.json_encode($result).']';
?>