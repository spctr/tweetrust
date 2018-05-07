<?php
require 'tmhOAuthExample.php';
$tmhOAuth = new tmhOAuthExample();

header('Content-type: application/json');


$code = $tmhOAuth->apponly_request(array(
    'url' => $tmhOAuth->url('1.1/statuses/show'),
    'params' => array(
      'id' => $_GET['q']
    )
  ));

  if ($code == 200) {
  echo $tmhOAuth->response['response'];  
  }else{
 	echo "001";
  }

 ?>  

