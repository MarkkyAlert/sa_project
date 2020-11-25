<?php
session_start();
include('../auth.php');
include('../connectdb.php');

if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'L') {
    header('location: ../page_not_found.php');
}
$row_count = $_SESSION['row_count'];
$name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>รายการที่รอตรวจสอบ</title>
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
            
           
            <?php if ($row_count != 0) : ?>


                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-center ">รายการออเดอร์ทั้งหมด</h3>

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
                                            <p class="text-center font-weight-bold">เลขที่สินค้า</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">จำนวน</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">ชื่อพนักงาน</p>
                                        </th>

                                        <th scope="col">
                                            <p class="text-center font-weight-bold">ชื่อผู้รับ</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">อำเภอ</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">วันที่ต้องการส่ง</p>
                                        </th>
                                        <th scope="col">
                                            <p class="text-center font-weight-bold">เวลาที่ต้องการส่ง</p>
                                        </th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = "select o.order_id,o.order_no, o.delivery_date,
                                    (select sum(od.amount) from order_details od where od.order_id = o.order_id) as amount ,
                                    o.receiver, (select a.name_th from amphures a where a.id = o.amphure_id) as amphures,
                                    CONCAT(u.firstname, ' ', u.lastname) as fullname
                                    from orders o , employees e , users u  where 1=1
                                    and o.employee_id = e.employee_id
                                    and e.user_id = u.user_id
                                    and (SELECT CONCAT(u.firstname, ' ', u.lastname)) LIKE '%{$name}%'  AND u.type = 'E'";
                                    $result = mysqli_query($conn, $query);



                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <?php

                                            $date = strtotime($row['delivery_date']);
                                            $date = date("d/m/Y", $date);
                                            $time = strtotime($row['delivery_date']);
                                            $time = date("H:i:s", $time);
                                            
                                            ?>
                                            <td>
                                                <p class="text-center"><?php echo $i; ?></p>
                                            </td>
                                            <td><u><a href="order_detail_his.php?order_id=<?php echo $row['order_id']; ?>" class="text-primary"><?php echo $row['order_no']; ?></a></u></td>
                                            <td>
                                                <p class="text-center"><?php echo $row['amount']; ?></p>
                                            </td>
                                            
                                            <td>
                                                <p class="text-center"><?php echo $row['fullname']; ?></p>
                                            </td>
                                            
                                            <td>
                                                <p class="text-center"><?php echo $row['receiver']; ?></p>
                                            </td>
                                            
                                            
                                            <td>
                                                <p class="text-center"><?php echo $row['amphures']; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $date; ?></p>
                                            </td>
                                            <td>
                                                <p class="text-center"><?php echo $time; ?></p>
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
            <?php if ($row_count == 0) : ?>
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-center text-danger">ไม่มีรายการออเดอร์</h3>
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

