<?php
include("../db.php");

$proposalId = $_POST['proposalId'];
$decision = $_POST['decision'];
$comments = $_POST['comments'];

$sql = "INSERT INTO review (proposalId, decision, comments, reviewDate)
        VALUES ('$proposalId', '$decision', '$comments', CURDATE())";

mysqli_query($conn, $sql);

mysqli_query($conn, "UPDATE proposal SET status='Reviewed' WHERE proposalId='$proposalId'");

echo "Review submitted.";
?>
