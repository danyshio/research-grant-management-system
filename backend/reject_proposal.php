<?php
session_start();
include("db.php");

if(!isset($_GET['id'])){
    header("Location: ../frontend/reviewer-dashboard.php");
    exit();
}

$proposalId = $_GET['id'];

$sql = "UPDATE proposal SET status='Rejected' WHERE proposalID='$proposalId'";
mysqli_query($conn, $sql);

header("Location: ../frontend/reviewer-dashboard.php");
exit();
?>