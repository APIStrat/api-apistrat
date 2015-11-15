<?php

$route = '/schedule/update/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  if(isset($params['query'])){ $query = trim(mysql_real_escape_string($params['query'])); } else { $query = ''; }

  $LinkQuery = "SELECT * FROM schedule WHERE title LIKE '%" . $query . "%' OR location LIKE '%" . $query . "%'";
  //echo $LinkQuery . "<br />";
  $LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());
  while ($Link = mysql_fetch_assoc($LinkResult))
  	{
  	$schedule_id = $Link['schedule_id'];
  	$schedule_title = $Link['title'];
    $schedule_location = $Link['location'];
    $schedule_start_time = $Link['start_time'];
    $schedule_end_time = $Link['end_time'];

  	}

  //$ReturnObject = $JSONSchedule;

  $ReturnObject['updated'] = 1;
  //$app->response()->header("Content-Type", "application/json");

  echo stripslashes(json_encode($ReturnObject));

  });

?>
