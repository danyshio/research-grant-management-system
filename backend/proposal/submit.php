<?php
include("../db.php");

$userId = $_POST['userId'];
$title = $_POST['title'];
$abstract = $_POST['abstract'];

$sql = "INSERT INTO proposal (userId, title, abstract, submissionDate, status)
        VALUES ('$userId', '$title', '$abstract', CURDATE(), 'Submitted')";

if (mysqli_query($conn, $sql)) {
    echo "Proposal submitted successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
