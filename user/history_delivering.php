<?php
session_start();
include('../auth.php');
include('../connectdb.php');
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}
if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'U') {
    header('location: ../page_not_found.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>กำลังจัดส่ง</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet" />


</head>

<body class="grey lighten-3">

    <header>
        <?php include('../partial/navbar_user.php'); ?>
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

                <a href="index.php" class="list-group-item list-group-item-action waves-effect mb-2">
                    <i class="fas fa-calendar-alt mr-3"></i>เลือกเวลาการจัดส่ง
                </a>
                <a href="status.php" class="list-group-item list-group-item-action waves-effect mb-2">
                    <i class="fas fa-check-square mr-3"></i>สถานะการตรวจสอบ
                </a>

                <a href="history.php" class="active list-group-item list-group-item-action waves-effect mb-2">
                    <i class="fas fa-history mr-3"></i>ประวัติการจัดส่ง
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
            $query_count = "SELECT COUNT(order_no) AS count FROM orders WHERE user_id = $user_id AND delivery_status = 'delivering'";
            $result_count = mysqli_query($conn, $query_count);
            $row_count = mysqli_fetch_assoc($result_count);
            ?>
            <?php if ($row_count['count'] != 0) : ?>
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-center">กำลังจัดส่ง: <?php echo $row_count['count'] ?> รายการ</h3>
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
                                    </th scope="col">
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">สถานะ</p>
                                    </th scope="col">
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">วันที่ต้องการส่ง</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">เวลาที่ต้องการส่ง</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">ผู้ส่ง</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">ผู้รับ</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">เบอร์โทรศัพท์</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">ที่อยู่</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">จังหวัด</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">อำเภอ</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">ตำบล</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">รหัสไปรษณีย์</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">วันที่ทำรายการ</p>
                                    </th>
                                    <th scope="col">
                                        <p class="text-center font-weight-bold">เวลาที่ทำรายการ</p>
                                    </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

$query = "SELECT o.order_id, o.delivery_status, o.order_status, o.request_date, (select IFNULL (sum(od.amount), 0) from order_details od where od.order_id = o.order_id) as amount, o.order_no, o.delivery_date, o.sender, o.receiver, o.receiver_phone, o.address, p.name_th AS province, a.name_th AS amphure, d.name_th AS district, o.zipcode FROM orders o, users u, provinces p , amphures a, districts d
WHERE o.province_id = p.id
AND o.amphure_id = a.id
AND o.district_id = d.id
AND o.user_id = u.user_id
AND o.user_id = $user_id
AND o.delivery_status = 'delivering'";


                                    $result = mysqli_query($conn, $query);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <?php
    
                                            $date = strtotime($row['delivery_date']);
                                            $date = date("d/m/Y", $date);
                                            $time = strtotime($row['delivery_date']);
                                            $time = date("H:i:s", $time);
                                            $request_date = strtotime($row['request_date']);
                                            $request_date = date("d/m/Y", $request_date);
                                            $request_time = strtotime($row['request_date']);
                                            $request_time = date("H:i:s", $request_time);
                                            ?>
                                            <td><?php echo $i; ?></td>
                                            <td><u><a href="order_detail_delivering.php?order_id=<?php echo $row['order_id']; ?>" class="text-primary"><?php echo $row['order_no']; ?></a></u></td>
                                            <td><p class="text-center"><?php echo $row['amount']; ?></p></td>
                                            <td>
                                                <?php
                                                if ($row['delivery_status'] == 'waiting') {
                                                    echo "<p class=text-primary text-center>เตรียมจัดส่ง</p>";
                                                } else if ($row['delivery_status'] == 'delivering') {
                                                    echo "<p class=text-warning text-center>กำลังจัดส่ง</p>";
                                                } else if ($row['delivery_status'] == 'success') {
                                                    echo '<p class="text-success text-center">จัดส่งสำเร็จ</p>';
                                                } else if ($row['delivery_status'] == 'failed') {
                                                    echo '<p class="text-danger text-center">จัดส่งไม่สำเร็จ</p>';
                                                }

                                                ?>
                                            </td>
                                            <td><p class="text-center"><?php echo $date; ?></p></td>
                                            <td><p class="text-center"><?php echo $time; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['sender']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['receiver']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['receiver_phone']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['address']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['province']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['amphure']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['district']; ?></p></td>
                                            <td><p class="text-center"><?php echo $row['zipcode']; ?></p></td>
                                            <td><p class="text-center"><?php echo $request_date; ?></p></td>
                                            <td><p class="text-center"><?php echo $request_time; ?></p></td>
                                            <?php $i++; ?>
                                        </tr>
    
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>



                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="history.php" class="btn btn-danger btn-sm">BACK</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($row_count['count'] == 0) : ?>
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-center text-danger">ไม่มีรายการที่กำลังจัดส่ง</h3>
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

