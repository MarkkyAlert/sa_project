<?php
session_start();
include('../auth.php');
include('../connectdb.php');
error_reporting(0);

$order_no = $_SESSION['order_no'];
$order_id = $_SESSION['order_id'];


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
    <title>เลือกสินค้า</title>
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

                <a href="index.php" class="active list-group-item list-group-item-action waves-effect mb-2">
                    <i class="fas fa-calendar-alt mr-3"></i>เลือกเวลาการจัดส่ง
                </a>
                <a href="status.php" class="list-group-item list-group-item-action waves-effect mb-2">
                    <i class="fas fa-check-square mr-3"></i>สถานะการตรวจสอบ
                </a>

                <a href="history.php" class="list-group-item list-group-item-action waves-effect mb-2">
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
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center">เลขที่สินค้า: <mark><?php echo $order_no ?></mark></h3>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php if (isset($_SESSION['err_date_form2'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_date_form2']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['suc_delete'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_delete']; ?></strong>
                        </div>
                    <?php endif; ?>


                    <form action="date_form2_backend.php" id="date_form2" method="post">
                        <select class="browser-default custom-select" name="products" id="products">
                            <?php
                            $query = "SELECT * FROM products";

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);

                            ?>
                            <option selected disabled>เลือกสินค้า</option>
                            <?php foreach ($result as $value) { ?>
                                <?php $product_name = $value['product_name']; ?>
                                <option value="<?php echo $value['product_id'] ?>"><?php echo $product_name; ?></option>
                            <?php } ?>

                        </select>
                        <br><br>
                        <label for="capacity">จำนวนสินค้า</label>
                        <input type="number" name="amount" onkeyup="numOnly(this)" onblur="numOnly(this)">
                        <button class="btn btn-info" type="submit" name="submit">OK</button>
                    </form>
                </div>
            </div>
            <?php
            $query = "SELECT * FROM order_details WHERE order_id = $order_id";
            $result = query($query);
            $row = mysqli_num_rows($result);
            ?>

            <div class="row mt-3">
                <div class="col-12">
                    <?php if ($row > 0) : ?>
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
                                    <th>
                                        <p class="text-center font-weight-bold">DELETE</p>
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

                                        <td>
                                            <p class="text-center"><?php echo $row['product_name']; ?></p>
                                        </td>
                                        <td>
                                            <p class="text-center"><?php echo $row['amount']; ?></p>
                                        </td>
                                        <td>
                                            <p class="text-center"><?php echo $row['sum_capacity']; ?></p>
                                        </td>
                                        <td>
                                            <p class="text-center"><a href="date_form2_backend.php?order_detail_id=<?php echo $row['order_detail_id']; ?>" class="btn btn-danger btn-sm">DELETE</a></p>
                                        </td>


                                    </tr>

                                <?php } ?>


                            </tbody>
                        </table>

                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="date_form2_backend.php?confirm=submit" class="btn btn-success btn-sm">SUBMIT</a>
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
        function numOnly(selector) {
            selector.value = selector.value.replace(/[^0-9]/g, '');
        }

        $(document).ready(function() {
            $('#date_form2').validate({
                rules: {

                    amount: {
                        required: true,
                        minlength: 4

                    }
                },
                messages: {

                    amount: {
                        required: 'กรุณากรอกจำนวน',
                        minlength: 'จำนวนสินค้าต้องมากกว่า 1000'
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
    </script>

</body>

</html>

<?php
if (isset($_SESSION['err_date_form2']) || isset($_SESSION['suc_delete'])) {
    unset($_SESSION['err_date_form2']);
    unset($_SESSION['suc_delete']);
}
?>