<?php


require "./apivars.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$tweet_id=$_GET['tweet'];
$image=$_GET['image'];
header('Content-type: application/json');

$sql = "SELECT * FROM IMAGES WHERE IMAGE='".$image."'";
$respons=$conn->query($sql);
if ($respons->num_rows < 1) {
	// Expires - when the signature will become invalid (UNIX timestamp) - may be no more than 1200 seconds from now.
	$expires = time()+300;
	// Generate auth
	$stringToHash = $uid."-".$expires."-".$apikey; 
	$auth = md5($stringToHash);
	
	
	
	$images = array($image);
	$data = array("uid"=>$uid,"expires"=>$expires,"auth"=>$auth,"images"=>$images,"multiple"=>1);
	$json = json_encode($data);
	$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST', 
				"Content-Type: application/json\r\n",
				'content' => $json 
			)
		));
	$response = file_get_contents("https://incandescent.xyz/api/add/", FALSE, $context);
	$respObj=json_decode($response);
	
	
	
	
	
	$sql = "INSERT INTO IMAGES(TWEET, IMAGE,PROJECT) VALUES ('".$tweet_id."', '".$image."', '".$respObj->{"project_id"}."')" ;
	
	if ($conn->query($sql) === TRUE) {
	    $myObj->message="200";
	    echo json_encode($myObj);
	} else {
	    $myObj->message=$conn->error;
	    echo json_encode($myObj);
	}
}else{
    $myObj->message="200";
    echo json_encode($myObj);
}



$conn->close();
?>