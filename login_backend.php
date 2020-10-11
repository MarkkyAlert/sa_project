<?php
session_start();
include('connectdb.php');

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $passwordenc = md5($password);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$passwordenc'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0 && $row['type'] == 'U') {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['type'] = 'U';
        $query = "SELECT user_id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        
        if (!empty($_POST['remember'])) {
            setcookie('email', $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
            setcookie('password', $password, time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE['email'])) {
                setcookie('email', '');

                if (isset($_COOKIE['password'])) {
                    setcookie('password', '');
                }
            }
        }

        header('location: index.php');
    } else if (mysqli_num_rows($result) > 0 && $row['type'] == 'E') {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['type'] = 'E';

        if (!empty($_POST['remember'])) {
            setcookie('email', $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
            setcookie('password', $password, time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE['email'])) {
                setcookie('email', '');

                if (isset($_COOKIE['password'])) {
                    setcookie('password', '');
                }
            }
        }

        header('location: index_emp.php');
    } else if (mysqli_num_rows($result) > 0 && $row['type'] == 'L') {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['type'] = 'L';

        if (!empty($_POST['remember'])) {
            setcookie('email', $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
            setcookie('password', $password, time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE['email'])) {
                setcookie('email', '');

                if (isset($_COOKIE['password'])) {
                    setcookie('password', '');
                }
            }
        }

        header('location: index_logistics.php');
    } else {
        $_SESSION['err_login'] = 'อีเมล์หรือรหัสผ่านไม่ถูกต้อง';
        header('location: login.php');
    }
}