<?php

$route = '/schedule/day/two/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $File = file_get_contents("http://austin2015.apistrat.com/schedule/daytwo.json");

  $ReturnObject = $File;

  $app->response()->header("Content-Type", "application/json");

  echo $File;

  });

?>
