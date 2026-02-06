<?php
session_start();
include("db.php");

$proposalId = $_POST['proposalId'];
$decision = $_POST['decision'];
$comments = $_POST['comments'];

$date = date("Y-m-d");

// Save review
$sql = "INSERT INTO review (proposalId, decision, comments, reviewDate)
        VALUES ('$proposalId', '$decision', '$comments', '$date')";
mysqli_query($conn, $sql);

// Update proposal status
$update = "UPDATE proposal SET status='Reviewed' WHERE proposalId='$proposalId'";
mysqli_query($conn, $update);

$message = "A review has been submitted and waiting for approval";

mysqli_query($conn,"
INSERT INTO notification (userId, message, dateTime, status)
VALUES ('3', '$message', NOW(), 'Unread')
");

header("Location: ../frontend/reviewer-dashboard.php");
exit();
?>