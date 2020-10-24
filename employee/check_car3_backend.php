<?php
    session_start();
    include('../connectdb.php');

    if (isset($_REQUEST['order_id'])) {
        $order_id = $_REQUEST['order_id'];
        $accept = $_REQUEST['accept'];

        if ($accept == 'Y') {
            $query = "UPDATE orders SET accept_date = NOW(), order_status = 'accept', delivery_status = 'waiting' WHERE order_id = $order_id";
            
            

        }
        else if ($accept == 'N') {
            $query = "UPDATE orders SET order_status = 'not accept' WHERE order_id = $order_id";
            
        }
        $result = mysqli_query($conn, $query);
            
        if ($result) {
            header('location: index.php');
        }
        else {
            header('location: check_car.php');
        }
    }
?>