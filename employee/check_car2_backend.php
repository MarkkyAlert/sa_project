<?php
    session_start();
    include('../connectdb.php');

    if (isset($_POST['submit'])) {
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $amount = mysqli_real_escape_string($conn, $_POST['amount']);
        $car_id = mysqli_real_escape_string($conn, $_POST['car_id']);
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

        if (empty($car_id)) {
            $_SESSION['err_choose_car'] = 'กรุณาเลือกรถ';
            header('location: check_car.php');
        }
        else {
            $query = "select 
        (o.amount >= (select IFNULL(sum(co.amount), 0) + $amount from car_orders co where co.order_id = o.order_id)) AS check_amount from 
        orders o 
        where 1=1
        and order_id = $order_id
        ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $check_amount = $row['check_amount'];
        if ($check_amount) {
            $query = "SELECT capacity FROM cars WHERE car_id = $car_id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $capacity = $row['capacity'];
            if ($capacity < $amount) {
                $_SESSION['err_over_capacity'] = 'สินค้าเกินความจุรถ';
                header('location: check_car.php');
            }
            else {
                $query = "INSERT INTO car_orders (start_date, end_date, amount, car_id, order_id) VALUES ('$start_date', '$end_date', $amount, $car_id, $order_id)";
                $result = mysqli_query($conn, $query);
    
                if ($result) {
                    $_SESSION['suc_query'] = "Yes";
                    header('location: check_car.php');
                }
                else {
                    $_SESSION['suc_query'] = $query;
                    header('location: check_car.php');
                }
            }

            
        }
        else {
            $_SESSION['err_check_amount'] = 'จำนวนสินค้าเกินกำหนด';
            header('location: check_car.php');
        }
        }
        
        
        
        
       
    }
?>