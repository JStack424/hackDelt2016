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


 $candinateAcc = "realDonaldTrump"; //candinate account to query
 $input = rawurlencode("trump"); //text entry to query
 $newsAcc = array("cnn","ABC","FOXNews", "washongtonpost","AP_Politics","HuffingtonPost","nytimes","BBC","NBCNews","MSNBC" ); //news outlet acccunts-hardcoded

 $getfieldTimeLine ='?q=' .$input . '%20from:' . $candinateAcc . '&result_type=mixed';
 $getPressField ='?q=' .$input . '%20from:'.$newsAcc[0].'+OR+from:'. $newsAcc[1].'+OR+from:'. $newsAcc[2] .'+OR+from:'. $newsAcc[3] . '+OR+from:'. $newsAcc[4] .'+OR+from:'. $newsAcc[5] .'+OR+from:'. $newsAcc[6] .'+OR+from:'. $newsAcc[7] .'+OR+from:'. $newsAcc[8] .'+OR+from:'. $newsAcc[9] .'&result_type=mixed';
 $getPopularField = '?q=from%20' . $input . '%20&result_type=mixed';


 function queryTweets($getfield, $settings, $url, $requestMethod){
    $twitter = new TwitterAPIExchange($settings);
    $string = json_decode($twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest(),$assoc = TRUE);
    if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

    $tweets = $string['statuses'];
    foreach ($tweets as $tweet => $data) {
        echo "<blockquote class='twitter-tweet'><a href='https://twitter.com/Interior/status/" . $data['id'] . "'/&maxwidth=50>link</a></blockquote>" . "<br><br>";

    }
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>


    <div class="column-left">  <!--first column -->
        <h2><font font-family="Courier New">Official account</font></h2>
        <?php 
        queryTweets($getfieldTimeLine, $settings, $url, $requestMethod);
        ?>    
    </div>

    <div class="column-right"> <!--second column -->
        <h2>Press Coverage</h2>

        <?php 
        queryTweets($getPopularField, $settings, $url, $requestMethod);
        ?>  
    </div>

    <div class="column-center"> <!--third column -->
        <h2>Trending</h2>  
        <?php 
        queryTweets($getPressField, $settings, $url, $requestMethod);
        ?>  
    </div>


</body>
<script type="text/javascript"  src="http://platform.twitter.com/widgets.js"></script>
</html>