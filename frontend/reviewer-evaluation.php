<?php
session_start();
include("../backend/db.php");

if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: reviewer-dashboard.php");
    exit();
}

$proposalId = $_GET['id'];

$sql = "SELECT * FROM proposal WHERE proposalID='$proposalId'";
$result = mysqli_query($conn, $sql);
$proposal = mysqli_fetch_assoc($result);


if(!$proposal){
    echo "Proposal not found.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Review Proposal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="padding:40px;">
    <h2>Review Proposal</h2>

    <h3><?php echo $proposal['title']; ?></h3>
    <p><?php echo $proposal['abstract']; ?></p>

    <form action="../backend/submit_review.php" method="POST">
        <input type="hidden" name="proposalId" value="<?php echo $proposalId; ?>">

        <label>Decision:</label><br>
        <select name="decision" required>
            <option value="Approve">Approve</option>
            <option value="Reject">Reject</option>
            <option value="Request Changes">Request Changes</option>
        </select><br><br>

        <label>Comments:</label><br>
        <textarea name="comments" rows="5" cols="50" required></textarea><br><br>

        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>