<?php
session_start();
include('../auth.php');
include('../connectdb.php');
$emp_id = $_SESSION['employee_id'];
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
            <div class="row mt-5">
                <div class="col-12">
                    <?php if (isset($_SESSION['suc_upload'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_upload']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['err_upload'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_upload']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php

                    $query = "SELECT o.order_id, o.order_no, o.amount, o.delivery_date, o.sender, o.receiver, o.receiver_phone, o.address, p.name_th AS province, a.name_th AS amphure, d.name_th AS district, o.zipcode FROM orders o, users u, provinces p , amphures a, districts d 
                            WHERE o.province_id = p.id
                            AND o.amphure_id = a.id
                            AND o.district_id = d.id
                            AND o.user_id = u.user_id
                            AND o.employee_id = $emp_id
                            AND o.order_status = 'accept'
                            AND o.delivery_status = 'delivering'";
                    $result = mysqli_query($conn, $query);
                    $row1 = mysqli_num_rows($result);
                    ?>
                    <?php if ($row1 == 0) : ?>
                        <h3 class="text-center text-danger">ไม่มีรายการที่กำลังจัดส่ง</h3>
                    <?php endif; ?>
                    <?php if ($row1 > 0) : ?>
                        <h3 class="text-center">รายการที่กำลังจัดส่ง</h3>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-light">
                            <thead>
                                <tr>
                                    <th>
                                        <p class="text-center font-weight-bold">เลขที่สินค้า</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">จำนวน</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">วันที่ต้องการส่ง</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">เวลาที่ต้องการส่ง</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ผู้ส่ง</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ผู้รับ</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">เบอร์โทรศัพท์</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ที่อยู่</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">จังหวัด</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">อำเภอ</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">ตำบล</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">รหัสไปรษณีย์</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">Action</p>
                                    </th>
                                    <th>
                                        <p class="text-center font-weight-bold">Action</p>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php



                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <?php
                                        $date = strtotime($row['delivery_date']);
                                        $date = date("d/m/Y", $date);
                                        $time = strtotime($row['delivery_date']);
                                        $time = date("H:i:s", $time);
                                        ?>
                                        <td><?php echo $row['order_no']; ?></td>
                                        <td><?php echo $row['amount']; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $time; ?></td>
                                        <td><?php echo $row['sender']; ?></td>
                                        <td><?php echo $row['receiver']; ?></td>
                                        <td><?php echo $row['receiver_phone']; ?></td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td><?php echo $row['province']; ?></td>
                                        <td><?php echo $row['amphure']; ?></td>
                                        <td><?php echo $row['district']; ?></td>
                                        <td><?php echo $row['zipcode']; ?></td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <p class="text-center"><button type="button" class="btn btn-success btm-sm" data-toggle="modal" data-target="#exampleModal">
                                                    SUCCESS
                                                </button></p>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">เลือกไฟล์บิล</h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="order_delivering_backend.php" id="bill" method="post" enctype="multipart/form-data">
                                                                <div class="form-file">
                                                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                                                    <input type="hidden" name="check" value="success">
                                                                    <input type="file" name="file" class="" id="customFile" />

                                                                </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <p class="text-center"><button type="button" class="btn btn-danger btm-sm" data-toggle="modal" data-target="#exampleModal1">
                                                    FAILED
                                                </button></p>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel1">เลือกเหตุผล</h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="order_delivering_backend.php" method="post">
                                                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                                                <input type="hidden" name="check" value="failed">
                                                                <select class="browser-default custom-select" name="reasons">
                                                                    <?php
                                                                    $query = "SELECT * FROM reasons";
                                                                    $result = mysqli_query($conn, $query);
                                                                    ?>
                                                                    <option selected disabled>เลือกเหตุผล</option>
                                                                    <?php foreach ($result as $value) { ?>
                                                                        <option value="<?php echo $value['reason_id'] ?>"><?php echo $value['reason'] ?></option>
                                                                    <?php } ?>
                                                                </select>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" name="submit" class="btn btn-info">Submit</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php endif; ?>
                            </tbody>
                        </table>
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
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>

    <script>
        $(document).ready(function() {
            $('#bill').validate({

                rules: {
                    file: {
                        required: true,
                        extension: "jpg|png"
                    },
                },
                messages: {

                    file: {
                        required: 'กรุณาเลือกไฟล์รูปภาพ',
                        extension: "ต้องเป็นไฟล์ .jpg หรือ .png เท่านั้น"
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
if (isset($_SESSION['err_upload']) || isset($_SESSION['suc_upload'])) {
    unset($_SESSION['err_upload']);
    unset($_SESSION['suc_upload']);
}
?>