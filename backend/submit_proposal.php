<?php
session_start();
include("db.php");

$title = $_POST['proposal_title'];
$area = $_POST['research_area'];
$abstract = $_POST['abstract'];
$amount = $_POST['amount'];
$duration = $_POST['duration'];

$userId = $_SESSION['userId']; 


$pdfName = $_FILES['pdf_file']['name'];
$tmpName = $_FILES['pdf_file']['tmp_name'];

$uploadPath = "../uploads/" . $pdfName;
move_uploaded_file($tmpName, $uploadPath);

$sql = "INSERT INTO proposal (userId, title, abstract, submissionDate, status, pdfFile)
VALUES ('$userId', '$title', '$abstract', NOW(), 'Submitted', '$pdfName')";

mysqli_query($conn, $sql);

echo "Proposal submitted successfully!";
?>