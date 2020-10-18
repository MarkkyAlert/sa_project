<?php
session_start();
include('../auth.php');
include('../connectdb.php');
$delivery_date = $_SESSION['delivery_date'];

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
                <div class="col-12">
                    <?php if (isset($_SESSION['suc_assign_emp'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_assign_emp']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['err_assign_emp'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_assign_emp']; ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
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

                            $query = "SELECT e.employee_id, u.firstname, u.lastname,";
                            $query = $query . "(SELECT COUNT(1) FROM orders o WHERE o.employee_id = e.employee_id";
                            $query = $query . " AND o.order_status = 'checking' AND '" .  $delivery_date . "' = o.delivery_date) AS order_amount";
                            $query = $query . " FROM employees e, users u WHERE e.user_id = u.user_id";
                            $query = $query . " AND u.type = 'E' ORDER BY order_amount";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <p class="text-center"><?php echo $row['firstname']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center"><?php echo $row['lastname']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center"><?php echo $row['order_amount']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-center"><a href="assign_emp_backend.php?id=<?php echo $row['employee_id']; ?>" class="btn btn-warning btn-sm">มอบหมาย</a></p>
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


</body>

</html>

<?php
if (isset($_SESSION['suc_assign_emp']) || isset($_SESSION['err_assign_emp'])) {
    unset($_SESSION['suc_assign_emp']);
    unset($_SESSION['err_assign_emp']);
}
?>