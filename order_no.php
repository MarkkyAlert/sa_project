<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดตามการจัดส่ง</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- <link href="css/style.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar  navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container-fluid">

            <!-- Brand -->

            <a class="navbar-brand" href="https://mdbootstrap.com/docs/jquery/">
                <strong class="blue-text">FenFern Logistics</strong>
            </a>
            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                    <a class="nav-link waves-effect" href="login.php">
                        <i class="fas fa-sign-in-alt mr-1"></i>Sign In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">

        <div class="row mt-3" style="width: 30rem; margin:0 auto;">
            <div class="col-md-12">
                <?php if (isset($_SESSION['err_order_no'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo $_SESSION['err_order_no']; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                    <div class="card-header bg-transparent border-info">
                        <h3 class="text-center">ติดตามสถานะการจัดส่ง</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <form action="order_no_backend.php" method="post">

                                <div class="form-outline mb-4">
                                    <input type="text" name="order_no"  class="form-control">
                                    <label class="form-label" for="form1Example1">เลขที่ออเดอร์</label>
                                </div>

                                

                                <!-- 2 column grid layout for inline styling -->
                                

                                <!-- Submit button -->
                                <button type="submit" name="submit" class="btn btn-info btn-block">SUBMIT</button>
                            </form>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js"></script>
    <script src="node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
    
</body>

</html>

<?php
    if (isset($_SESSION['err_order_no'])) {
        unset($_SESSION['err_order_no']);
    }
?>