<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
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
                        <a class="nav-link waves-effect" href="order_no.php">
                            <i class="fas fa-truck-moving mr-1"></i>ติดตามการจัดส่ง</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">

        <div class="row mt-3" style="width: 30rem; margin:0 auto;">
            <div class="col-md-12">
                <?php if (isset($_SESSION['err_login'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo $_SESSION['err_login']; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="card mt-5 border border-info rounded shadow-0 mb-3 animated fadeInDownBig" style="width: 30rem; margin:0 auto;">
                    <div class="card-header bg-transparent border-info">
                        <h3 class="text-center">Sign In</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <form action="login_backend.php" id="form_login" method="post">

                                <div class="form-outline mb-4">
                                    <input type="email" name="email" id="email" class="form-control" value="<?php if (isset($_COOKIE['email'])) { echo $_COOKIE['email'];} ?>" />
                                    <label class="form-label" for="form1Example1">Email</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" name="password" id="password" class="form-control" value="<?php if (isset($_COOKIE['password'])) { echo $_COOKIE['password'];} ?>" />
                                    <label class="form-label" for="form1Example2">Password</label>
                                </div>

                                <!-- 2 column grid layout for inline styling -->
                                <div class="row mb-4">
                                    <div class="col d-flex justify-content-center">
                                        <!-- Checkbox -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"  id="form1Example3" <?php if (isset($_COOKIE['email'])) { ?> checked <?php } ?> />
                                            <label class="form-check-label" for="form1Example3">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <!-- Simple link -->
                                        <a href="user/register.php">Need an account?</a>
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" name="submit" class="btn btn-info btn-block">Sign In</button>
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
            $('#form_login').validate({
                rules: {
                    
                    email: {
                        required: true,
                        email: true
                    },
                    
                    
                    password: {
                        required: true,
                        minlength: 6
                    },
                    
                },
                messages: {
                    
                    email: {
                        required: 'กรุณากรอกอีเมล์',
                        email: 'กรุณากรอกอีเมล์ให้ถูกต้อง'
                    },
                    
                    password: {
                        required: 'กรุณากรอกรหัสผ่าน',
                        minlength: 'กรุณากรอกรหัสผ่านไม่น้อยกว่า 6 ตัวอักษร'
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

        
    </script>
</body>

</html>

<?php
    if (isset($_SESSION['err_login'])) {
        unset($_SESSION['err_login']);
    }
?>