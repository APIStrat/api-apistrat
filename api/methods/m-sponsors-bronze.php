<?php

$route = '/sponsors/bronze/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $File = file_get_contents("http://austin2015.apistrat.com/sponsors/bronze.json");

  $ReturnObject = $File;

  $app->response()->header("Content-Type", "application/json");

  echo $File;

  });

?>
