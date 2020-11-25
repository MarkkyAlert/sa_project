<?php
    session_start();
    include('../connectdb.php');

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);

        $query = "SELECT firstname, lastname FROM users WHERE (SELECT CONCAT(firstname, ' ', lastname)) LIKE '%{$name}%'  AND type = 'E'";
        $result = query($query);
        $row = mysqli_num_rows($result);
        $row2 = fetch_assoc($result);
        
        if ($row > 0) {
            $_SESSION['name'] = $name; 
            $_SESSION['row_count'] = $row;
            header('location: history_detail.php');
        }
        else {
            $_SESSION['err_history'] = 'ไม่พบข้อมูลการจัดส่ง';
            header('location: history_deliver.php');
        }
    }
?>