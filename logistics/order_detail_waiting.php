<?php
session_start();
include('../auth.php');
include('../connectdb.php');
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_REQUEST['order_id'])) {
   
    $order_id = $_REQUEST['order_id'];
}



if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'L') {
    header('location: ../page_not_found.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>รายละเอียดออเดอร์</title>
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

                <a href="order.php" class="active list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-truck mr-3"></i></i>การจัดส่ง
                </a>
                <a href="report1.php" class="list-group-item list-group-item-action waves-effect mb-1">
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
            <div class="row mt-5">
                <div class="col-12">
                <?php
                        $query = "SELECT order_no FROM orders WHERE order_id = $order_id";
                        $result = query($query);
                        $row = fetch_assoc($result);
                    ?>
                    <h3 class="text-center">เลขที่สินค้า: <mark><?php echo $row['order_no']; ?></mark></h3>
                </div>
            </div>
         
            <div class="row mt-3">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-light">
                        <thead>
                            <tr>
                                <th>
                                    <p class="text-center font-weight-bold">ชื่อสินค้า</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">จำนวนสินค้า</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">ความจุรวม</p>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "select p.product_name, od.order_detail_id , od.amount, od.sum_capacity from products p, order_details od 
                            where 1=1
                            and p.product_id = od.product_id
                            and od.order_id = $order_id";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    
                                    <td><p class="text-center"><?php echo $row['product_name']; ?></p></td>
                                    <td><p class="text-center"><?php echo $row['amount']; ?></p></td>
                                    <td><p class="text-center"><?php echo $row['sum_capacity']; ?></p></td>
                                 
                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="order_waiting.php" class="btn btn-danger btn-sm">BACK</a>
                </div>
                
                
            </div>
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

