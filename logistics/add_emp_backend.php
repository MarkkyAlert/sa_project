<?php
    session_start();
    include('../connectdb.php');

    
    if (isset($_POST['submit'])) {
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = '123456';
        $passwordenc = md5($password);
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['err_email'] = 'มีอีเมล์นี้ในระบบ';
            header('location: add_emp.php');
        }
        else {
            $query = "INSERT INTO users (firstname, lastname, email, phone, password, type) VALUES ('$firstname', '$lastname', '$email', '$phone', '$passwordenc', 'E')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $query = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $user_id = $row['user_id'];

                $query = "INSERT INTO employees (user_id) VALUES ($user_id)";
                $result = mysqli_query($conn, $query);
                
                $_SESSION['suc_add_emp'] = 'เพิ่มข้อมูลเรียบร้อย';
                header('location: add_emp.php');
            }
            else {
                $_SESSION['err_add_emp'] = 'Cannot insert to database';
                header('location: add_emp.php');
            }
        }
    }
?>