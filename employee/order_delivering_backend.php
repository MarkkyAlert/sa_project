<?php
    session_start();
    include('../connectdb.php');
    
    if (isset($_POST['submit'])) {
        $order_id = $_POST['order_id'];
        $check = $_POST['check'];
        $reasons = $_POST['reasons'];
        $reason_desc = $_POST['reasonDesc'];
        //$file = $_POST['file'];
        $file = (isset($_POST['file']) ? $_POST['file'] : '');
        $date = date("Ymd");
        $numrand = (mt_rand());
        $upload = $_FILES['file'];

        if ($check === 'success') {
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
        else if ($check === 'failed') {
            if (!isset($reason_desc)) {
                $query = "UPDATE orders SET reason_id = $reasons, delivery_status = 'failed' WHERE order_id = $order_id";

            }
            else {
                $query = "UPDATE orders SET reason_id = $reasons, reason_desc = '$reason_desc' , delivery_status = 'failed' WHERE order_id = $order_id";

            }
            $result = query($query);

            if ($result) {
                $_SESSION['suc_reason'] = "ทำรายการสำเร็จ";
                header('location: order_delivering.php');
            }
            else {
                $_SESSION['err_reason'] = "ทำรายการไม่สำเร็จ" . $query;
                header('location: order_delivering.php');
            }
        }
        
    }
