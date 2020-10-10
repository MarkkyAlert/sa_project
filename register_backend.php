<?php
session_start();
include('connectdb.php');

if (isset($_POST['submit'])) {

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm']);
    $secretKey = "6Lda5dAZAAAAAMWYSSUDeazD3c15Ynyd1QbOswRX";
    $responsekey = $_POST['g-recaptcha-response'];
    $remoteIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responsekey&remoteip=$remoteIP";
    $response = json_decode(file_get_contents($url));

    if ($response->success) {
    } else {
        echo "<script>alert('Verification Failed')</script>";
        header('Refresh:0; url=register.php');
    }

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['err_email'] = 'มีอีเมล์นี้ในระบบ';
        header('location: register.php');
    }

    else {
        $passwordenc = md5($password);
        $query = "INSERT INTO users (firstname, lastname, email, phone, password, type) VALUES ('$firstname', '$lastname', '$email', '$phone', '$passwordenc', 'U')";
        $result - mysqli_query($conn, $query);

        if ($result) {
            
            $_SESSION['is_logged_in'] = true;
            header('location: index.php');
        }

        else {
            $_SESSION['err_register'] = 'Cannot insert to database';
            header('location: register.php');
        }
    }

}
