<?php
    session_start();
    include('../connectdb.php');

    if (isset($_POST['submit'])) {
        $order_no = mysqli_real_escape_string($conn, $_POST['order_no']);

        $query = "SELECT * FROM orders WHERE order_no = '$order_no'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
       

        if ($row['order_no'] === $order_no) {
            $_SESSION['order_no'] = $row['order_no'];
            $_SESSION['amount'] = $row['amount'];
            $_SESSION['delivery_date'] = $row['delivery_date'];
            $_SESSION['order_id'] = $row['order_id'];
            header('location: check_car.php');
        }
        else {
            $_SESSION['err_order_no'] = 'ไม่พบเลขที่สินค้า';
            header('location: order_no.php');
        }
    }
?>