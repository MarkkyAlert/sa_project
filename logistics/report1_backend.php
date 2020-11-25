<?php
session_start();
include('../connectdb.php');
if (isset($_POST['submit'])) {
    $delivery_date111 = $_POST['date'];
    $query = "SELECT DISTINCT o.order_no, (SELECT IFNULL (SUM(od.amount), 0) FROM order_details od WHERE od.order_id = o.order_id) as amount,  CONCAT(u.firstname, ' ', u.lastname) AS name, o.receiver, d.name_th, TIME(o.delivery_date) AS time FROM orders o , users u, employees e, order_details od, districts d WHERE (o.employee_id = e.employee_id AND e.user_id = u.user_id and o.district_id = d.id AND date(o.delivery_date) = '$delivery_date111')";
    $result = query($query);
    $row2 = mysqli_num_rows($result);
    if ($row2 > 0) {
        $_SESSION['deli'] = $delivery_date111;
        header('location: report1.php');
    }
    else {
        $_SESSION['err_report'] = 'ไม่พบข้อมูล';
        header('location: report1.php');
    }
} else {
    $delivery_date = '';
}
