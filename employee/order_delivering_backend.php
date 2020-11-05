<?php
    session_start();
    include('../connectdb.php');
    
    if (isset($_POST['submit'])) {
        $order_id = $_POST['order_id'];
        //$file = $_POST['file'];
        $file = (isset($_POST['file']) ? $_POST['file'] : '');
        $date = date("Ymd");
        $numrand = (mt_rand());
        $upload = $_FILES['file'];
    
        if ($upload != '') {
            $path = "../uploads/";
            $type = strrchr($_FILES['file']['name'], ".");
            $newname = $date.$numrand.$type;
            $path_copy = $path.$newname;
            $path_link = "../uploads/" . $newname;
            move_uploaded_file($_FILES['file']['tmp_name'], $path_copy);
        }
    
        $query = "UPDATE orders SET file = '$newname', delivery_status = 'success' WHERE order_id = $order_id";
        $result = mysqli_query($conn, $query);
    
        if ($result) {
            $_SESSION['suc_upload'] = "ส่งสินค้าสำเร็จ";
            header('location: order_delivering.php');
        }
        else {
            $_SESSION['err_upload'] = "อัปโหลดไฟล์ไม่สำเร็จ";
            header('location: order_delivering.php');
        }
    }
