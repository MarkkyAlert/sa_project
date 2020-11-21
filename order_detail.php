<?php session_start();
include('connectdb.php');
if (isset($_REQUEST['order_id'])) {
    $order_id = $_REQUEST['order_id'];
}
?>
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
    <div class="container mt-1">
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center">รายละเอียดออเดอร์</h3>
            </div>
        </div>
    </div>
    <div class="container mt-1">
        <div class="row mt-3">
            <div class="col-12">
                <table class="table table-bordered border-danger table-striped table-hover table-light">
                    <thead>
                        <tr>
                            <th>
                                <p class="text-center font-weight-bold">ชื่อสินค้า</p>
                            </th>
                            <th>
                                <p class="text-center font-weight-bold">จำนวนสินค้า</p>
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
                            </tr>

                        <?php } ?>


                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <a href="order_no.php" class="btn btn-danger btn-sm">BACK</a>
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