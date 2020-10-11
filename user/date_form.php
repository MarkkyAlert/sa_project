<?php
session_start();
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
                            <h3 class="text-center"><strong>Change Password</strong></h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <form action="change_pw_backend.php" id="changePW" method="post">

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" id="password" class="form-control" />
                                        <label class="form-label" for="password">New Password</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="confirm" id="confirm" class="form-control" />
                                        <label class="form-label" for="confirm">Confirm Password</label>
                                    </div>

                                    <!-- 2 column grid layout for inline styling -->


                                    <!-- Submit button -->
                                    <button type="submit" name="submit" class="btn btn-info btn-block">Change Password</button>
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
    

</body>

</html>
