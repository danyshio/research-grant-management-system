<?php
session_start();
include("db.php");

if(!isset($_POST['proposal_id']) || !isset($_POST['decision'])){
    header("Location: ../frontend/hod-decisions.php");
    exit();
}

$proposalId = $_POST['proposal_id'];
$decision = $_POST['decision'];

if($decision == "approve"){
    $status = "Approved";
} else {
    $status = "Rejected";
}


mysqli_query($conn, "
UPDATE proposal 
SET status='$status' 
WHERE proposalId='$proposalId'
");


$res = mysqli_query($conn, "
SELECT userId FROM proposal 
WHERE proposalId='$proposalId'
");
$row = mysqli_fetch_assoc($res);
$userId = $row['userId'];


$message = "Your proposal has been $status by HOD";

mysqli_query($conn, "
INSERT INTO notification (userId, message, status, dateTime)
VALUES ('$userId', '$message', 'Unread', NOW())
");


header("Location: ../frontend/hod-decisions.php");
exit();
?>