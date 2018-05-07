<?php

require "./apivars.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$comment_id=$_GET['comment'];
$sql = "SELECT TWEET, COMMENT FROM COMMENTS WHERE ID='".$comment_id."'";
$result=$conn->query($sql);
header('Content-type: application/json');
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$resultObj->comment=$row["COMMENT"];
    	$resultObj->tweet=$row["TWEET"];
    }
$resultJson=json_encode($resultObj);
header('Content-type: application/json');
echo $resultJson;
}else{
	echo json_encode(json_decode("{}"));
}



$conn->close();
?>