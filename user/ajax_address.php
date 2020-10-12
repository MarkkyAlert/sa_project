<?php
    include('../connectdb.php');

    if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
        $id = $_POST['id'];
        $query = "SELECT * FROM amphures WHERE province_id = '$id'";
        $result = mysqli_query($conn, $query);
        echo '<option selected disabled>เลือกอำเภอ</option>';
        foreach($result as $value) {
            echo '<option value="'.$value['id'].'">'.$value['name_th'].'</option>';
        }
    }

    if (isset($_POST['function']) && $_POST['function'] == 'amphures') {
        $id = $_POST['id'];
        $query = "SELECT * FROM districts WHERE amphure_id = '$id'";
        $result = mysqli_query($conn, $query);
        echo '<option selected disabled>เลือกตำบล</option>';
        foreach($result as $value) {
            echo '<option value="'.$value['id'].'">'.$value['name_th'].'</option>';
        }
    }

    if (isset($_POST['function']) && $_POST['function'] == 'districts') {
        $id = $_POST['id'];
        $query = "SELECT * FROM districts WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo $row['zip_code'];
    }
    
?>