<?php
session_start();
include("db.php");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_assoc($result);

    //  SAVE USER DATA INTO SESSION
    $_SESSION['userId'] = $row['userId'];
    $_SESSION['userName'] = $row['name'];
    $_SESSION['role'] = $row['role'];

    //  REDIRECT BASED ON ROLE
    if ($row['role'] == 'Researcher') {
        header("Location: ../frontend/dashboardresearcher.php");
    }
    elseif ($row['role'] == 'Reviewer') {
        header("Location: ../frontend/reviewer-dashboard.php");
    }
    elseif ($row['role'] == 'HOD') {
        header("Location: ../frontend/hod-dashboard.html");
    }
    elseif ($row['role'] == 'Admin') {
        header("Location: ../frontend/admin-dashboard.html");
    }

    exit();

} else {
    echo "Invalid email or password";
}
?>