<?php
include("../db.php");

$proposalId = $_POST['proposalId'];
$status = $_POST['status']; // Approved or Rejected

$sql = "UPDATE proposal SET status='$status' WHERE proposalId='$proposalId'";
mysqli_query($conn, $sql);

echo "Proposal status updated.";
?>
