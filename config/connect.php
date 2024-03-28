<?php

$site_name = '10over10 Cars';
$tagline = 'Save Yourself Thousands';
$site = "http://localhost/10over10cars/";


function connectDb($db, $user = "root", $password = "")
{
    $connection =  mysqli_connect('localhost', $user, $password, $db) or die('Connection to host is failed, perhaps the service is down!');
    // Select the database
    mysqli_select_db($connection, $db) or die('Database name is not available!');

    return $connection;
}
