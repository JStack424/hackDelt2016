<?php
    $html = file_get_contents('http://www.uspresidentialelectionnews.com/2016-presidential-primary-schedule-calendar');
    echo "Test<br>";
    $pokemon_doc = new DOMDocument();
    $pokemon_doc->loadHTML($html);
    $pokemon_xpath = new DOMXPath($pokemon_doc);
    $pokemon_row = $pokemon_xpath->query('//td');

    if($pokemon_row->length > 0){
        foreach($pokemon_row as $row){
            print_r($row);
            echo "<br>" . $row->nodeValue . "<br/>";
        }
    } else {
        echo "Nope";
    }
?>