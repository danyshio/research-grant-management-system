<?php
$conn = mysqli_connect("localhost", "root", "", "research_grant_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
