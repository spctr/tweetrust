<?php


require "./apivars.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$image=$_GET['image'];
$sql = "SELECT PROJECT FROM IMAGES WHERE IMAGE='".$image."'";
$result=$conn->query($sql);
$conn->close();
header('Content-type: application/json');
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $project=$row["PROJECT"];
	

// Expires - when the signature will become invalid (UNIX timestamp) - may be no more than 1200 seconds from now.
$expires = time()+300;
// Generate auth
$stringToHash = $uid."-".$expires."-".$apikey; 
$auth = md5($stringToHash);


$data = array("uid"=>$uid,"expires"=>$expires,"auth"=>$auth,"project_id"=>$project);
$json = json_encode($data);
$context = stream_context_create(array(
		'http' => array(
			'method' => 'POST', 
			"Content-Type: application/json\r\n",
			'content' => $json 
		)
	));
$response = file_get_contents("https://incandescent.xyz/api/get/", FALSE, $context);




echo $response ;
}else{
	echo json_encode(json_decode("{}"));
}

?>