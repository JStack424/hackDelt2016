 <?php
    require_once('TwitterAPIExchange.php');
     
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => "500372775-UeM45KxcoUckhnW1poQcfTLA15LyPnakPQdylkNa",
        'oauth_access_token_secret' => "HPTRvuLlJ174lp826k6dsVDoQk2gq1IAU7MYKLuK6OoPr",
        'consumer_key' => "0eElcSaFoCywSf17JSsZwJZ50",
        'consumer_secret' => "3kwVodnb9FcIS01fpT3HS1b1PqXu7Hk8t0fJuP8MEAxYzQrWn7"
    );
     
    $url = "https://api.twitter.com/1.1/search/tweets.json";
     
    $requestMethod = "GET";
    
    $candinateAcc = "realDonaldTrump"; 
    $input = rawurlencode("mexicans+OR+Trump");
   // echo $input;
    $newsAcc = array("cnn","ABC","FOXNews" );

    $getfieldTimeLine ='?q=' .$input . '%20from:' . $candinateAcc . '&result_type=mixed';
    $getPressField ='?q=' .$input . '%20from:'.$newsAcc[0].'+OR+from:'. $newsAcc[1].'+OR+from:'. $newsAcc[2] .'&result_type=mixed';
    $getPopularField = '?q=from%20' . $input . '%20&result_type=mixed';
     

function queryTweets($getfield, $settings, $url, $requestMethod){
   // echo "Hello world";
    $twitter = new TwitterAPIExchange($settings);
    $string = json_decode($twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest(),$assoc = TRUE);
    if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

    $tweets = $string['statuses'];
    foreach ($tweets as $tweet => $data) {
       // echo $data['user']['name'] . ": " . $data['text'] . "<br><br>";
        echo "<blockquote class='twitter-tweet'><a href='https://twitter.com/Interior/status/" . $data['id'] . "'/&maxwidth=50>link</a></blockquote>" . "<br><br>";

    }
    echo "<br><br>";
    echo "<pre>";
   // print_r($string);
    echo "</pre>";
}
?>

<html>
<head>
<style>
html, body {
    margin:0;
    padding:0;
    width:100%;
    height:100%;
}

.container {
    width:100%;
}

.column {
    width:33.33333333%;
    float:left;
}

.column img {
    width:100%;
    height:auto;
}
</style>
</head>

<link rel"styles.css" type"text/css" href="mystyle.css">
<body>

<div class="container">
    <div class="column">
        <?php 
        queryTweets($getfieldTimeLine, $settings, $url, $requestMethod);
        ?>    
</div>

    <div class="column">
        <?php 
        queryTweets($getPressField, $settings, $url, $requestMethod);
        ?>  
    </div>
    
    <div class="column">
        <?php 
        queryTweets($getPopularField, $settings, $url, $requestMethod);
        ?>  
    </div>
</div>



<center> 
 
<p align = "center">

</body>
 <script type="text/javascript"  src="http://platform.twitter.com/widgets.js"></script>
</html>

<!--
    $twitter = new TwitterAPIExchange($settings);
$tweetData = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
    $decoded = json_decode($tweetData, true);

    $allTweets = $decoded['statuses'];
    print_r($decoded['statuses'][0]['text']);
    echo "<br><br>";
    print_r($decoded);


$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
foreach($string as $items)
    {
        echo "Time and Date of Tweet: ". $items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
->