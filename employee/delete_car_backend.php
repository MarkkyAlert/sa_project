<?php
    session_start();
    include('../connectdb.php');

    if ($_REQUEST['car_order_id']) {
        $car_order_id = $_REQUEST['car_order_id'];

        $query = "DELETE FROM car_orders WHERE car_order_id = $car_order_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['suc_delete_car'] = 'ลบรายการสำเร็จ';
            header('location: check_car.php');
        }
        else{
            $_SESSION['err_delete_car'] = 'ลบรายการไม่สำเร็จ';
            header('location: check_car.php');
        }
    }
?>