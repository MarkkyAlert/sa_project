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
                    <i class="fas fa-calendar-week mr-3"></i>เวลาการจัดส่ง
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
    

</body>

</html>

<?php
if (isset($_SESSION['err_email']) || isset($_SESSION['err_add_emp']) || isset($_SESSION['suc_add_emp'])) {
    unset($_SESSION['err_email']);
    unset($_SESSION['err_add_emp']);
    unset($_SESSION['suc_add_emp']);
}
?>