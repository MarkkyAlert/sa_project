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
} else if ($_SESSION['type'] != 'E') {
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
        <?php include('../partial/navbar_emp.php'); ?>
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
                <p>ยินดีต้อนรับคุณ...</p>

                <a href="index.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-tasks mr-3"></i>งานที่ได้รับมอบหมาย
                </a>


                <a href="order_waiting.php" class="active list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-clock mr-3"></i>รายการที่รอจัดส่ง
                </a>

                <a href="order_delivering.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-spinner mr-3"></i>รายการที่กำลังจัดส่ง
                </a>

                <a href="order_success.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-check-circle mr-3"></i>รายการที่จัดส่งสำเร็จ
                </a>

                <a href="order_failed.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-times-circle mr-3"></i>รายการที่จัดส่งไม่สำเร็จ
                </a>

                <a href="change_pw.php" class="list-group-item list-group-item-action waves-effect mb-1">
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
                    <h3 class="text-center">เลขที่สินค้า: <mark><?php echo $row['order_no'] ?></mark></h3>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                <table class="table table-bordered table-hover table-light">
                            <thead>
                                <tr>
                                    
                                    <th>
                                        <p class="text-center font-weight-bold">ทะเบียนรถ</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">วันที่เริ่มส่งสินค้า</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">วันที่สิ้นสุดการส่งสินค้า</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ความจุสินค้า</p>
                                    </th>
                                    


                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $query = "SELECT co.car_order_id, o.order_no, c.license, co.start_date, co.end_date, co.capacity
                            FROM car_orders co , cars c,orders o WHERE 1=1
                            AND co.car_id = c.car_id
                            AND co.order_id = o.order_id
                            AND co.order_id = $order_id";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <?php
                                        $start_date = strtotime($row['start_date']);
                                        $start_date = date("d/m/Y H:i:s", $start_date);
                                        $end_date = strtotime($row['end_date']);
                                        $end_date = date("d/m/Y H:i:s", $end_date);
                                        ?>
                                        
                                        <td><p class="text-center"><?php echo $row['license']; ?></p></td>
                                        <td><p class="text-center"><?php echo $start_date; ?></p></td>
                                        <td><p class="text-center"><?php echo $end_date; ?></td>
                                        <td><p class="text-center"><?php echo $row['capacity']; ?></p></td>
                                        


                                    </tr>

                                <?php } ?>


                            </tbody>
                        </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="order_detail_waiting.php?order_id=<?php echo $order_id; ?>" class="btn btn-danger btn-sm">BACK</a>
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

