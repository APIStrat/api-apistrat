<?php

$route = '/schedule/update/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $ReturnObject['updated'] = 1;

  $app->response()->header("Content-Type", "application/json");
  echo format_json(json_encode($ReturnObject));

  });

?>
