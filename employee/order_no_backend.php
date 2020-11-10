<?php
    session_start();
    include('../connectdb.php');

    if (isset($_REQUEST['order_no'])) {
        $order_no = mysqli_real_escape_string($conn, $_REQUEST['order_no']);

        $query = "select sum(od.amount) as amount, sum(od.sum_capacity) AS sum_capacity,
        o.order_no,o.delivery_date,o.order_id from orders o ,
        order_details od where 1=1
        and o.order_id = od.order_id
        and o.order_no = '$order_no'
        and order_status = 'checking'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
       

        if ($row['order_no'] === $order_no) {
            $_SESSION['order_no'] = $row['order_no'];
            $_SESSION['amount'] = $row['amount'];
            $_SESSION['delivery_date'] = $row['delivery_date'];
            $_SESSION['sum_capacity'] = $row['sum_capacity'];
            $_SESSION['order_id'] = $row['order_id'];
            header('location: check_car.php');
        }
        else {
            $_SESSION['err_order_no'] = 'ไม่พบเลขที่สินค้า';
            header('location: order_no.php');
        }
    }
?>