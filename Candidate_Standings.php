<!DOCTYPE html

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
            //Connect to database
            $url = "http://api.gannett-cdn.com/v1/2016-primary/results/p/summary?callback=usat_1summary_national&&cachetime=153253c4460";
            $content = file_get_contents($url) . "";
            //Get start and end positions of appropriate data
            $firstPos = strpos($content, "(") + 1;
            $lastPos = strlen($content) - $firstPos - 2;
            //Parse string to remove extranneous elements
            $substr = substr($content, $firstPos, $lastPos);
            
            //Decode data into array and print
            $Data = json_decode($substr, true);
            $output = $Data;
            print_r($output);
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