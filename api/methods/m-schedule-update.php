<?php

$route = '/schedule/update/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $Day = "11/19/2015";
  $File = file_get_contents("http://austin2015.apistrat.com/schedule/daytwo.json");
  //echo $File;
  $JSONSchedule = json_decode($File);
  foreach($JSONSchedule as $Entry)
    {
    $time = $Entry->time;
    $timeArray = explode("-",$time);
    //var_dump($timeArray);
    $start_time = $timeArray[0];
    $start_day_time = $Day . " " . $start_time;
    $start_day_time = date('Y-m-d H:i:s',strtotime($start_day_time));
    echo $start_day_time . "<br />";

    $end_time = $timeArray[1];
    $end_day_time = $Day . " " . $end_time;
    $end_day_time = date('Y-m-d H:i:s',strtotime($end_day_time));
    echo $end_day_time . "<br />";

    $title = $Entry->title;
    $location = $Entry->location;
    $speakers = $Entry->speakers;

    echo $title . "<br />";
    foreach($speakers as $speaker)
      {
      $speaker_name = $speaker->name;
      $speaker_company = $speaker->company;
      $speaker_url = $speaker->url;
      $speaker_twitter = $speaker->twitter;
      $speaker_image = $speaker->image;
      $speaker_slug = $speaker->slug;
      $speaker_detail = $speaker->detail;
      $speaker_title = $speaker->title;
      $speaker_abstract = $speaker->abstract;
      $speaker_bio = $speaker->bio;

      echo $speaker_title . "<br />";
      }
    }
  $ReturnObject = $JSONSchedule;

  //$app->response()->header("Content-Type", "application/json");

  echo stripslashes(json_encode($ReturnObject));

  });

?>
