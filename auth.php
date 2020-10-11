<?php
    function isLoggedIn() {
        return isset($_SESSION['is_logged_in']);
    }
?>