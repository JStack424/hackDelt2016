<?php
require_once('TwitterAPIExchange.php');
require_once('../config.php');

$potentialIssues = array('Abortion','Marriage','PlannedParenthood','Guns','Privacy','Drugs','SocialSecurity','Obamacare','Wage','Taxes','Immigration','Education','WealthInequality','Terrorism','Isis','GlobalWarming');

$selected = array();

foreach ($potentialIssues as $i) {
    if (isset($_POST[$i])) {
        array_push($selected, $i);
    }
}

for ($n=0;$n<count($selected);$n++) {
    if ($n < count($selected)) {
        $text_input += $selected[$n] . "+OR+";
    }
    else {
        $text_input += $selected[$n];
    }
}

    $sqlSM = "SELECT `Id`, `Name`, `Category`, `Handle` FROM `TwitterHandles` WHERE Name='" . $_POST['name'] . "'";
    if ($resultSM = mysqli_query($conn, $sqlSM)) {
        $rowSM = mysqli_fetch_assoc($resultSM);
    }

    $candinateAcc = $rowSM['Handle'];

  //Set access tokens here - see: https://dev.twitter.com/apps/
 $settings = array(
    'oauth_access_token' => "500372775-UeM45KxcoUckhnW1poQcfTLA15LyPnakPQdylkNa",
    'oauth_access_token_secret' => "HPTRvuLlJ174lp826k6dsVDoQk2gq1IAU7MYKLuK6OoPr",
    'consumer_key' => "0eElcSaFoCywSf17JSsZwJZ50",
    'consumer_secret' => "3kwVodnb9FcIS01fpT3HS1b1PqXu7Hk8t0fJuP8MEAxYzQrWn7"
    );

 $url = "https://api.twitter.com/1.1/search/tweets.json";
 $requestMethod = "GET";

 //$candinateAcc = "realDonaldTrump"; candidate account to query
 $input = rawurlencode($textInput); //text entry to query
 $newsAcc = array("cnn","ABC","FOXNews", "washingtonpost","AP_Politics","HuffingtonPost","nytimes","BBC","NBCNews","MSNBC" ); //news outlet acccunts-hardcoded

 $getfieldTimeLine ='?q=' .$input . '%20-filter:media+from:' . $candinateAcc . '&result_type=mixed&count=7';
 $getPressField ='?q=' .$input . '%20-filter:media+from:'.$newsAcc[0].'+OR+from:'. $newsAcc[1].'+OR+from:'. $newsAcc[2] .'+OR+from:'. $newsAcc[3] . '+OR+from:'. $newsAcc[4] .'+OR+from:'. $newsAcc[5] .'+OR+from:'. $newsAcc[6] .'+OR+from:'. $newsAcc[7] .'+OR+from:'. $newsAcc[8] .'+OR+from:'. $newsAcc[9] .'&result_type=mixed&count=7';
 $getPopularField = '?q=from%20' . $input . '%20-filter:media+&result_type=mixed&count=7';


 function queryTweets($getfield, $settings, $url, $requestMethod, $array){
    $twitter = new TwitterAPIExchange($settings);
    $string = json_decode($twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest(),$assoc = TRUE);
    if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

    $array = array();
    $tweets = $string['statuses'];
        foreach ($tweets as $tweet => $data) {
            array_push($array,"<blockquote class='twitter-tweet'><a href='https://twitter.com/Interior/status/" . $data['id'] . "'/&maxwidth=40>link</a></blockquote>");
    }
     return $array;
}

$result1 = queryTweets($getfieldTimeLine, $settings, $url, $requestMethod);
$result2 = queryTweets($getPressField, $settings, $url, $requestMethod);
$result3 = queryTweets($getPopularField, $settings, $url, $requestMethod);
$arrayOfArrays = array($result1,$result2,$result3);
$output = json_encode($arrayOfArrays);
echo $output;
?>
