<?php
session_start();
include('../auth.php');
include('../connectdb.php');

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
    <title>ประวัติการจัดส่ง</title>
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
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 25rem; margin:0 auto;">
                        <div class="card-header bg-transparent border-info">
                            <h3 class="text-center">ประวัติการจัดส่ง</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <div class="list-group list-group-flush">
                                   

                                    <a href="history_all.php" class="list-group-item list-group-item-action waves-effect mb-2">
                                    <i class="fas fa-list-ul mr-3"></i>การจัดส่งทั้งหมด
                                    </a>
                                    <a href="history_success.php" class="list-group-item list-group-item-action waves-effect mb-2">
                                    <i class="fas fa-check-circle mr-3"></i>จัดส่งสำเร็จ
                                    </a>

                                    <a href="history_failed.php" class="list-group-item list-group-item-action waves-effect mb-2">
                                    <i class="fas fa-times-circle mr-3"></i>จัดส่งไม่สำเร็จ
                                    </a>

                                    <a href="history_delivering.php" class="list-group-item list-group-item-action waves-effect mb-2">
                                    <i class="fas fa-spinner mr-3"></i>กำลังจัดส่ง
                                    </a>

                                    <a href="history_waiting.php" class="list-group-item list-group-item-action waves-effect mb-2">
                                    <i class="fas fa-truck mr-3"></i>เตรียมจัดส่ง
                                    </a>
                                </div>
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

