<?php
require 'tmhOAuthExample.php';
header('Content-type: application/json');
$tmhOAuth = new tmhOAuthExample();






$code = $tmhOAuth->apponly_request(array(
    'url' => $tmhOAuth->url('1.1/search/tweets'),
    'params' => array(
      'q' => $_GET['q'],
      'since' => $_GET['since'],
      'until' => $_GET['until'],
      'since_id' => $_GET['since_id'],
      'max_id' => $_GET['max_id'],
      'count'=>5
    )
  ));

  if ($code == 200) {
  	$result=json_decode($tmhOAuth->response['response']);  
  }
  else { 
  	$resultObj->error=$tmhOAuth->response['error'];
	echo json_encode($resultObj);
	return;
  } 
  $resultObj->count=count($result->statuses);
  if($resultObj->count>0){
  $resultObj->tweet=$result->statuses[$resultObj->count-1]->id_str;
  
  }
  $resultJson=json_encode($resultObj);

 
  echo $resultJson;
?>