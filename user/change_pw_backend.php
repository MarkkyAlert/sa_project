<?php
    session_start();
    include('../connectdb.php');
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['submit'])) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $passwordenc = md5($password);

        $query = "UPDATE users SET password = '$passwordenc' WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['suc_change_pw'] = 'เปลี่ยนรหัสผ่านเรียบร้อย';
            header('location: change_pw.php');
        }
        else {
            $_SESSION['err_change_pw'] = 'Cannot update data to database';
        }
    }
?>