<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- <link href="css/style.min.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <nav class="navbar  navbar-expand-lg navbar-light white scrolling-navbar">
        <div class="container-fluid">

            <!-- Brand -->

            <a class="navbar-brand" href="https://mdbootstrap.com/docs/jquery/">
                <strong class="blue-text">FenFern Logistics</strong>
            </a>

            <!-- Collapse -->


            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link waves-effect" href="https://mdbootstrap.com/docs/jquery/">
                            <i class="fas fa-truck-moving mr-1"></i>ติดตามการจัดส่ง</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">

        <div class="row mt-3" style="width: 30rem; margin:0 auto;">
            <div class="col-md-12">
                <?php if (isset($_SESSION['err_register'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo $_SESSION['err_register']; ?></strong>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['err_email'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo $_SESSION['err_email']; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="card mt-4 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                    
                    <div class="card-header bg-transparent border-info">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <form action="register_backend.php" method="post" id="formRegister">

                                <div class="form-outline mb-4">
                                    <input type="text" id="firstname" name="firstname" class="form-control" />
                                    <label class="form-label" for="firstname">First Name</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="lastname" name="lastname" class="form-control" />
                                    <label class="form-label" for="lastname">Last Name</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="email" id="email" name="email" class="form-control" />
                                    <label class="form-label" for="email">Email</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="text" id="phone" name="phone" class="form-control" />
                                    <label class="form-label" for="phone">Phone</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control" />
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="confirm" name="confirm" class="form-control" />
                                    <label class="form-label" for="confirm"> Confirm Password</label>
                                </div>

                                <!-- 2 column grid layout for inline styling -->
                                <div class="row mb-4">


                                    <div class="col">
                                        <!-- Simple link -->
                                        <a href="login.php">Have an account?</a>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6Lda5dAZAAAAAJ776z4Xgdu469YOgCRJvYn1KByI"></div>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="submit" id="submit" disabled class="btn btn-info btn-block">Register</button>
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
    <script>
        $(document).ready(function() {
            $('#formRegister').validate({
                rules: {
                    firstname: 'required',
                    lastname: 'required',
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 9,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    confirm: {
                        required: true,
                        minlength: 6,
                        equalTo: '#password'
                    }
                },
                messages: {
                    firstname: 'กรุณากรอกชื่อต้น',
                    lastname: 'กรุณากรอกนามสกุล',
                    email: {
                        required: 'กรุณากรอกอีเมล์',
                        email: 'กรุณากรอกอีเมล์ให้ถูกต้อง'
                    },
                    phone: {
                        required: 'กรุณากรอกเบอร์โทรศัพท์',
                        number: 'กรุณากรอกตัวเลขเท่านั้น',
                        minlength: 'เบอร์โทรศัพท์ต้องมี 9-10 ตัว',
                        maxlength: 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัว'
                    },
                    password: {
                        required: 'กรุณากรอกรหัสผ่าน',
                        minlength: 'กรุณากรอกรหัสผ่านไม่น้อยกว่า 6 ตัวอักษร'
                    },
                    confirm: {
                        required: 'กรุณากรอกรหัสผ่าน',
                        minlength: 'กรุณากรอกรหัสผ่านไม่น้อยกว่า 6 ตัวอักษร',
                        equalTo: 'กรุณากรอกรหัสผ่านให้ตรงกัน'
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

        function recaptchaCallback() {
            $('#submit').removeAttr('disabled');
        }
    </script>
</body>

</html>

<?php
if (isset($_SESSION['err_register']) || isset($_SESSION['err_email'])) {
    session_destroy();
}
?>