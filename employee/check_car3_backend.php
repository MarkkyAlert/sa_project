<?php
    session_start();
    include('../connectdb.php');

    if (isset($_REQUEST['order_id'])) {
        $order_id = $_REQUEST['order_id'];
        $accept = $_REQUEST['accept'];

        $query = "select ifnull(sum(co.amount),0) as car_order_amount, o.amount from car_orders co, orders o 
        where 1=1
        and co.order_id = o.order_id
        and o.order_id = $order_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $car_amount = $row['car_order_amount'];
        $amount = $row['amount'];

        if ($accept == 'Y') {
            if ($car_amount == $amount) {
                $query = "UPDATE orders SET accept_date = NOW(), order_status = 'accept', delivery_status = 'waiting' WHERE order_id = $order_id";

            }
            else {
                $_SESSION['err_accept'] = 'ไม่สามารถ ACCEPT';
                header('location: check_car.php');
            }
            
            

        }
        else if ($accept == 'N') {
            if ($car_amount == 0) {
                $query = "UPDATE orders SET order_status = 'not accept', delivery_status = '' WHERE order_id = $order_id";

            }
            else {
                $_SESSION['err_accept'] = 'ไม่สามารถ NOT ACCEPT';
                header('location: check_car.php');
            }
            
        }
        if (isset($_SESSION['err_accept'])) {
            header('location: check_car.php');
        }
        else {
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                header('location: index.php');
            }
            else {
                header('location: check_car.php');
            }
        }
        
    }
?>