<?php
    $conn = mysqli_connect('localhost', 'root', '', 'logistics');

    if(!$conn) {
        die("Failed to connect" . mysqli_error($conn));
    }
    
    date_default_timezone_set('Asia/Bangkok');
?>