<?php
//load data from json file
$fileURL = "assets/files/people.json";
$jsonData = file_get_contents($fileURL);

echo $jsonData;