<?php

$route = '/schedule/update/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $File = fopen ("http://austin2015.apistrat.com/schedule/daytwo.json", "r");
  $JSONSchedule = json_encode($File);

  //$ReturnObject['updated'] = 1;
  $ReturnObject = $JSONSchedule;

  $app->response()->header("Content-Type", "application/json");
  echo format_json(json_encode($ReturnObject));

  });

?>
