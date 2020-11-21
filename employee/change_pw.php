<?php
session_start();
include('../auth.php');

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
    <title>เปลี่ยนรหัสผ่าน</title>
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

                <a href="order_success.php" class="list-group-item list-group-item-action waves-effect mb-1">
                <i class="fas fa-check-circle mr-3"></i>รายการที่จัดส่งสำเร็จ
                </a>

                <a href="order_failed.php" class="list-group-item list-group-item-action waves-effect mb-1">
                <i class="fas fa-times-circle mr-3"></i>รายการที่จัดส่งไม่สำเร็จ
                </a>

                <a href="change_pw.php" class="list-group-item active waves-effect mb-1">
                    <i class="fas fa-unlock-alt mr-3"></i>เปลี่ยนรหัสผ่าน
                </a>
            </div>
        </div>
        <!-- Sidebar -->
    </header>

    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-1">
            <div class="row mt-3">
                <div class="col-md-12">
                    <?php if (isset($_SESSION['err_change_pw'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_change_pw']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['suc_change_pw'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_change_pw']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                        <div class="card-header bg-transparent border-info">
                            <h3 class="text-center">เปลี่ยนรหัสผ่าน</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <form action="change_pw_backend.php" id="changePW" method="post">

                                    <div class="form-outline mb-5">
                                        <input type="password" name="password" id="password" class="form-control" />
                                        <label class="form-label" for="password">รหัสผ่านใหม่</label>
                                    </div>

                                    <div class="form-outline mb-5">
                                        <input type="password" name="confirm" id="confirm" class="form-control" />
                                        <label class="form-label" for="confirm">ยืนยันรหัสผ่าน</label>
                                    </div>

                                    <!-- 2 column grid layout for inline styling -->


                                    <!-- Submit button -->
                                    <button type="submit" name="submit" class="btn btn-info btn-block">change password</button>
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
            $('#changePW').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6
                    },
                    confirm: {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    }
                },
                messages: {
                    password: {
                        required: 'กรุณากรอกรหัสผ่าน',
                        minlength: 'กรุณากรอกรหัสผ่านไม่น้อยกว่า 6 ตัวอักษร'
                    },
                    confirm: {
                        required: 'กรุณากรอกรหัสผ่าน',
                        minlength: 'กรุณากรอกรหัสผ่านไม่น้อยกว่า 6 ตัวอักษร',
                        equalTo: 'กรุณากรอกรหัสผ่านให้ตรงกัน'
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
    if (isset($_SESSION['err_change_pw']) || isset($_SESSION['suc_change_pw'])) {
        unset($_SESSION['err_change_pw']);
        unset($_SESSION['suc_change_pw']);
    }
?>