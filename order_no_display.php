<?php session_start();
include('connectdb.php');
$order_no = $_SESSION['order_no2'];
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
                <h3 class="text-center">สถานะการจัดส่ง</h3>
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
                                <p class="text-center font-weight-bold">เลขที่ออเดอร์</p>
                            </th>
                            <th>
                                <p class="text-center font-weight-bold">จำนวนสินค้า</p>
                            </th>
                            <th>
                                <p class="text-center font-weight-bold">สถานะ</p>
                            </th>
                            <th>
                                <p class="text-center font-weight-bold">วันที่ส่ง</p>
                            </th>
                            <th>
                                <p class="text-center font-weight-bold">เวลา</p>
                            </th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $query = "SELECT o.order_no, o.order_id, (SELECT IFNULL (SUM(od.amount), 0) FROM order_details od WHERE od.order_id = o.order_id) AS amount,  o.delivery_date, o.delivery_status FROM orders o
                    WHERE o.order_no = '$order_no' AND (o.delivery_status = 'waiting' OR o.delivery_status = 'delivering'
                    OR o.delivery_status = 'success' OR o.delivery_status = 'failed')";

                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <?php

                                $date = strtotime($row['delivery_date']);
                                $date = date("d/m/Y", $date);
                                $time = strtotime($row['delivery_date']);
                                $time = date("H:i:s", $time);
                                
                                ?>

                                <td>
                                    <u><p class="text-center"><a class="text-primary" href="order_detail.php?order_id=<?php echo $row['order_id']; ?>"><?php echo $order_no; ?></a></p></u>
                                </td>
                                <td>
                                    <p class="text-center"><?php echo $row['amount']; ?></p>
                                </td>
                                <td>
                                    <p class="text-center"><?php echo $date; ?></p>
                                </td>
                                <td>
                                    <p class="text-center"><?php echo $time; ?></p>
                                </td>
                                <td>
                                    <?php
                                    if ($row['delivery_status'] == 'waiting') {
                                        echo "<p class='text-center text-primary'>เตรียมจัดส่ง</p>";
                                    } else if ($row['delivery_status'] == 'delivering') {
                                        echo "<p class=text-warning text-center>กำลังจัดส่ง</p>";
                                    } else if ($row['delivery_status'] == 'success') {
                                        echo '<p class="text-success text-center">จัดส่งสำเร็จ</p>';
                                    } else if ($row['delivery_status'] == 'failed') {
                                        echo '<p class="text-danger text-center">จัดส่งไม่สำเร็จ</p>';
                                    }

                                    ?>
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