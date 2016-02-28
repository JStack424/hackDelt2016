<!DOCTYPE html>

<!--
Name: Joe Stack
File:
HackTCNJ
-->

<html>

<head>
<title>Candidate Standings</title>
</head>

<body>

<?php
    include 'dataFunctions.php';
    include 'ElectionInfo.php';
    
    //get state abbreviation based on which Election[x] chronologically
    $lastCaucus = prevCaucus();
    $currentIndex = $lastCaucus['index'] + 1;
    $searchState = $Election[$currentIndex]['state'];
    echo $currentIndex . ": " . $searchState . "<br>";
    //Connect to database
    $url = "http://api.gannett-cdn.com/v1/2016-primary/results/p/" . $searchState . "summary";
    $content = file_get_contents($url);
    
    //Decode data into array
    $Data = json_decode($content, true);
    echo "<pre>";
    print_r($Data);
    echo "</pre>";
    
/*
 For national summary:
    make empty array of candidates
    set key = last name, value = [first, last, party, delegates = array, votes = array, totalDelegates, totalVotes]
 For election i=1-current (loop):
    candidates['last']['delegates'][i] = delegates
    candidates['last']['votes'][i] = votes
 - current
*/
    
?>

<h2>Republican Candidates</h2>
<?php
    $repubCands = $Data['races'][0]['reportingUnits'][0]['candidates'];
    foreach ($repubCands as $key => $value) {
        echo $key . ": " . $value . ":<br>";
        foreach ($value as $key1 => $value1) {
            echo $key1 . ": " . $value1 . "<br>";
        }
        echo "<br>";
    }
    ?>


<h2>Democratic Candidates</h2>
<?php
    $demoCands = $Data['races'][1]['reportingUnits'][0]['candidates'];
    foreach ($demoCands as $key => $value) {
        foreach ($value as $key1 => $value1) {
            echo $key1 . ": " . $value1 . "<br>";
        }
        echo "<br>";
    }
    
    ?>

</body>


</html>