<?php
session_start();
include('../connectdb.php');

if (isset($_POST['submit'])) {
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $start_date = strtotime($start_date);
    $start_date = date('Y-m-d H:i:s', $start_date);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $end_date = date('Y-m-d H:i:s', strtotime("$end_date $end_time"));
    $use_capacity = mysqli_real_escape_string($conn, $_POST['use_capacity']);
    $car_id = mysqli_real_escape_string($conn, $_POST['car_id']);
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

    if (empty($car_id) || empty($end_date) || empty($use_capacity)) {
        $_SESSION['err_choose_car'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';

        header('location: check_car.php');
    } else {
        if ($start_date > $end_date) {
            $_SESSION['err_choose_car'] = 'ไม่สามารถระบุวันที่ย้อนหลังได้';

            header('location: check_car.php');
        } else {
            $query = "select 
            ((select sum(od.sum_capacity) 
            from order_details od where od.order_id = o.order_id)
             >= 
             (select IFNULL(sum(co.capacity), 0) + $use_capacity 
            from car_orders co where co.order_id = o.order_id)) 
            AS check_amount 
            from 
            orders o
            where 1=1
            and order_id = $order_id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $check_amount = $row['check_amount'];
            if ($check_amount) {
                $query = "SELECT capacity FROM cars WHERE car_id = $car_id";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $capacity = $row['capacity'];
                if ($capacity < $use_capacity) {
                    $_SESSION['err_over_capacity'] = 'สินค้าเกินความจุรถ';
                    header('location: check_car.php');
                } else {
                    $query2 = "select distinct co.end_date from car_orders co where co.order_id = $order_id";
                    $result2 = query($query2);
                    $row2 = mysqli_num_rows($result2);
                    $row3 = fetch_assoc($result2);
                    $err_enddate = '';
                    if ($row2 > 0) {
                        if ($row3['end_date'] == $end_date) {
                            $query = "INSERT INTO car_orders (start_date, end_date, capacity, car_id, order_id) VALUES ('$start_date', '$end_date', $use_capacity, $car_id, $order_id)";
                            
                        }
                        else {
                            $err_enddate = 'กรุณาระบุวันและเวลาให้ตรงกัน';
                            
                        }
                    }
                    else {
                        $query = "INSERT INTO car_orders (start_date, end_date, capacity, car_id, order_id) VALUES ('$start_date', '$end_date', $use_capacity, $car_id, $order_id)";
                    }
                    if ($err_enddate ==='') {
                        $result = mysqli_query($conn, $query);
                    

                        if ($result) {
                            $_SESSION['suc_query'] = 'ทำรายการเรียบร้อย';
                            header('location: check_car.php');
                        } else {
                            $_SESSION['err_query'] = 'Cannot insert data into database';
                            header('location: check_car.php');
                        }
                    }
                    else {
                        $_SESSION['err_enddate'] = $err_enddate;
                        header('location: check_car.php');
                    }
                    
                }
            } else {
                $_SESSION['err_over_capacity'] = 'สินค้าเกินความจุรถ';
                header('location: check_car.php');
            }
        }
    }
}
