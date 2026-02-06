<?php
include("db.php");

$title = $_POST['proposal_title'];
$area = $_POST['research_area'];
$abstract = $_POST['abstract'];
$amount = $_POST['amount'];
$duration = $_POST['duration'];

$userId = 1; // temp test user

$sql = "INSERT INTO proposal (userId, title, abstract, submissionDate, status)
        VALUES ('$userId', '$title', '$abstract', NOW(), 'Submitted')";

mysqli_query($conn, $sql);

echo "Proposal submitted successfully!";
?>