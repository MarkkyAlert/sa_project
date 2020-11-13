<?php
    session_start();
    include('../connectdb.php');
    $order_id = $_SESSION['order_id'];
    
    if (isset($_REQUEST['confirm'])) {
        $confirm = $_REQUEST['confirm'];

        if ($confirm === 'submit') {
            $_SESSION['suc_date_form'] = 'กำลังตรวจสอบ';
            header('location: date_form.php');
        }
    }
    
    if (isset($_REQUEST['order_detail_id'])) {
        $order_detail_id = $_REQUEST['order_detail_id'];

        $query = "DELETE FROM order_details WHERE order_detail_id = $order_detail_id";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $_SESSION['suc_delete'] = 'ลบรายการสำเร็จ';
        }
        header('location: date_form2.php');
    }
    if (isset($_POST['submit'])) {
        $product_id = $_POST['products'];
        $amount = $_POST['amount'];
        $query = "SELECT use_capacity FROM products WHERE product_id = $product_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $use_capacity = $row['use_capacity'];
        $sum_capacity = $amount * $use_capacity;
        
        $query = "INSERT INTO order_details (product_id, amount, sum_capacity, order_id) VALUES ($product_id, $amount, $sum_capacity, $order_id)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header('location: date_form2.php');
        }
        else {
            $_SESSION['err_date_form2'] = 'Cannot insert data into database';
            header('location: date_form2.php');
        }
    }
?>