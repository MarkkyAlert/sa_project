<?php
session_start();
include('../connectdb.php');
$order_no = $_SESSION['order_no'];
if (isset($_REQUEST['id'])) {
    $emp_id = $_REQUEST['id'];
    $query = "SELECT order_status FROM orders WHERE order_no = '$order_no'";
    $result = query($query);
    $row = fetch_assoc($result);
    if ($row['order_status'] === 'verifying') {
        $query = "UPDATE orders SET employee_id = $emp_id, order_status = 'checking' WHERE order_no = '$order_no'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['suc_assign_emp'] = 'มอบหมายพนักงานเรียบร้อย';
            header('location: assign_emp.php');
        } else {
            $_SESSION['err_assign_emp'] = 'Cannot update data into database';
            header('location: assign_emp.php');
        }
    }
    else {
        $_SESSION['err_assign_emp'] = 'ไม่สามารถมอบหมายพนักงานซ้ำได้';
        header('location: assign_emp.php');
    }
}
