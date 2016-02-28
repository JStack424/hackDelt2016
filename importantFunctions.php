<?php
    
    function mostRecentCaucus() {
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
        
        //Iterates through the array to ignore any elections which have already passed
        $timeDiff = -1;
        $i = -1;
        while ($timeDiff < 0) {
            $i++;
            $timeDiff = strtotime(substr($elections[0]->item($i)->nodeValue, 5)) - $today[0];
        }
        //Subtract 1 to get the location of the most recent
        $i--;
        
        $state = explode(" ", $elections[1]->item($i)->nodeValue);
        $abbrv = strtolower($state[0][0] . $state[1][0]);
        $mostRecent = array("number" => $i, "date" => $elections[0]->item($i)->nodeValue, "state" => $abbrv);
        print_r($mostRecent);
        return $mostRecent;
    }
    
    function allCaucus() {
        $html = file_get_contents('http://www.uspresidentialelectionnews.com/2016-presidential-primary-schedule-calendar');
        $timeline_doc = new DOMDocument();
        $timeline_doc->loadHTML($html);
        $timeline_xpath = new DOMXPath($timeline_doc);
        
        //Query the page to retrieve dates and locations of elections
        $dates = $timeline_xpath->query('//td[@class="col-1 odd"]');
        $states = $timeline_xpath->query('//td[@class="col-2 even"]');
        
        $elections = array($dates, $states); //Place dates and states in an array
        
        echo "array (<br>";
        for ($i = 0; $i < $elections[0]->length; $i++) {
            //Checks if current index has valid information
            echo "array(\"date\" => \"" . $elections[0]->item($i)->nodeValue . "\", \"state\" => \"" . $elections[1]->item($i)->nodeValue . "\")<br>";
        }
    }
    
    allCaucus();
    
?>