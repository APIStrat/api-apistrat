<?php

$route = '/schedule/day/three/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $File = file_get_contents("http://austin2015.apistrat.com/schedule/daythree.json");

  $ReturnObject = $JSONSchedule;

  //$ReturnObject['updated'] = 1;
  $app->response()->header("Content-Type", "application/json");

  echo stripslashes(json_encode($File));

  });

?>
