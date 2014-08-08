<?php

$json = file_get_contents("http://api.wmata.com/StationPrediction.svc/json/GetPrediction/K04?api_key=kfgpmgvfgacx98de9q3xazww");

$decoded = json_decode($json, true);

$message = "Sorry, no trains were found.";
foreach ($decoded["Trains"] as $train)
{
    if($train["Line"]=="OR"){
    	$car = $train["DestinationCode"];
    	$destCode = $train["DestinationCode"];
    	$dest = $train["Destination"];
    	$min = $train["Min"];
    	if($min=="ARR"){
    		$message = "The Orange Line train is ARRIVING NOW at Ballston, headed for ".$dest.". Hustle up!!";
    	}else if($min=="BRD"){
    		$message = "The Orange Line train is BOARDING NOW at Ballston, headed for ".$dest.". Run!!";
    	}else{
    		$message = "The next Orange Line train will arrive at Ballston in ".$min." MINUTES. It's headed for ".$dest.".";
    	}

    	break;
    }
};

echo $message."\n";

?>