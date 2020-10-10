<?php
    session_start();
    include('connectdb.php');

    if (isset($POST['submit'])) {
        
        $firstname = mysqli_real_escape_string($conn, $POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $POST['lastname']);
        $email = mysqli_real_escape_string($conn, $POST['email']);
        $phone = mysqli_real_escape_string($conn, $POST['phone']);
        $password = mysqli_real_escape_string($conn, $POST['password']);
        $confirm = mysqli_real_escape_string($conn, $POST['confirm']);

        if ($password !== $confirm) {
            $_SESSION['err_confirm'] = "รหัสผ่านไม่ตรงกัน";
            header('location: register.php');
        }

        if (empty($firstname)) {
            $_SESSION['err_fname'] = "กรุณาระบุชื่อต้น";
        }

        if (empty($lastname)) {
            $_SESSION['err_lname'] = 'กรุณาระบุนามสกุล';
        }

        if (empty($email)) {
            $_SESSION['err_email'] = 'กรุณาระบุอีเมล์';
        }

        if (empty($phone)) {
            $SESSION['err_phone'] = 'กรุณาระบุเบอร์โทรศัพท์';
        }
        
        
    }
?>