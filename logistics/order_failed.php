<?php
session_start();
include('../auth.php');
include('../connectdb.php');

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
    <title>Material Design Bootstrap</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/mdb.min.css" rel="stylesheet">
    <link href="../css/style.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet" />


</head>

<body class="grey lighten-3">

    <header>
        <?php include('../partial/navbar_logistics.php'); ?>
        <?php include('../partial/sidebar_logistics.php'); ?>
    </header>

    <main class="pt-5 mx-lg-5">

        <div class="container-fluid mt-1">
            <?php
            $query_count = "SELECT COUNT(order_no) AS count FROM orders WHERE delivery_status = 'failed'";
            $result_count = mysqli_query($conn, $query_count);
            $row_count = mysqli_fetch_assoc($result_count);
            ?>
            <?php if ($row_count['count'] != 0) : ?>


                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-center ">รายการที่จัดส่งไม่สำเร็จ: <?php echo $row_count['count'] ?> รายการ</h3>

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
                                AND o.delivery_status = 'failed'";
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
                                            <td><u><a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>" class="text-primary"><?php echo $row['order_no']; ?></a></u></td>
                                            <td><?php echo $row['amount']; ?></td>
                                            <td><?php
                                                if ($row['delivery_status'] === 'delivering') {
                                                    echo "<p class=text-warning>กำลังจัดส่ง</p>";
                                                } else if ($row['delivery_status'] === 'waiting') {
                                                    echo "<p class=text-success>เตรียมจัดส่ง</p>";
                                                } else if ($row['delivery_status'] === 'failed') {
                                                    echo "<p class=text-danger>จัดส่งไม่สำเร็จ</p>";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $time; ?></td>
                                            <td><?php echo $row['sender']; ?></td>
                                            <td><?php echo $row['receiver']; ?></td>
                                            <td><?php echo $row['receiver_phone']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['province']; ?></td>
                                            <td><?php echo $row['amphure']; ?></td>
                                            <td><?php echo $row['district']; ?></td>
                                            <td><?php echo $row['zipcode']; ?></td>
                                            <td><?php echo $request_date; ?></td>
                                            <td><?php echo $request_time; ?></td>
                                            <?php $i++; ?>
                                        </tr>

                                    <?php } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($row_count['count'] == 0) : ?>
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="text-center text-danger">ไม่มีรายการที่จัดส่งไม่สำเร็จ</h3>
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
if (isset($_SESSION['err_email']) || isset($_SESSION['err_add_emp']) || isset($_SESSION['suc_add_emp'])) {
    unset($_SESSION['err_email']);
    unset($_SESSION['err_add_emp']);
    unset($_SESSION['suc_add_emp']);
}
?>