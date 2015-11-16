<?php

$route = '/speakers/';
$app->get($route, function ()  use ($app){

  $ReturnObject = array();

 	$request = $app->request();
 	$params = $request->params();

  if(isset($params['query'])){ $query = trim(mysql_real_escape_string($params['query'])); } else { $query = ''; }

    $F['speakers'] = array();
    $SpeakerQuery = "SELECT * FROM speakers s WHERE name LIKE '%" . $query . "%' OR company LIKE '%" . $query . "%'";
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
      $S['name'] = $speaker_name;
      $S['company'] = $speaker_company;
      $S['url'] = $speaker_url;
      $S['twitter'] = $speaker_twitter;
      $S['image'] = $speaker_image;
      $S['title'] = $speaker_title;
      $S['abstract'] = $speaker_abstract;
      $S['bio'] = $speaker_bio;
      $S['sessions'] = array();

      $ScheduleQuery = "SELECT * FROM schedule s INNER JOIN schedule_speakers ss ON s.schedule_id = ss.schedule_id WHERE ss.speaker_id = " . $speaker_id;
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
        $F['title'] = $schedule_title;
        $F['location'] = $schedule_location;
        $F['start_time'] = $schedule_start_time;
        $F['end_time'] = $schedule_end_time;

        array_push($S['sessions'], $F);
        }

      array_push($ReturnObject, $S);
      }

  $app->response()->header("Content-Type", "application/json");

  echo stripslashes(json_encode($ReturnObject));

  });

?>
