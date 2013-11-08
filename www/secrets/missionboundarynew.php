<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

function mult($sp,$ep,$op){
	return ($sp[lat] - $op[lat]) * ($ep[lng] - $op[lng])
        >= ($ep[lat] - $op[lat]) * ($sp[lng] - $op[lng]);
}

function cmp($l,$r){
    if($l[lng] == $r[lng]) return $l[lat] < $r[lat];
    else return $l[lng] < $r[lng];
}

    if($_POST['missionID']!=''){
	$db = connectDB();
	$result['OK'] = 1;
	$result['error'] = "No error.";
	
	$stmt = $db->prepare("select location.lat, location.lng from location, missionlocation where missionlocation.missionID=? and missionlocation.locationID=location.id");
	$stmt->bind_param('i', $_POST['missionID']);
	$stmt->execute();
	//$stmt->bind_result($lattemp, $lngtemp);
    bind_array($stmt, $row);
    $point_NUM = 0;
	while($stmt->fetch()){
        $points[] = copyArray($row);
        $point_NUM ++;
	}
	$stmt->close();
    
    
    
	usort($points, "cmp");
    
	$vertices = array();
	$top = 1;
        
    //echo $point_NUM;
	
	if($point_NUM == 0 ){ $result[vertice_NUM] = 0;}
	else if ( $point_NUM == 1){
        $result[vertice_NUM] = 4;
        $vertices[0] = $points[0];
        $centerpoint = $points[0];
        $vertices[0][lat] = $points[0][lat]+0.0001;
        $vertices[0][lng] = $points[0][lng]+0.0001;
        $vertices[1][lat] = $points[0][lat]+0.0001;
        $vertices[1][lng] = $points[0][lng]-0.0001;
        $vertices[2][lat] = $points[0][lat]-0.0001;
        $vertices[2][lng] = $points[0][lng]-0.0001;
        $vertices[3][lat] = $points[0][lat]-0.0001;
        $vertices[3][lng] = $points[0][lng]+0.0001;
    }
	else if ($point_NUM == 2){
        $result[vertice_NUM] = 4;
        $vertices[0] = $points[0];
        $vertices[1] = $points[1];
        $centerlat = ($points[0][lat]+$points[1][lat])/2;
        $centerlng = ($points[0][lng]+$points[1][lng])/2;
        $centerpoint[lat] = $centerlat;
        $centerpoint[lng] = $centerlng;
        $vertices[0][lat] = $points[0][lat]*1.5 - $centerlat*0.5;
        $vertices[0][lng] = $points[0][lng]*1.5 - $centerlng*0.5;
        $vertices[2][lat] = $points[1][lat]*1.5 - $centerlat*0.5;
        $vertices[2][lng] = $points[1][lng]*1.5 - $centerlng*0.5;
        $vertices[1][lat] = $vertices[0][lat];
        $vertices[1][lng] = $vertices[2][lng];
        $vertices[3][lat] = $vertices[2][lat];
        $vertices[3][lng] = $vertices[0][lng];
    }
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
			while($top!=$length && mult($points[$i], $vertices[top], $vertices[$top-1])){
				$top--;				
			}
			$vertices[++$top] = $points[$i];
		}
		$result[vertice_NUM] = $top;
        //echo $top;
        //print_r($vertices[0]);
        //print_r($vertices[1]);
        //print_r($vertices[2]);
        
        $sumlat = 0;
        $sumlng = 0;
        for($i = 0;$i < $top; $i++){
            $sumlat += $vertices[$i][lat];
            $sumlng += $vertices[$i][lng];
            //print_r($vertices[$i]);
        }
        $sumlat /= $top;
        $sumlng /= $top;
        
        $centerpoint[lat] = $sumlat;
        $centerpoint[lng] = $sumlng;
        
        for($i = 0;$i < $top; $i++){
            $vertices[$i][lat] = (1.5 * $vertices[$i][lat] - 0.5 * $sumlat);
            $vertices[$i][lng] = 1.5 * $vertices[$i][lng] - 0.5 * $sumlng;
            //print_r($vertices[$i]);
        }

	}
    $result['center'] = $centerpoint;
        
    for($i = 0;$i < $result[vertice_NUM]; $i++){
		$result['vertices'][$i] = $vertices[$i];
	}
}
else
{
	$result['OK'] = 0;
	$result['error'] = "Not enough data";
}

echo '['.json_encode($result).']';
?>