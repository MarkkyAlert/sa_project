<?php
session_start();
include('../auth.php');
include('../connectdb.php');
$emp_id = $_SESSION['employee_id'];
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
    <title>จัดส่งสำเร็จ</title>
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


                <a href="order_waiting.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-clock mr-3"></i>รายการที่รอจัดส่ง
                </a>

                <a href="order_delivering.php" class="list-group-item list-group-item-action waves-effect mb-1">
                    <i class="fas fa-spinner mr-3"></i>รายการที่กำลังจัดส่ง
                </a>

                <a href="order_success.php" class="active list-group-item list-group-item-action waves-effect mb-1">
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
                    <?php if (isset($_SESSION['suc_delivering'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_delivering']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['err_delivering'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_delivering']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php

                    $query =  "SELECT o.order_id, o.order_no,o.file, 
                    (select IFNULL (sum(od.amount), 0) from order_details od where od.order_id = o.order_id) as amount, 
                    (select IFNULL (sum(od.sum_capacity), 0) from order_details od where od.order_id = o.order_id) 
                    as capacity, o.delivery_date, o.sender, o.receiver, o.receiver_phone, o.address
                    , p.name_th AS province, a.name_th AS amphure, d.name_th AS district, o.zipcode 
                    FROM orders o, users u, provinces p , amphures a, districts d 
                    WHERE o.province_id = p.id
                    AND o.amphure_id = a.id
                    AND o.district_id = d.id
                    AND o.user_id = u.user_id
                    AND o.employee_id = $emp_id
                    AND o.order_status = 'accept'
                    AND o.delivery_status = 'success'";
                    $result = mysqli_query($conn, $query);
                    $row1 = mysqli_num_rows($result);
                    ?>
                    <?php if ($row1 == 0) : ?>
                        <h3 class="text-center text-danger">ไม่มีรายการที่จัดส่งสำเร็จ</h3>
                    <?php endif; ?>
                    <?php if ($row1 > 0) : ?>
                        <h3 class="text-center">รายการที่จัดส่งสำเร็จ: <?php echo $row1; ?> รายการ</h3>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-light">
                            <thead>
                                <tr>
                                    <th>
                                        <p class="text-center font-weight-bold">เลขที่สินค้า</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">จำนวน</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ความจุ</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">วันที่ต้องการส่ง</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">เวลาที่ต้องการส่ง</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ผู้ส่ง</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ผู้รับ</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">เบอร์โทรศัพท์</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ที่อยู่</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">จังหวัด</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">อำเภอ</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ตำบล</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">รหัสไปรษณีย์</p>
                                    </th>
                                    
                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <?php
                                        $date = strtotime($row['delivery_date']);
                                        $date = date("d/m/Y", $date);
                                        $time = strtotime($row['delivery_date']);
                                        $time = date("H:i:s", $time);
                                        ?>
                                        <td><u><a href="order_detail_success.php?order_id=<?php echo $row['order_id']; ?>" class="text-primary"><?php echo $row['order_no']; ?></a></u></td>
                                        <td><?php echo $row['amount']; ?></td>
                                        <td><?php echo $row['capacity']; ?></td>
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
                                        
                                        
                                        

                                    </tr>

                                <?php } ?>

                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
if (isset($_SESSION['err_delivering']) || isset($_SESSION['suc_delivering'])) {
    unset($_SESSION['err_delivering']);
    unset($_SESSION['suc_delivering']);
}
?>