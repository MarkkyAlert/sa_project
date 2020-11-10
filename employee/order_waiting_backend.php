<?php 
    session_start();
    include('../connectdb.php');

    if (isset($_REQUEST['order_id'])) {
        $order_id = $_REQUEST['order_id'];

        $query = "UPDATE orders SET delivery_status = 'delivering' WHERE order_id = $order_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['suc_delivering'] = "ทำรายการเรียบร้อย";
            header('location: order_waiting.php');
        }
        else {
            $_SESSION['err_delivering'] = 'Cannot update to database';
            header('location: order_waiting.php');
        }
    }
?>