<?php

$route = '/schedule/update/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  $File = file_get_contents("http://austin2015.apistrat.com/schedule/daytwo.json");
  //echo $File;
  $JSONSchedule = json_decode($File);
  foreach($JSONSchedule as $Entry)
    {
    $time = $Entry->time;
    $timeArray = explode("-",$time);
    var_dump($timeArray);
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
