<?php
    session_start();
    include('../connectdb.php');

    if (isset($_POST['submit'])) {
        $license = $_POST['license'];

        $query = "SELECT * FROM cars WHERE car_id = $license";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['capacity'] = $row['capacity'];
        $_SESSION['category'] = $row['category'];
        $_SESSION['car_id'] = $row['car_id'];
        header('location: check_car.php');
    }
?>