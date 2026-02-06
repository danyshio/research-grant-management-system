<?php
include("db.php");

$name = $_POST['fullName'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO user (name, email, password, role, status)
        VALUES ('$name', '$email', '$password', 'Researcher', 'Active')";

if(mysqli_query($conn, $sql)){
    header("Location: ../frontend/index.html");
}else{
    echo "Error: " . mysqli_error($conn);
}
?>