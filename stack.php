<!DOCTYPE html

<!--
Name: Joe Stack
HackTCNJ
-->

<html>
    
    <head>
        <title>My Title</title>
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
            print_r($Data['races'][0]);
            echo "<br><br>";
            
            
            
        ?>

    </body>
    
    
</html>