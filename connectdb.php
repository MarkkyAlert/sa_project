<?php
    
    $conn = mysqli_connect('localhost', 'root', '', 'logistics');

    if(!$conn) {
        die("Failed to connect" . mysqli_connect_error());
    }
    
    date_default_timezone_set('Asia/Bangkok');
    $_SESSION['now'] = date("Y-m-d H:i:s");

    function query($query) {
        global $conn;
        return mysqli_query($conn, $query);
    }
    
    function escape($string) {
        global $conn;
        return mysqli_real_escape_string($conn, $string);
    }

    function fetch_assoc($result) {
        global $conn;
        return mysqli_fetch_assoc($result);
    }

    function num_rows($result) {
        global $conn;
        return mysqli_num_rows($result);
    }

    function redirect($location) {
        return header('location: {$location}');
    }

?>