<?php
include("db.php");

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE proposal SET status='$status' WHERE proposalId='$id'";
mysqli_query($conn, $sql);

header("Location: ../frontend/reviewer-dashboard.php");
?>