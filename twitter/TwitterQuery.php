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

    $getfield = '?q=%23trump&result_type=recent';

    $twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
?>
