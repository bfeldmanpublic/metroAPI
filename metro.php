<?php

// Root URL to get Train Arrival Times
$apiURL = "http://api.wmata.com/StationPrediction.svc/json/GetPrediction/";

//Station Code; currently set for Ballston. Change this code to lookup different arrival stations.
$stationCode = "K04";

// API Key for WMATA 
$apiKey = "kfgpmgvfgacx98de9q3xazww";

$getURL = $apiURL.$stationCode."?api_key=".$apiKey;

$json = file_get_contents($getURL);

$decoded = json_decode($json, true);

//Rail line code you are looking for; currently set for Orange line.
$lineCode = "OR";

//Set default output message.
$message = "Sorry, no trains were found.";

//Iterate json response
foreach ($decoded["Trains"] as $train)
{
    //Check if arriving train is Orange Line
    if($train["Line"]==$lineCode){
    	$destName = $train["DestinationName"];
    	$dest = $train["Destination"];
    	$min = $train["Min"];

    	if($min=="ARR"){ //Custom message if train is currently arriving
    		$message = "The Orange Line train is ARRIVING NOW at Ballston, headed for ".$destName.". Hustle up!!";
    	}else if($min=="BRD"){ //Custom message if train is currently boarding
    		$message = "The Orange Line train is BOARDING NOW at Ballston, headed for ".$destName.". Run!!";
    	}else{ 
    		$message = "The next Orange Line train will arrive at Ballston in ".$min." MINUTES. It's headed for ".$destName.".";
    	}

        //We only need the next arriving train, so break out of loop after 1 is found.
    	break;
    }
};

//Outputs message with line break for command line readability.
echo $message."\n";

?>