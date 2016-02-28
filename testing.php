<?php
    include 'dataFunctions.php';
    $candidates = retrieveElectionData();
    formatTickerData($candidates);

    echo "<pre>";
    print_r($candidates);
    echo "</pre>";
?>