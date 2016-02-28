<?php
    //Important functions for retrieving and manipulating data
    
    /**************************************************
     getTimeline is used to read the caucus schedule posted on 'www.uspresidentialelectionnews.com'.
     Input: N/A
     Output: Returns ["date" => date, "state" => state]
     */
    function getTimeline() {
        //get html page for timeline and load it into a DOMDocument
        $html = file_get_contents('http://www.uspresidentialelectionnews.com/2016-presidential-primary-schedule-calendar');
        $timeline_doc = new DOMDocument();
        $timeline_doc->loadHTML($html);
        $timeline_xpath = new DOMXPath($timeline_doc);
        
        //Query the page to retrieve dates and locations of elections
        $dates = $timeline_xpath->query('//td[@class="col-1 odd"]');
        $states = $timeline_xpath->query('//td[@class="col-2 even"]');
        
        //Place dates and states in an array to be output
        //Create empty output array
        $output = array();
        //Populate output array
        for ($i = 0; $i < $dates->length; $i++) {
            $output[$i] = array("date" => $dates->item($i)->nodeValue, "state" => $states->item($i)->nodeValue);
        }
        return $output;
    }
    
    
    
    /**************************************************
     allCaucuses is used to print an entire schedule of caucus dates
     Input: N/A
     Output: A printed list of all caucuses
     ex: "Tue, Mar 1: Alabama"
     */
    function allCaucuses() {
        //Gets election schedule
        $allElections = getTimeline(); //["date" => date, "state" => state]
        for ($index = 0; $index < count($allElections); $index++) {
            echo $i;
            $caucusNumber = $index + 1;
            echo $caucusNumber . ": " . $allElections[$index]['date'] . " in " . $allElections[$index]['state'] . "<br>";
        }
    }
    
    
    
    /**************************************************
     prevCaucus is used to get information about the most recent caucus
     Input: N/A
     Output: Returns [("index" => caucusNumber), ("date" => date), ("state" => state)]
     */
    function prevCaucus() {
        include 'ElectionInfo.php';
        //Gets today's date
        $currentDate = getdate();
        
        //Iterates through the array to ignore any elections which have already passed
        $caucusNum = -1;
        do {
            $caucusNum++;
            $timeDiff = strtotime(substr($Election[$caucusNum]['date'], 5)) - $currentDate[0];
        } while ($timeDiff < 0);
        //caucusNum is the index for the next caucus
        
        //stores the index of the most recent caucus
        $prevCaucusNum = $caucusNum - 1;
        
        //Creates an array of [caucus index, date, state]
        $output = array("index" => $prevCaucusNum, "date" => $Election[$prevCaucusNum]['date'], "state" => $Election[$prevCaucusNum]['state']);
        return $output;
    }
    
    
    
    /**************************************************
     printUpcomingCaucus retreives a specified number of upcoming caucuses
     Input: ($numToShow: int) number of caucuses to display
     Output: Prints to the page the list of caucuses in the form "Tue, Mar 1: Alabama"
     */
    function printUpcomingCaucus($numToShow) {
        include 'ElectionInfo.php';
        
        //Gets the most recent caucus as [("index" => caucusNumber), ("date" => date), ("state" => state)]
        $last = prevCaucus();
        
        $endIndex= $last['index'] + 1 + $numToShow;
        if ($endIndex >= count($Election)) {
            $tooLong = true;
            $endIndex = count($Election);
        } else {
            $tooLong = false;
        }
        
        //Gets election schedule
        $allElections = getTimeline();
        
        //Print html ul tag
        echo "<ul class='upcomingEventsList'>";
        //Iterates through future elections and prints: "Date: Location"
        for ($index = $last['index'] + 1; $index < $endIndex; $index++) {
            echo '<li>' . $Election[$index]['date'] . ": " . $allElections[$index]['state'] . "</li><br>";
        }
        if ($tooLong) {
            echo "<li> No more caucuses.</li>";
        }
        echo '</ul>';
    }
    
    ?>


