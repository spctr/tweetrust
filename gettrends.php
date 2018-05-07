 <?php
require "./apivars.php";
$conn = new mysqli($servername, $username, $password, $dbname);
require 'tmhOAuthExample.php';
header('Content-type: application/json');
$tmhOAuth = new tmhOAuthExample();
$code = $tmhOAuth->apponly_request(array(
    'url' => $tmhOAuth->url('1.1/trends/place'),
    'params' => array(
    'id' => '2344116'
    )
  ));

  if ($code == 200) {
  	//echo  $tmhOAuth->response['response'];  
  	$sql="UPDATE TRENDS SET CURRENT=0 WHERE CURRENT=1";
  	if(!$conn->query($sql))echo $conn->error();
  	
  	$trends=json_decode($tmhOAuth->response['response'],true)[0]["trends"];
  	//echo json_encode($trends);
  	foreach($trends as $trend){
  		if(is_null($trend["tweet_volume"])){
	  		$tweet_volume=0;
  		}
  		else {
  			$tweet_volume=$trend["tweet_volume"];
  		}
  	//echo($trend);
  		$sql = "SELECT URL, VOLUME, FD FROM TRENDS WHERE URL='".$trend["url"]."'";
		if(!$result=$conn->query($sql))echo $conn->error();
		//var_dump($result);
		
		$newvolume=$tweet_volume;
		//header('Content-type: application/json');
		if ($result->num_rows > 0) {
		    $row = $result->fetch_assoc();
		    $lastvolume=$row["VOLUME"];
		    $lastdiff=$row["FD"];
		    $newdiff=$newvolume-$lastvolume;
		    $newsdiff=$newdiff-$lastdiff;
		    $sql="UPDATE TRENDS SET VOLUME=".$newvolume.", FD=".$newdiff.", SD=".$newsdiff.", CURRENT=1 WHERE URL='".$trend["url"]."'";
		    if(!$conn->query($sql))echo $conn->error();
		    
		    //var_dump($conn->query($sql));
  		}else{
	
  		$tname=$trend["name"];
  		$tname=str_replace("'","",$tname);
  		    $sql="INSERT INTO TRENDS(NAME,URL,VOLUME) VALUES('".$tname."','".$trend["url"]."',".$tweet_volume.")";  	
  		   
  		    if(!$conn->query($sql))echo $conn->error();
  		    //var_dump($conn->query($sql));
  		    
  		}
  		
  	}
  	echo json_encode(json_decode("{}"));
  }
  else { 
	echo $tmhOAuth->response['error'] ;
  } 

$conn->close();
?>