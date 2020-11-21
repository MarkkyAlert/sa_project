<?php
    session_start();
    include('connectdb.php');
    if (isset($_POST['submit'])) {
        $order_no = mysqli_real_escape_string($conn, $_POST['order_no']);
        
        $query = "SELECT order_no FROM orders WHERE order_no = '$order_no' AND (delivery_status = 'waiting' OR delivery_status = 'delivering' OR delivery_status = 'success' OR delivery_status = 'failed')";
        $result = query($query);
        $row = mysqli_num_rows($result);
        
        if ($row > 0) {
            $_SESSION['order_no2'] = $order_no;
            header('location: order_no_display.php');
        }
        else {
            $_SESSION['err_order_no'] = 'ไม่พบข้อมูล';
            header('location: order_no.php');
        }
        
    }
?>