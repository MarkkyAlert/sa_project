<?php
session_start();
include('../auth.php');
include('../connectdb.php');
error_reporting(E_ALL ^ E_NOTICE);

$order_no = $_SESSION['order_no'];
$amount = $_SESSION['amount'];
$amount_display = $amount;
$delivery_date = $_SESSION['delivery_date'];
$delivery_date = strtotime('+7 hours', strtotime($delivery_date));
$delivery_date2 = gmdate("Y-m-d H:i:s", $delivery_date);
$delivery_date3 = $delivery_date2;
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
    <title>Material Design Bootstrap</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet" />


</head>

<body class="grey lighten-3">

    <header>
        <?php include('../partial/navbar_emp.php'); ?>
        <?php include('../partial/sidebar_emp.php'); ?>
    </header>

    <main class="pt-5 mx-lg-5">

        <div class="container-fluid mt-1">
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center">เลขที่สินค้า: <?php echo $order_no ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                    $query = "select IFNULL(sum(co.amount),0) AS sum_amount from 
                        car_orders co 
                        where 1=1
                        and order_id = $order_id";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $sum_amount = $row['sum_amount'];

                    if ($sum_amount > 0) {
                        $amount_display = $amount_display - $sum_amount;
                    }
                    ?>
                    <h4 class="text-center">จำนวนสินค้า: <?php echo $amount_display ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php if (isset($_SESSION['suc_query'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['suc_query']; ?></strong>
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

                    <form action="check_car_backend.php" method="post">
                        <select class="browser-default custom-select" name="license" id="license">
                            <?php
                            $query = "SELECT * FROM cars c WHERE 1=1
                            AND NOT EXISTS ( SELECT * FROM  car_orders co WHERE co.car_id = c.car_id 
                            AND '$delivery_date3'  BETWEEN co.start_date AND  co.end_date )";

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);

                            ?>
                            <option selected disabled>เลือกทะเบียนรถ</option>
                            <?php foreach ($result as $value) { ?>
                                <?php $capacity_dropdown = $value['license'] . " capacity: " . $value['capacity']; ?>
                                <option value="<?php echo $value['car_id'] ?>"><?php echo $capacity_dropdown ?></option>
                            <?php } ?>

                        </select>
                        <button type="submit" name="submit">OK</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="check_car2_backend.php" method="post">
                        <label for="capacity">ความจุรถ</label>
                        <input type="text" readonly value="<?php echo $capacity; ?>">
                        <label for="capacity">ประเภทรถ</label>
                        <input type="text" readonly value="<?php echo $category; ?>">
                        <label for="start_date">วันที่เริ่มส่งสินค้า</label>
                        <input type="text" name="start_date" value="<?php echo $delivery_date3; ?>">
                        <label for="end_date">วันที่สิ้นสุดการส่งสินค้า</label>
                        <input type="datetime-local" name="end_date">
                        <label for="amount">จำนวน</label>
                        <input type="text" name="amount">
                        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <button type="submit" name="submit">OK</button>


                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
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


                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $query = "SELECT o.order_no, c.license, co.start_date, co.end_date, co.amount 
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
                                    <td><?php echo $row['amount']; ?></td>



                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-right">
                    <a href="check_car3_backend.php?order_id=<?php echo $order_id; ?>&accept=Y"><button type="submit">ACCEPT</button></a>                      
                </div>
                <div class="col-6">
                <a href="check_car3_backend.php?order_id=<?php echo $order_id; ?>&accept=N"><button type="submit">NOT ACCEPT</button></a>
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
        $(document).ready(function() {
            $('#add_emp').validate({

                rules: {
                    firstname: 'required',
                    lastname: 'required',
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 9,
                        maxlength: 10
                    },
                },
                messages: {
                    firstname: 'กรุณากรอกชื่อต้น',
                    lastname: 'กรุณากรอกนามสกุล',
                    email: {
                        required: 'กรุณากรอกอีเมล์',
                        email: 'กรุณากรอกอีเมล์ให้ถูกต้อง'
                    },
                    phone: {
                        required: 'กรุณากรอกเบอร์โทรศัพท์',
                        number: 'กรุณากรอกตัวเลขเท่านั้น',
                        minlength: 'เบอร์โทรศัพท์ต้องมี 9-10 ตัว',
                        maxlength: 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัว'
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback')
                    error.insertAfter(element)
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid')
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid')
                }
            });
        })
    </script>

</body>

</html>

<?php
if (isset($_SESSION['suc_query']) || isset($_SESSION['err_check_amount']) || isset($_SESSION['capacity']) || isset($_SESSION['category']) || isset($_SESSION['err_choose_car']) || isset($_SESSION['err_over_capacity'])) {
    unset($_SESSION['suc_query']);
    unset($_SESSION['err_check_amount']);
    unset($_SESSION['capacity']);
    unset($_SESSION['category']);
    unset($_SESSION['err_choose_car']);
    unset($_SESSION['err_over_capacity']);
}
?>