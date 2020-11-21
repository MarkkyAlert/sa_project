<?php
session_start();
include('../auth.php');
include('../connectdb.php');

if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'L') {
    header('location: ../page_not_found.php');
}

if (isset($_POST['submit'])) {
    $delivery_date = $_POST['date'];
} else {
    $delivery_date = '';
}

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
                <a href="report1.php" class="active list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-calendar-week mr-3"></i>เวลาการจัดส่ง
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
                        <h3 class="text-center ">รายการส่งมอบสินค้า</h3>
                        <form action="" method="post">
                            เลือกวันที่ <input type="date" name="date"><br>
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
                                            <p class="text-center font-weight-bold">เลขที่ออเดอร์</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">จำนวน</p>
                                        </th scope="col">
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">ชื่อพนักงาน</p>
                                        </th scope="col">

                                        <th scope="col">
                                            <p class="text-center font-weight-bold">ชื่อผู้รับ</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">อำเภอ</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">เวลาที่ต้องส่ง</p>
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "SELECT DISTINCT o.order_no, (SELECT IFNULL (SUM(od.amount), 0) FROM order_details od WHERE od.order_id = o.order_id) as amount,  CONCAT(u.firstname, ' ', u.lastname) AS name, o.receiver, d.name_th, TIME(o.delivery_date) AS time FROM orders o , users u, employees e, order_details od, districts d WHERE (o.employee_id = e.employee_id AND e.user_id = u.user_id and o.district_id = d.id AND date(o.delivery_date) = '$delivery_date')";
                                    $result = mysqli_query($conn, $query);



                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>

                                            <td>
                                                <p class="text-center"><?php echo $i; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['order_no'] ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['amount']; ?></p>
                                            </td>


                                            <td>
                                                <p class="text-center"><?php echo $row['name']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['receiver']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['name_th']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $row['time']; ?></p>
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