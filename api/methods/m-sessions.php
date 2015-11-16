<?php

$route = '/sessions/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  if(isset($params['query'])){ $query = trim(mysql_real_escape_string($params['query'])); } else { $query = ''; }

  $ScheduleQuery = "SELECT * FROM schedule WHERE title LIKE '%" . $query . "%' OR location LIKE '%" . $query . "%'";
  //echo $ScheduleQuery . "<br />";
  $ScheduleResults = mysql_query($ScheduleQuery) or die('Query failed: ' . mysql_error());
  while ($Schedule = mysql_fetch_assoc($ScheduleResults))
  	{

  	$schedule_id = $Schedule['schedule_id'];
  	$schedule_title = $Schedule['title'];
    $schedule_location = $Schedule['location'];
    $schedule_start_time = $Schedule['start_time'];
    $schedule_end_time = $Schedule['end_time'];

    $F = array();
		$F['schedule_id'] = $schedule_id;
    $F['title'] = $schedule_title;
    $F['location'] = $schedule_location;
    $F['start_time'] = $schedule_start_time;
    $F['end_time'] = $schedule_end_time;

    $F['speakers'] = array();
    $SpeakerQuery = "SELECT * FROM speakers s INNER JOIN schedule_speakers ss ON s.speaker_id = ss.speaker_id WHERE ss.schedule_id = " . $schedule_id;
    //echo $SpeakerQuery . "<br />";
    $SpeakerResults = mysql_query($SpeakerQuery) or die('Query failed: ' . mysql_error());
    while ($Speaker = mysql_fetch_assoc($SpeakerResults))
    	{
    	$speaker_id = $Speaker['speaker_id'];
      $speaker_name = $Speaker['name'];
      $speaker_company = $Speaker['company'];
      $speaker_url = $Speaker['url'];
      $speaker_twitter = $Speaker['twitter'];
      $speaker_image = $Speaker['image'];
      $speaker_slug = $Speaker['slug'];
      $speaker_detail = $Speaker['detail'];
      $speaker_title = $Speaker['title'];
      $speaker_abstract = $Speaker['abstract'];
      $speaker_bio = $Speaker['bio'];

      $S = array();
  		$S['speaker_id'] = $speaker_id;
      $S['name'] = $speaker_name;
      $S['company'] = $speaker_company;
      $S['url'] = $speaker_url;
      $S['twitter'] = $speaker_twitter;
      $S['image'] = $speaker_image;
      $S['title'] = $speaker_title;
      $S['abstract'] = $speaker_abstract;
      $S['bio'] = $speaker_bio;

      array_push($F['speakers'], $S);
      }
    array_push($ReturnObject, $F);
  	}

  $app->response()->header("Content-Type", "application/json");

  echo stripslashes(json_encode($ReturnObject));

  });

?>
