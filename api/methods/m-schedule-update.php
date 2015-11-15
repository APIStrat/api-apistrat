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
    var_dump($timeArray);
    $start_time = $timeArray[0];
    $start_day_time = $Day . " " . $start_time;
    $start_day_time = date('Y-m-d H:i:s A',strtotime($start_day_time));
    echo $start_day_time . "<br />";

    if(isset($timeArray[1]))
      {
        $end_time = "12:00 am";
        $end_day_time = $Day . " " . $end_time;
        $end_day_time = date('Y-m-d H:i:s A',strtotime($end_day_time));
        echo $end_day_time . "<br />";
      }

    $title = $Entry->title;
    $location = $Entry->location;
    $speakers = $Entry->speakers;

    $LinkQuery = "SELECT * FROM schedule WHERE location = '" . $location . "' AND start_time = '" . $start_day_time . "' AND end_time = '" . $end_day_time . "'";
		//echo $LinkQuery . "<br />";
		$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

		if($LinkResult && mysql_num_rows($LinkResult))
			{
			$Link = mysql_fetch_assoc($LinkResult);
      $schedule_id = $Link['schedule_id'];
			}
		else
			{
			$query = "INSERT INTO schedule(title,location,start_time,end_time) VALUES('" . mysql_real_escape_string($title) . "','" . mysql_real_escape_string($location) . "','" . mysql_real_escape_string($start_day_time) . "','" . mysql_real_escape_string($end_day_time) . "')";
			//echo $query . "<br />";
			mysql_query($query) or die('Query failed: ' . mysql_error());
      $schedule_id = mysql_insert_id();
			}

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

      $LinkQuery = "SELECT * FROM speakers WHERE name = '" . mysql_real_escape_string($speaker_name) . "'";
  		echo $LinkQuery . "<br />";
  		$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

  		if($LinkResult && mysql_num_rows($LinkResult))
  			{
  			$Link = mysql_fetch_assoc($LinkResult);
        $speaker_id = $Link['speaker_id'];
  			}
  		else
  			{
  			$query = "INSERT INTO speakers(name,company,url,twitter,image,slug,detail,title,abstract,bio) VALUES('" . mysql_real_escape_string($speaker_name) . "','" . mysql_real_escape_string($speaker_company) . "','" . mysql_real_escape_string($speaker_url) . "','" . mysql_real_escape_string($speaker_twitter) . "','" . mysql_real_escape_string($speaker_image) . "','" . mysql_real_escape_string($speaker_slug) . "','" . mysql_real_escape_string($speaker_detail) . "','" . mysql_real_escape_string($speaker_title) . "','" . mysql_real_escape_string($speaker_abstract) . "','" . mysql_real_escape_string($speaker_bio) . "')";
  			echo $query . "<br />";
  			mysql_query($query) or die('Query failed: ' . mysql_error());
        $speaker_id = mysql_insert_id();
  			}

        $LinkQuery = "SELECT * FROM schedule_speakers WHERE schedule_id = " . $schedule_id . " AND speaker_id = " . $speaker_id;
    		//echo $LinkQuery . "<br />";
    		$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());

    		if($LinkResult && mysql_num_rows($LinkResult))
    			{
    			$Link = mysql_fetch_assoc($LinkResult);
    			}
    		else
    			{
    			$query = "INSERT INTO schedule_speakers(schedule_id,speaker_id) VALUES(" . mysql_real_escape_string($schedule_id) . "," . mysql_real_escape_string($speaker_id) . ")";
    			//echo $query . "<br />";
    			mysql_query($query) or die('Query failed: ' . mysql_error());
    			}

      echo $speaker_title . "<br />";
      }
    }
  $ReturnObject = $JSONSchedule;

  //$app->response()->header("Content-Type", "application/json");

  echo stripslashes(json_encode($ReturnObject));

  });

?>
