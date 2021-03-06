<?php

    session_start();
    include('../connectdb.php');

    $now = $_SESSION['now'];
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['submit'])) {
        $sender = mysqli_real_escape_string($conn, $_POST['sender']);
        $receiver = mysqli_real_escape_string($conn, $_POST['receiver']);
        
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $datetime = $date . " " . $time;
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $provinces = mysqli_real_escape_string($conn, $_POST['provinces']);
        $amphures = mysqli_real_escape_string($conn, $_POST['amphures']);
        $districts = mysqli_real_escape_string($conn, $_POST['districts']);
        $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);
        $receiver_phone = mysqli_real_escape_string($conn, $_POST['receiver_phone']);
        $order_no = uniqid();
        
        
        $query = "INSERT INTO orders (sender, receiver, delivery_date, address, province_id, amphure_id, district_id, zipcode, receiver_phone, order_no, user_id, order_status, request_date) VALUES ('$sender', '$receiver', '$datetime', '$address', $provinces, $amphures, $districts, $zipcode, '$receiver_phone', '$order_no', $user_id, 'verifying', NOW())";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $query = "SELECT order_id FROM orders WHERE order_no = '$order_no'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['order_id'] = $row['order_id'];
            $_SESSION['order_no'] = $order_no;
            header('location: date_form2.php');

        }
        else {
            $_SESSION['err_date_form'] = 'Cannot insert data to database';
            header('location: date_form.php');
        }
    }
