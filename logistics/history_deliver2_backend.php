<?php
session_start();
include('../connectdb.php');
if (isset($_POST['submit'])) {
    $delivery_date111 = $_POST['date'];
    $query = "select u.firstname , u.lastname, count(1) as num
    from orders o , employees e , users u  where 1=1
    and o.employee_id = e.employee_id
    and e.user_id = u.user_id
    and date(o.delivery_date) = date('$delivery_date111')
    
    group by u.firstname , u.lastname
    order by num desc";
    $result = query($query);
    $row2 = mysqli_num_rows($result);
    if ($row2 > 0) {
        $_SESSION['deli'] = $delivery_date111;
        header('location: history_deliver2.php');
    }
    else {
        $_SESSION['err_report'] = 'ไม่พบข้อมูล';
        header('location: history_deliver2.php');
    }
} else {
    $delivery_date = '';
}