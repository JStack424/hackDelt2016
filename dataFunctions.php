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
    
    
    /**************************************************
     retrieveNationalData retreives and stores national total data for all candidates and returns an array
     Input: N/A
     Output: array indexed by candidate's last name. ["last" => array(info)]
     */
    function retrieveNationalData() {
        //Connect to national results database
        $url = "http://api.gannett-cdn.com/v1/2016-primary/results/p/summary";
        $content = file_get_contents($url);
        //Decode data into array
        $Data = json_decode($content, true);
        
        //make empty candidates array
        $candidates = array();
        //for each party
        foreach($Data['races'] as $race => $raceData) {
            $party = $raceData['party'];
            //for each candidate
            foreach ($raceData['reportingUnits'][0]['candidates'] as $candidate => $info) {
                if ($info['last'] != "Others") {
                    $candidates[$info['last']] = array (
                                                    "first" => $info['first'],
                                                    "last" => $info['last'],
                                                    "party" => $info['party'],
                                                    "totalVotes" => $info['voteCount'],
                                                    "totalDelegates" => $info['delegateCount'],
                                                    "totalVotePercent" => 0,
                                                    "totalDelegatePercent" => 0,
                                                    "votes" => array(),
                                                    "delegates" => array(),
                                                    "votePercent" => array()
                                                    );
                }
            }
            
        }
        return $candidates;
    }
    
    
    
    /**************************************************
     retrieveElectionData retreives and stores national total data for all candidates and returns an array
     Input: N/A
     Output: array indexed by candidate's last name. ["last" => array(info)]
     */
    function retrieveElectionData() {
        include 'ElectionInfo.php';
        //first collect all national data
        $candidates = retrieveNationalData();
        
        //get index of current caucus
        $lastCaucus = prevCaucus();
        $currentIndex = $lastCaucus['index'] + 1;
        
        //keep track of total overall votes and delegates
        $overallVotes = array("R" => 0, "D" => 0);
        $overallDelegates = array("R" => 0, "D" => 0);
        
        //loop through each past caucus
        for ($i = 0; $i < $currentIndex; $i++) {
            //get state abbreviation
            $state = $Election[$i]['state'];
            
            //Connect to state results database
            $url = "http://api.gannett-cdn.com/v1/2016-primary/results/p/" . $state . "summary";
            $content = file_get_contents($url);
            //Decode data into array
            $Data = json_decode($content, true);
            
            //for each party
            foreach($Data['races'] as $race => $raceData) {
                $party = $raceData['party'];
                //for each candidate
                foreach($raceData['reportingUnits'][0]['candidates'] as $candidate => $info) {
                    //get last name
                    $lastName = $info['last'];
                    //check if candidate is still running
                    if (isset($candidates[$lastName])) {
                        //set all state-specific information
                        $candidates[$lastName]['votes'][$i] = $info['voteCount'];
                        $candidates[$lastName]['delegates'][$i] = $info['delegateCount'];
                        $candidates[$lastName]['votePercent'][$i] = $info['votePct'];
                        
                        //increment overall counters
                        $overallVotes[$party] = $overallVotes[$party] + $info['voteCount'];
                        $overallDelegates[$party] = $overallDelegates[$party] + $info['delegateCount'];
                    }
                }
            }
        }
        
        
        //loop through each candidate
        foreach ($candidates as $current => $info) {
            //sum votes and delegates from each state
            $candidates[$info['last']]['totalVotes'] = array_sum($info['votes']);
            $candidates[$info['last']]['totalDelegates'] = array_sum($info['delegates']);
            
            //calculate overall averages
            $party = $info['party'];
            $candidates[$info['last']]['totalVotePercent'] = 100*$candidates[$info['last']]['totalVotes']/$overallVotes[$party];
            $candidates[$info['last']]['totalDelegatePercent'] = 100*$candidates[$info['last']]['totalDelegates']/$overallDelegates[$party];
        }
        
        return $candidates;
    }
    
    
    /**************************************************
     formatTickerData compares the last caucus with the overall
     Input: N/A
     Output: echo '<span class="up"><span class="quote">ABC</span> 1.543 0.2%</span>'
     */
    function formatTickerData($candidates) { //<span class="up"><span class="quote">ABC</span> 1.543 0.2%</span>
        //get index of last caucus
        $lastIndex = prevCaucus()['index'];
        foreach($candidates as $candidate => $info) {
            $change = $info['votePercent'][$lastIndex] - $info['totalVotePercent'];
            $change = substr($change, 0, 5);
            $direction = "up";
            $lastName = $candidate;
            $pct = 100*$change/$info['totalVotePercent'];
            $pct = substr($pct, 0, 5);
            echo "<span class=\"" . $direction . "\"><span class=\"quote\">" . $lastName . "</span> " . $change . " " . $pct . "%</span>";
        }
        
    }
    ?>


