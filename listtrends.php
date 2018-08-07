<?php
require "./apivars.php";
$conn = new mysqli($servername, $username, $password, $dbname);
header('Content-type: application/json');

$sql="SELECT NAME,URL,SD FROM TRENDS WHERE CURRENT=1 AND SD>0 ORDER BY SD DESC";
if(!$result=$conn->query($sql))echo $conn->error();
if ($result->num_rows > 0) {
		    $trends=array();
		    while($row = $result->fetch_assoc()){
		    	array_push($trends,array('name' => $row["NAME"],'url' => $row["URL"],'sd'=>$row["SD"]));
		    }
		    echo json_encode($trends);
	}else{
	echo json_encode(json_decode("{}"));
	}	    
