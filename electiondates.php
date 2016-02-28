<?php
    //Input number of future elections to display on page
<<<<<<< HEAD
    $numToShow = 5;
=======
    $numToShow = 10;
>>>>>>> origin/master
    
    //get html page for timeline and load it into a DOMDocument
    $html = file_get_contents('http://www.uspresidentialelectionnews.com/2016-presidential-primary-schedule-calendar');
    $timeline_doc = new DOMDocument();
    $timeline_doc->loadHTML($html);
    $timeline_xpath = new DOMXPath($timeline_doc);
    
    //Query the page to retrieve dates and locations of elections
    $dates = $timeline_xpath->query('//td[@class="col-1 odd"]');
    $states = $timeline_xpath->query('//td[@class="col-2 even"]');
    
    $elections = array($dates, $states); //Place dates and states in an array
    
    $today = getdate(); //Gets today's date
    
    //Iterates through the array to skip over any elections which have already passed
    $timeDiff = -1;
    $i = -1;
    while ($timeDiff < 0) {
        $i++;
        $timeDiff = strtotime(substr($elections[0]->item($i)->nodeValue, 5)) - $today[0];
    }
    echo "<ul class='upcomingEventsList'>";
    //Iterates through remaining elections to print dates and locations of future caucuses
    for ($j = $i; $j < $i + $numToShow; $j++) {
        //Checks if current index has valid information
        if ($elections[0]->item($j)->nodeValue) {
            echo '<li>' . $elections[0]->item($j)->nodeValue . ": " . $elections[1]->item($j)->nodeValue . "</li><br>";
        }
    }
    echo '</ul>';
?>
