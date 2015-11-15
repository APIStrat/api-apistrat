<?php

$route = '/schedule/update/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $File = file_get_contents("http://austin2015.apistrat.com/schedule/daytwo.json");
  //echo $File;
  $JSONSchedule = json_encode($File);

  //$ReturnObject['updated'] = 1;
  $ReturnObject = $JSONSchedule;

  $app->response()->header("Content-Type", "application/json");
  echo format_json(stripslashes(json_encode($ReturnObject)));

  });

?>
