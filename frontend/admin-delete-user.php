<?php
session_start();
require_once('../backend/db.php');
require_once('../backend/user-functions.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");

if (isset($_GET['id'])) {
    $user = getUserById($conn, $_GET['id']);
    if ($user && $user['email'] != 'admin@uni.edu') {
        deleteUser($conn, $_GET['id']);
        header("Location: admin-users.php?deleted=1");
        exit();
    }
}

header("Location: admin-users.php");
exit();
?>