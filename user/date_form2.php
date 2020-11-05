<?php
session_start();
include('../auth.php');
include('../connectdb.php');
error_reporting(E_ALL ^ E_NOTICE);

$order_no = $_SESSION['order_no'];
$order_id = $_SESSION['order_id'];


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
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center">เลขที่สินค้า: <?php echo $order_no ?></h3>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <?php if (isset($_SESSION['err_date_form2'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_date_form2']; ?></strong>
                        </div>
                    <?php endif; ?>

                    

                    <form action="date_form2_backend.php" method="post">
                        <select class="browser-default custom-select" name="products" id="products">
                            <?php
                            $query = "SELECT * FROM products";

                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);

                            ?>
                            <option selected disabled>เลือกสินค้า</option>
                            <?php foreach ($result as $value) { ?>
                                <?php $product_name = $value['product_name']; ?>
                                <option value="<?php echo $value['product_id'] ?>"><?php echo $product_name; ?></option>
                            <?php } ?>

                        </select>
                        <label for="capacity">จำนวนสินค้า</label>
                        <input type="number" name="amount">
                        <button type="submit" name="submit">OK</button>
                    </form>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-light">
                        <thead>
                            <tr>
                                <th>
                                    <p class="text-center font-weight-bold">ชื่อสินค้า</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">จำนวนสินค้า</p>
                                </th>
                                <th>
                                    <p class="text-center font-weight-bold">ความจุรวม</p>
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
                                    
                                    <td><p class="text-center"><?php echo $row['product_name']; ?></p></td>
                                    <td><p class="text-center"><?php echo $row['amount']; ?></p></td>
                                    <td><p class="text-center"><?php echo $row['sum_capacity']; ?></p></td>
                                    <td>
                                        <p class="text-center"><a href="date_form2_backend.php?order_detail_id=<?php echo $row['order_detail_id']; ?>" class="btn btn-danger btn-sm">DELETE</a></p>
                                    </td>


                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-right">
                    <a href="date_form2_backend.php?confirm=submit" class="btn btn-success btn-sm">SUBMIT</a>
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
        function numOnly(selector) {
            selector.value = selector.value.replace(/[^0-9]/g, '');
        }
    </script>

</body>

</html>

<?php
if (isset($_SESSION['err_date_form2'])) {
    unset($_SESSION['err_date_form2']);
}
?>