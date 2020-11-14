<?php
session_start();
include('../auth.php');
include('../connectdb.php');
error_reporting(E_ALL ^ E_NOTICE);

$order_no = $_SESSION['order_no'];
$amount = $_SESSION['amount'];
$amount_display = $amount;
$sum_capacity_display = $_SESSION['sum_capacity'];
$delivery_date = $_SESSION['delivery_date'];
$delivery_date = strtotime('+7 hours', strtotime($delivery_date));
$delivery_date2 = gmdate("d-m-Y H:i:s", $delivery_date);
$delivery_date3 = $delivery_date2;
$delivery_date4 = gmdate("Y-m-d H:i:s", $delivery_date);
$capacity = $_SESSION['capacity'];
$category = $_SESSION['category'];
$car_id = $_SESSION['car_id'];
$order_id = $_SESSION['order_id'];

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
    <title>ตรวจสอบ</title>
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

                <a href="index.php" class="active list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-tasks mr-3"></i>งานที่ได้รับมอบหมาย
                </a>


                <a href="order_waiting.php" class="list-group-item list-group-item-action waves-effect mb-1">
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
                    <?php if (isset($_SESSION['suc_query'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_query']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_query'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_query']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_check_amount'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_check_amount']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_choose_car'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_choose_car']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_over_capacity'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_over_capacity']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['suc_delete_car'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_delete_car']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_delete_car'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_delete_car']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_accept'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_accept']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-center">เลขที่สินค้า: <?php echo $order_no ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                    $query = "select IFNULL(sum(co.capacity),0) AS capacity from 
                        car_orders co 
                        where 1=1
                        and order_id = $order_id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $sum_capacity = $row['capacity'];

                    if ($sum_capacity > 0) {
                        $sum_capacity_display = $sum_capacity_display - $sum_capacity;
                    }
                    ?>
                    <h4 class="text-center">จำนวนรวม: <?php echo $amount_display ?></h4>
                    <h4 class="text-center">ความจุรวม: <?php echo $sum_capacity_display ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">


                    <form action="check_car_backend.php" method="post">
                        <select class="browser-default custom-select" name="license" id="license">
                            <?php
                            $query = "SELECT * FROM cars c WHERE 1=1
                            AND NOT EXISTS ( SELECT * FROM  car_orders co WHERE co.car_id = c.car_id 
                            AND '$delivery_date4'  BETWEEN co.start_date AND  co.end_date )";

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);

                            ?>
                            <option selected disabled>เลือกทะเบียนรถ</option>
                            <?php foreach ($result as $value) { ?>
                                <?php $capacity_dropdown = $value['license'] . " capacity: " . $value['capacity']; ?>
                                <option value="<?php echo $value['car_id'] ?>"><?php echo $capacity_dropdown ?></option>
                            <?php } ?>

                        </select>

                        <button class="btn btn-info" type="submit" name="submit">OK</button>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <form action="check_car2_backend.php" method="post">
                        <label for="capacity">ความจุรถ</label>
                        <input type="text" readonly value="<?php echo $capacity; ?>">
                        <label for="capacity">ประเภทรถ</label>
                        <input type="text" readonly value="<?php echo $category; ?>">
                        <label for="start_date">วันที่เริ่มส่งสินค้า</label>
                        <input type="text" name="start_date" readonly value="<?php echo $delivery_date3; ?>">
                        <label for="end_date">วันที่สิ้นสุดการส่งสินค้า</label>
                        <input type="date" name="end_date">
                        <label for="end_time">เวลาที่สิ้นสุดการส่งสินค้า</label>
                        <input type="time" name="end_time">
                        <label for="use_capacity">ความจุ</label>
                        <input type="text" name="use_capacity" onkeyup="numOnly(this)" onblur="numOnly(this)">
                        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <button class="btn btn-info" type="submit" name="submit">OK</button>


                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <?php
                    $query = "SELECT * FROM car_orders WHERE order_id = $order_id";
                    $result = query($query);
                    $row = mysqli_num_rows($result);
                    ?>
                    <?php if ($row != 0) : ?>
                        <table class="table table-bordered table-hover table-light">
                            <thead>
                                <tr>
                                    <th>
                                        <p class="text-center font-weight-bold">เลขที่สินค้า</p>
                                    </th>
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
                                        <p class="text-center font-weight-bold">จำนวน</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ลบรายการ</p>
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
                                        <td><?php echo $row['order_no']; ?></td>
                                        <td><?php echo $row['license']; ?></td>
                                        <td><?php echo $start_date; ?></td>
                                        <td><?php echo $end_date; ?></td>
                                        <td><?php echo $row['capacity']; ?></td>
                                        <td>
                                            <p class="text-center"><a href="delete_car_backend.php?car_order_id=<?php echo $row['car_order_id']; ?>" class="btn btn-danger btn-sm">DELETE</a></p>
                                        </td>


                                    </tr>

                                <?php } ?>


                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-right">
                    <a href="check_car3_backend.php?order_id=<?php echo $order_id; ?>&accept=Y"><button class="btn btn-success" type="submit">ACCEPT</button></a>
                </div>
                <div class="col-6">
                    <a href="check_car3_backend.php?order_id=<?php echo $order_id; ?>&accept=N"><button class="btn btn-danger" type="submit">NOT ACCEPT</button></a>
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
    <script>
        function numOnly(selector) {
            selector.value = selector.value.replace(/[^0-9]/g, '');
        }
    </script>

</body>

</html>

<?php
if (isset($_SESSION['suc_query']) || isset($_SESSION['err_query']) || isset($_SESSION['err_check_amount']) || isset($_SESSION['capacity']) || isset($_SESSION['category']) || isset($_SESSION['err_choose_car']) || isset($_SESSION['err_over_capacity']) || isset($_SESSION['suc_delete_car']) || isset($_SESSION['err_delete_car']) || isset($_SESSION['err_accept'])) {
    unset($_SESSION['suc_query']);
    unset($_SESSION['err_query']);
    unset($_SESSION['err_check_amount']);
    unset($_SESSION['capacity']);
    unset($_SESSION['category']);
    unset($_SESSION['err_choose_car']);
    unset($_SESSION['err_over_capacity']);
    unset($_SESSION['suc_delete_car']);
    unset($_SESSION['err_delete_car']);
    unset($_SESSION['err_accept']);
}
?>