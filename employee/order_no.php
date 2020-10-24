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
            <div class="row mt-3">
                <div class="col-md-12">
                    <?php if (isset($_SESSION['err_order_no'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_order_no']; ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                        <div class="card-header bg-transparent border-info">
                            <h3 class="text-center">กรุณากรอกเลขที่สินค้า</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <form action="order_no_backend.php" id="changePW" method="post">

                                    <div class="form-outline mb-5">
                                        <input type="text" name="order_no" id="order_no" class="form-control" />
                                        <label class="form-label" for="order_no">เลขที่สินค้า</label>
                                    </div>
                                    <!-- Submit button -->
                                    <button type="submit" name="submit" class="btn btn-info btn-block">SUBMIT</button>
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
    if (isset($_SESSION['err_order_no'])) {
        unset($_SESSION['err_order_no']);
    }
?>