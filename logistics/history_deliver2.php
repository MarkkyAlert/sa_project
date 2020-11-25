<?php
session_start();
error_reporting(0);
include('../auth.php');
include('../connectdb.php');

if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'L') {
    header('location: ../page_not_found.php');
}
$delivery_date = $_SESSION['deli'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>รายการที่จัดส่งสำเร็จ</title>
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

                <a href="index.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-calendar-alt mr-3"></i>รายการที่รอตรวจสอบ
                </a>

                <a href="accept_order.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-check-square mr-3"></i>รายการที่อนุมัติ
                </a>

                <a href="not_accept_order.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-times-circle mr-3"></i>รายการที่ไม่อนุมัติ
                </a>

                <a href="order.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-truck mr-3"></i></i>การจัดส่ง
                </a>
                <a href="report1.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-calendar-week mr-3"></i>รายการส่่งมอบสินค้า
                </a>
                <a href="history_deliver_main.php" class="active list-group-item list-group-item-action waves-effect mb-1">
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


            <?php
            $query = "SELECT DISTINCT o.order_no, (SELECT IFNULL (SUM(od.amount), 0) FROM order_details od WHERE od.order_id = o.order_id) as amount,  CONCAT(u.firstname, ' ', u.lastname) AS name, o.receiver, d.name_th, TIME(o.delivery_date) AS time FROM orders o , users u, employees e, order_details od, districts d WHERE (o.employee_id = e.employee_id AND e.user_id = u.user_id and o.district_id = d.id AND date(o.delivery_date) = '$delivery_date')";
            $result = query($query);
            $row2 = mysqli_num_rows($result);
            ?>

            <div class="row mt-5">
                <div class="col-12">
                    <?php if (isset($_SESSION['err_report'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_report']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-center ">ประวัติงานที่มอบหมาย</h3>
                    <form action="history_deliver2_backend.php" method="post">
                        <?php $b = substr(date('Y-d-m'), 8);
                        $c = number_format($b);
                        if ($c == 1) {
                            $c = '02';
                        } else if ($c == 2) {
                            $c = '03';
                        } else if ($c == 3) {
                            $c = '04';
                        } else if ($c == 4) {
                            $c = '05';
                        } else if ($c == 5) {
                            $c = '06';
                        } else if ($c == 6) {
                            $c = '07';
                        } else if ($c == 7) {
                            $c = '08';
                        } else if ($c == 8) {
                            $c = '09';
                        } else if ($c == 9) {
                            $c = '10';
                        } else if ($c == 10) {
                            $c = '11';
                        } else if ($c == 11) {
                            $c = '12';
                        } else if ($c == 12) {
                            $c = '01';
                        } ?>
                        เลือกวันที่ <input type="date" name="date" max="<?php echo date('Y-' . $c . '-d'); ?>"><br>
                        <button class="btn btn-info" type="submit" name="submit">OK</button><br>

                    </form>
                </div>
            </div>
            <?php if ($row2 > 0) : ?>
                <div class="row">
                    <div class="col-12">
                        <?php
                        $date = strtotime($delivery_date);
                        $date = date("d/m/Y", $date);
                        ?>
                        <h4 class="text-center">วันที่ <?php echo $date; ?></h4>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">ลำดับที่</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">ชื่อ</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">นามสกุล</p>
                                        </th scope="col">
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">จำนวน</p>
                                        </th scope="col">




                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "select u.firstname , u.lastname, count(1) as num
                                    from orders o , employees e , users u  where 1=1
                                    and o.employee_id = e.employee_id
                                    and e.user_id = u.user_id
                                    and date(o.delivery_date) = date('$delivery_date')
                                    
                                    group by u.firstname , u.lastname
                                    order by num desc";
                                    $result = mysqli_query($conn, $query);



                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>

                                            <td>
                                                <p class="text-center"><?php echo $i; ?></p>
                                            </td>


                                            <td>
                                                <p class="text-center"><?php echo $row['firstname']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['lastname']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['num']; ?></p>
                                            </td>

                                            <?php $i++; ?>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/mdb.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js"></script>
    <script src="../node_modules/jquery-validation/dist/jquery.validate.min.js"></script>


</body>

</html>

<?php
if (isset($_SESSION['err_report']) || isset($_SESSION['deli'])) {
    unset($_SESSION['err_report']);
    unset($_SESSION['deli']);
}
?>