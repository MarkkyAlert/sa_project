<?php
session_start();
include('../connectdb.php');
include('../auth.php');

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



</head>

<body class="grey lighten-3">


    <header>
        <?php include('../partial/navbar_user.php'); ?>
        <?php include('../partial/sidebar_user.php'); ?>




    </header>
    <main class="pt-5 mx-lg-5">

        <div class="container-fluid mt-1">
            <div class="row mt-3">
                <div class="col-md-12">

                    <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                        <div class="card-header bg-transparent border-info">
                            <h3 class="text-center"><strong>ฟอร์มจัดส่งสินค้า</strong></h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <form action="change_pw_backend.php" id="changePW" method="post">

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" id="password" class="form-control" />
                                        <label class="form-label" for="password">ชื่อผู้ส่ง</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="confirm" id="confirm" class="form-control" />
                                        <label class="form-label" for="confirm">ชื่อผู้รับ</label>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <select class="browser-default custom-select">
                                                <option value="ถังสี">ถังสี</option>
                                            </select>
                                            <label class="form-label" for="confirm">เลือกสินค้า</label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-outline mb-4">
                                                <input type="text" name="confirm" id="amount" class="form-control" />
                                                <label class="form-label" for="amount">จำนวน</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" rows="3"></textarea>
                                        <label for="exampleFormControlTextarea2">ที่อยู่</label>
                                    </div>

                                    <div class="row mb-5">
                                        <div class="col-6">
                                            <select class="browser-default custom-select" name="provinces" id="provinces">
                                                <?php
                                                $query = "SELECT * FROM provinces";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                                <option selected disabled>เลือกจังหวัด</option>
                                                <?php foreach ($result as $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name_th'] ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <div class="col-6">
                                            <select class="browser-default custom-select" name="amphures" id="amphures">
                                                <option selected disabled>เลือกอำเภอ</option>
                                                <option value=""></option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <select class="browser-default custom-select" name="districts" id="districts">
                                                <option selected disabled>เลือกตำบล</option>
                                                <option value=""></option>
                                            </select>

                                        </div>
                                        <div class="col-6">
                                            <div class="form-outline mb-4">
                                                <input type="text" name="zipcode" id="zipcode" readonly class="form-control" />
                                                <label class="form-label" for="zipcode">รหัสไปรษณีย์</label>
                                            </div>

                                        </div>
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

    <script type="text/javascript">
        $('#provinces').change(function() {
            var id_province = $(this).val();
            $.ajax({
                type: "post",
                url: "ajax_address.php",
                data: {
                    id: id_province,
                    function: 'provinces'
                },
                success: function(data) {
                    $('#amphures').html(data);
                    $('#districts').html('');
                    $('#zipcode').val('');
                }
            });
        });
        $('#amphures').change(function() {
            var id_amphures = $(this).val();
            $.ajax({
                type: "post",
                url: "ajax_address.php",
                data: {
                    id: id_amphures,
                    function: 'amphures'
                },
                success: function(data) {

                    $('#districts').html(data);
                    $('#zipcode').val('');
                }
            });
        });
        $('#districts').change(function() {
            var id_districts = $(this).val();
            $.ajax({
                type: "post",
                url: "ajax_address.php",
                data: {
                    id: id_districts,
                    function: 'districts'
                },
                success: function(data) {
                    
                    $('#zipcode').val(data);
                }
            });
        });
    </script>

</body>

</html>