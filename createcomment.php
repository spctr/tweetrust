
<?php

require "./apivars.php";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$tweet_id=$_GET['tweet'];
$comment=$_GET['comment'];
$comment=str_replace("'","",$comment);
$sql = "INSERT INTO COMMENTS(TWEET, COMMENT) VALUES ('".$tweet_id."', '".$comment."')";
header('Content-type: application/json');

if ($conn->query($sql) === TRUE) {
$sql = "SELECT ID FROM COMMENTS WHERE TWEET='".$tweet_id."' AND  COMMENT='".$comment."'";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
    $myObj->message=$row["ID"];
    echo json_encode($myObj);
} else {
    $myObj->message=$conn->error;
    echo json_encode($myObj);
}

$conn->close();
?>
