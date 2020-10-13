<?php
session_start();
include('../auth.php');

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
            <div class="row mt-3">
                <div class="col-md-12">
                    <?php if (isset($_SESSION['err_add_emp'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_add_emp']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['err_email'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_email']; ?></strong>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['suc_add_emp'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_add_emp']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">

                        <div class="card-header bg-transparent border-info">
                            <h3 class="text-center">เพิ่มข้อมูลพนักงาน</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <form action="add_emp_backend.php" method="post" id="add_emp">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-outline mb-5">
                                                <input type="text" id="firstname" name="firstname" class="form-control" />
                                                <label class="form-label" for="firstname">ชื่อ</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-outline mb-5">
                                                <input type="text" id="lastname" name="lastname" class="form-control" />
                                                <label class="form-label" for="lastname">นามสกุล</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-outline mb-5">
                                        <input type="email" id="email" name="email" class="form-control" />
                                        <label class="form-label" for="email">Email</label>
                                    </div>

                                    <div class="form-outline mb-5">
                                        <input type="text" id="phone" name="phone" class="form-control" />
                                        <label class="form-label" for="phone">เบอร์โทรศัพท์</label>
                                    </div>

                                    <!-- Submit button -->
                                    <button type="submit" name="submit" id="submit" class="btn btn-info btn-block">ADD</button>
                                </form>
                            </p>
                        </div>
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
if (isset($_SESSION['err_email']) || isset($_SESSION['err_add_emp']) || isset($_SESSION['suc_add_emp'])) {
    unset($_SESSION['err_email']);
    unset($_SESSION['err_add_emp']);
    unset($_SESSION['suc_add_emp']);
}
?>