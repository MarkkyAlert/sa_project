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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet">

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
                <?php if (isset($_SESSION['err_date_form'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong><?php echo $_SESSION['err_date_form']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['suc_date_form'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong><?php echo $_SESSION['suc_date_form']; ?></strong>
                        </div>
                    <?php endif; ?>
                    <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                        <div class="card-header bg-transparent border-info">
                            <h3 class="text-center">ฟอร์มจัดส่งสินค้า</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <form action="date_form_backend.php" id="date_form" method="post">

                                    <div class="form-outline mb-4">
                                        <input type="text" name="sender" id="sender" class="form-control" />
                                        <label class="form-label" for="sender">ชื่อผู้ส่ง</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="text" name="receiver" id="receiver" class="form-control" />
                                        <label class="form-label" for="receiver">ชื่อผู้รับ</label>
                                    </div>

                                    

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-4 input-with-post-icon datepicker">
                                                <input placeholder="Select date" type="date" id="date" name="date" class="form-control">
                                                <label class="form-label" for="date">เลือกวันที่</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-4">
                                                <input type="time" id="time" name="time" class="form-control" min="08:00" max="16:00">      
                                                <label class="form-label" for="district">เลือกเวลา</label>                                  
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <textarea class="form-control rounded-0" id="exampleFormControlTextarea2" name="address" rows="3"></textarea>
                                        <label class="form-label" for="exampleFormControlTextarea2">ที่อยู่</label>
                                    </div>

                                    <div class="row mb-4">
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
                                            <label class="form-label" for="province">จังหวัด</label>
                                        </div>
                                        <div class="col-6">
                                            <select class="browser-default custom-select" name="amphures" id="amphures">
                                                <option selected disabled>เลือกอำเภอ</option>
                                                <option value=""></option>
                                            </select>
                                            <label class="form-label" for="amphure">อำเภอ</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="browser-default custom-select" name="districts" id="districts">
                                                <option selected disabled>เลือกตำบล</option>
                                                <option value=""></option>
                                               
                                            </select>
                                            <label class="form-label" for="district">ตำบล</label>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-4">
                                                <input type="text" name="zipcode" id="zipcode" readonly class="form-control" />
                                                <label class="form-label" for="zipcode">รหัสไปรษณีย์</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" name="receiver_phone" id="receiver_phone" class="form-control" />
                                        <label class="form-label" for="receiver_phone">เบอร์โทรศัพท์</label>
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
    <script>
        $(document).ready(function() {
            $('#date_form').validate({
                rules: {
                    sender: 'required',
                    receiver: 'required',
                    address: 'required',
                    provinces: 'required',
                    amphures: 'required',
                    districts: 'required',
                    date: 'required',
                    time: 'required',
                    amount: {
                        required: true,
                        number: true,
                        minlength: 4,
                    },
                    receiver_phone: {
                        required: true,
                        number: true,
                        minlength: 9,
                        maxlength: 10
                    }

                },
                messages: {
                    sender: 'กรุณากรอกชื่อผู้ส่ง',
                    receiver: 'กรุณากรอกชื่อผู้รับ',
                    address: 'กรุณากรอกที่อยู่',
                    provinces: 'กรุณาเลือกจังหวัด',
                    amphures: 'กรุณาเลือกอำเภอ',
                    districts: 'กรุณาเลือกตำบล',
                    date: 'กรุณาเลือกวันที่',
                    time: 'กรุณาเลือกเวลา',
                    amount: {
                        required: 'กรุณากรอกจำนวน',
                        number: 'กรุณากรอกตัวเลขเท่านั้น',
                        minlength: 'จำนวนการสั่งต้องมากกว่า 1000'
                    },
                    receiver_phone: {
                        required: 'กรุณากรอกเบอร์โทรศัพท์',
                        number: 'กรุณากรอกตัวเลขเท่านั้น',
                        minlength: 'เบอร์โทรศัพท์ต้องมี 9-10 ตัว',
                        maxlength: 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัว'
                    },

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

        function recaptchaCallback() {
            $('#submit').removeAttr('disabled');
        }
    </script>
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

<?php 
    if (isset($_SESSION['err_date_form']) || isset($_SESSION['suc_date_form'])) {
        unset($_SESSION['err_date_form']);
        unset($_SESSION['suc_date_form']);
    }
?>