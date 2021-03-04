<?php
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

if(isset($data)){
    $file = 'simplybook.txt';
    // Open the file
    $content = file_get_contents($file);
    // Add callback data
    $content .= "BOOKING-ID:".$data."\n";
    // Write
    file_put_contents($file, $content);
}
?>
