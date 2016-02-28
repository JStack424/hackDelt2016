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
    
    //get state abbreviation based on which Election[x] chronologically
    $searchState = $Election[0]['state'];
    echo "$searchState<br>";
    echo "<br>" . $state . "<br><br>";
    //Connect to database
    $url = "http://api.gannett-cdn.com/v1/2016-primary/results/p/" . $searchState . "summary";
    $content = file_get_contents($url) . "";
    
    //Decode data into array
    $Data = json_decode($content, true);
    
    
    printUpcomingCaucus(10);
    
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