<?php
session_start();
include('../auth.php');
include('../connectdb.php');
require_once('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf();
ob_start();
if (!isLoggedIn()) {
    header('location: ../login.php');
} else if ($_SESSION['type'] != 'L') {
    header('location: ../page_not_found.php');
}

if (isset($_REQUEST['delivery_date'])) {
    $delivery_date = $_REQUEST['delivery_date'];
} else {
    $delivery_date = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    body {
        font-family: Garuda;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>รายการที่จัดส่งสำเร็จ</title>
</head>

<body>
    <table class="table table-bordered table-hover table-light">
        <thead>
            <tr>
                <th scope="col">
                    <p class="text-center font-weight-bold">ลำดับที่</p>
                </th>
                <th scope="col">
                    <p class="text-center font-weight-bold">ชื่อลูกค้า</p>
                </th>
                <th scope="col">
                    <p class="text-center font-weight-bold">รายละเอียด</p>
                </th scope="col">
                <th scope="col">
                    <p class="text-center font-weight-bold">จำนวน</p>
                </th scope="col">

                <th scope="col">
                    <p class="text-center font-weight-bold">รหัสสินค้า</p>
                </th>
                <th scope="col">
                    <p class="text-center font-weight-bold">เลขที่ออเดอร์</p>
                </th>


            </tr>
        </thead>
        <tbody>
            <?php
            if ($delivery_date !== '') {
                $query = "select o.receiver , p.product_name, od.amount, p.product_id, o.order_no
                                    from orders o , users u, products p, order_details od
                                    where 1=1
                                    and (o.user_id = u.user_id
                                    and o.order_id = od.order_id
                                    and od.product_id = p.product_id
                                    and date(o.delivery_date) = '$delivery_date')";
                $result = query($query);
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <td>
                            <p class="text-center"><?php echo $i; ?></p>
                        </td>
                        <td>
                            <p class="text-center"><?php echo $row['receiver']; ?></p>
                        </td>
                        <td>
                            <p class="text-center"><?php echo $row['product_name']; ?></p>
                        </td>
                        <td>
                            <p class="text-center"><?php echo $row['amount']; ?></p>
                        </td>
                        <td>
                            <p class="text-center"><?php echo $row['product_id']; ?></p>
                        </td>
                        <td>
                            <p class="text-center"><?php echo $row['order_no']; ?></p>
                        </td>

                    </tr>
            <?php }
                $i++;
            } ?>
        </tbody>
    </table>
</body>

</html>

<?php
$html = ob_get_contents();


$mpdf->WriteHTML($html);
$mpdf->Output("report1.pdf");
ob_end_flush()
?>
<a href="report1.pdf">click</a>