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
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center">มอบหมายพนักงาน</h3>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-light">
                        <thead>
                            <tr>
                                <th>
                                    <p class="text-center font-weight-bold">ชื่อ</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">นามสกุล</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">จำนวนออเดอร์</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">มอบหมาย</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM users";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['firstname']; ?></td>
                                    <td><?php echo $row['lastname']; ?></td>
                                    <td>
                                        <p class="text-center"><a href="edit.php?update_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">มอบหมาย</a></p>
                                    </td>
                                    
                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>
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
if (isset($_SESSION['err_email']) || isset($_SESSION['err_add_emp']) || isset($_SESSION['suc_add_emp'])) {
    unset($_SESSION['err_email']);
    unset($_SESSION['err_add_emp']);
    unset($_SESSION['suc_add_emp']);
}
?>