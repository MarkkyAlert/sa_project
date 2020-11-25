<?php
session_start();
include('../auth.php');
include('../connectdb.php');
$delivery_date = $_SESSION['delivery_date1'];

if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'L') {
    header('location: ../page_not_found.php');
}
if (isset($_REQUEST['order_no'])) {
    $order_no = $_REQUEST['order_no'];
    $_SESSION['order_no'] = $order_no;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>มอบหมายพนักงาน</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet" />
</head>

<body class="grey lighten-3">

    <header>
        <?php include('../partial/navbar_logistics.php'); ?>
        <!-- Sidebar -->

        <div class="sidebar-fixed position-fixed overflow-auto">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a class="logo-wrapper waves-effect ">
                            <img src="../img/logo.png" class="img-fluid" alt="">
                        </a>
                    </div>
                </div>
            </div>


            <div class="list-group list-group-flush">
                <p>ยินดีต้อนรับคุณ <strong><?php echo $_SESSION['firstname']; ?></strong></p>

                <a href="index.php" class="active list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-calendar-alt mr-3"></i>รายการที่รอตรวจสอบ
                </a>

                <a href="accept_order.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-check-square mr-3"></i>รายการที่อนุมัติ
                </a>

                <a href="not_accept_order.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-times-circle mr-3"></i>รายการที่ไม่อนุมัติ
                </a>

                <a href="report1.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-calendar-week mr-3"></i>รายการส่่งมอบสินค้า
                </a>
                <a href="history_deliver_main.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-history mr-3"></i>ประวัติงานที่มอบหมาย
                </a>

                <a href="change_pw.php" class="list-group-item list-group-item-action  waves-effect mb-2">
                    <i class="fas fa-unlock-alt mr-3"></i>เปลี่ยนรหัสผ่าน
                </a>


            </div>
        </div>

        <!-- Sidebar -->
    </header>

    <main class="pt-5 mx-lg-5">

        <div class="container-fluid mt-1">
            <div class="row mt-3">
                <div class="col-12">
                    <?php if (isset($_SESSION['suc_assign_emp'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_assign_emp']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['err_assign_emp'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_assign_emp']; ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">

                    <h3 class="text-center">มอบหมายพนักงาน</h3>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-light">
                        <thead>
                            <tr>
                                <th>
                                    <p class="text-center font-weight-bold">ชื่อ</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">นามสกุล</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">จำนวนออเดอร์</p>
                                </th>
                                
                                <th>
                                    <p class="text-center font-weight-bold">มอบหมาย</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "SELECT e.employee_id, u.firstname, u.lastname, 
                            (SELECT COUNT(1) FROM orders o WHERE o.employee_id = e.employee_id  AND 
                            date('$delivery_date') = date(o.delivery_date)) AS order_amount,
                            (select count(1) from car_orders co , orders o 
                            where co.order_id = o.order_id and o.employee_id = e.employee_id and '$delivery_date' between start_date and end_date) as deliverFlag
                            FROM employees e, users u WHERE e.user_id = u.user_id AND u.type = 'E' ORDER BY order_amount";
                            
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <p class="text-center"><?php echo $row['firstname']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center"><?php echo $row['lastname']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center"><?php echo $row['order_amount']; ?></p>
                                    </td>
                                    <?php if ($row['deliverFlag'] > 0): ?>
                                    <td>
                                        <p class="text-center"><a  href="#" class="btn btn-muted btn-sm">มอบหมาย</a></p>
                                    </td>
                                    <?php endif; ?>
                                    <?php if ($row['deliverFlag'] <= 0) : ?>
                                    <td>
                                        <p class="text-center"><a  href="assign_emp_backend.php?id=<?php echo $row['employee_id']; ?>" class="btn btn-warning btn-sm">มอบหมาย</a></p>
                                    </td>
                                    <?php endif; ?>
                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/mdb.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js"></script>


</body>

</html>

<?php
if (isset($_SESSION['suc_assign_emp']) || isset($_SESSION['err_assign_emp'])) {
    unset($_SESSION['suc_assign_emp']);
    unset($_SESSION['err_assign_emp']);
}
?>