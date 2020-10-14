<?php
    
    $conn = mysqli_connect('localhost', 'root', '', 'logistics');

    if(!$conn) {
        die("Failed to connect" . mysqli_connect_error());
    }
    
    date_default_timezone_set('Asia/Bangkok');
    $_SESSION['now'] = date("Y-m-d H:i:s");
?>