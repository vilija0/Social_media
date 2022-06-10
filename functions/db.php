<?php
$connection = mysqli_connect('localhost', 'root', '', 'social_network');

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function query($query)
{
    global $connection;
    return mysqli_query($connection, $query);
}

function confirm($result)
{
    global $connection;
    if (!$result) {
        die("QUERY FAILED " . mysqli_error($connection));
    }
}