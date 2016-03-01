<?php
    include 'ElectionInfo.php';
    //Gets today's date
    $currentDate = getdate();
    
    //Iterates through the array to ignore any elections which have already passed
    $caucusNum = -1;
    do {
        $caucusNum++;
        $timeDiff = strtotime(substr($Election[$caucusNum]['date'], 5)) - $currentDate[0];
        echo "Time since " . $Election[$caucusNum]['date'] . ": " . $timeDiff . "<br>";
    } while ($timeDiff < -21*60*60); //Counts a caucus as completed at 9:00pm
    
    ?>