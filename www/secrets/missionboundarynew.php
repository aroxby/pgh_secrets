<?php
include($_SERVER['DOCUMENT_ROOT']."/scripts/db.php");

    function sortPointX($a,$b){
    	if(($a[lng] - $b[lng]) > 0 ){return 1;}
    	else if(($a[lng] - $b[lng]) < 0 ){return -1;}
    	else{return 0;}
        //return $a[lng] - $b[lng];
    }
    function sortPointY($a,$b){
    	if(($a[lat] - $b[lat]) > 0){return 1;}
    	else if(($a[lat] - $b[lat]) < 0){return -1;}
    	else{return 0;}
        //return $a[lat] - $b[lat];
    }
    function isLeft($p0, $p1, $p2){
        return ($p1[lng] - $p0[lng])*($p2[lat] - $p0[lat]) - ($p2[lng] - $p0[lng])*($p1[lat] - $p0[lat]);
    }
    function chainHull_2D(&$P,$n,&$H){
        // the output array H[] will be used as the stack
        $bot = 0;
        $top = (-1); // indices for bottom and top of the stack
        $i = 0;
        // Get the indices of points with min x-coord and min|max y-coord
        $minmin = 0;
        $minmax = 0;
        
        $xmin = $P[0][lng];
        for ($i = 1; $i < $n; $i++) {
            if ($P[$i][lng] != $xmin) {
                break;
            }
        }
        
        $minmax = $i - 1;
        if ($minmax == $n - 1) { // degenerate case: all x-coords == xmin
            $H[++$top] = $P[$minmin];
            if ($P[$minmax][lat] != $P[$minmin][lat]) // a nontrivial segment
                $H[++$top] = $P[$minmax];
            $H[++$top] = $P[$minmin]; // add polygon endpoint
            return $top + 1;
        }
        
        // Get the indices of points with max x-coord and min|max y-coord
        $maxmin = 0;
        $maxmax = $n - 1;
        $xmax = $P[$n - 1][lng];
        for ($i = ($n - 2); $i >= 0; $i--) {
            if ($P[$i][lng] != $xmax) {
                break;
            }
        }
        $maxmin = $i + 1;
        
        // Compute the lower hull on the stack H
        $H[++$top] = $P[$minmin]; // push minmin point onto stack
        $i = $minmax;
        while (++$i <= $maxmin) {
            // the lower line joins P[minmin] with P[maxmin]
            if (isLeft($P[$minmin], $P[$maxmin], $P[$i]) >= 0 && $i < $maxmin) {
                continue; // ignore P[i] above or on the lower line
            }
            
            while ($top > 0) { // there are at least 2 points on the stack
                // test if P[i] is left of the line at the stack top
                if (isLeft($H[$top - 1], $H[$top], $P[$i]) > 0) {
                    break; // P[i] is a new hull vertex
                }
                else {
                    $top--; // pop top point off stack
                }
            }
            
            $H[++$top] = $P[$i]; // push P[i] onto stack
        }
        
        // Next, compute the upper hull on the stack H above the bottom hull
        if ($maxmax != $maxmin) { // if distinct xmax points
            $H[++$top] = $P[$maxmax]; // push maxmax point onto stack
        }
        
        $bot = $top; // the bottom point of the upper hull stack
        $i = $maxmin;
        while (--$i >= $minmax) {
            // the upper line joins P[maxmax] with P[minmax]
            if (isLeft($P[$maxmax], $P[$minmax], $P[$i]) >= 0 && $i > $minmax) {
                continue; // ignore P[i] below or on the upper line
            }
            
            while ($top > $bot) { // at least 2 points on the upper stack
                // test if P[i] is left of the line at the stack top
                if (isLeft($H[$top - 1], $H[$top], $P[$i]) > 0) {
                    break;  // P[i] is a new hull vertex
                }
                else {
                    $top--; // pop top point off stack
                }
            }
            
            if ($P[$i][lng] == $H[0][lng] && $P[$i][lat] == $H[0][lat]) {
                return $top + 1; // special case (mgomes)
            }
            
            $H[++$top] = $P[$i]; // push P[i] onto stack
        }
        
        if ($minmax != $minmin) {
            $H[++$top] = $P[$minmin]; // push joining endpoint onto stack
        }
        
        return $top + 1;
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
    
	$vertices = array();
        
    //echo $point_NUM;
	
	if($point_NUM == 0 ){ $result[vertice_NUM] = 0;}
	else if ( $point_NUM == 1){
        $result['vertice_NUM'] = 4;
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
        $result['vertice_NUM'] = 4;
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
        usort($points, "sortPointX");
        usort($points, "sortPointY");
        $result['vertice_NUM'] = chainHull_2D($points,$point_NUM,$vertices);
        $centerlat = 0;
        $centerlng = 0;
        for($i = 0;$i < $result['vertice_NUM'];$i++){
            $centerlat += $vertices[$i][lat];
            $centerlng += $vertices[$i][lng];
        }
        $centerpoint[lat] = $centerlat/$result['vertice_NUM'];
        $centerpoint[lng] = $centerlng/$result['vertice_NUM'];
	}
    $result['center'] = $centerpoint;
    //print_r($points[0]);
    //print_r($vertices[0]);
        
    for($i = 0;$i < $result['vertice_NUM']; $i++){
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