<?php
session_start();
include("../backend/db.php");

if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}

$userId = $_SESSION['userId'];
$userName = $_SESSION['userName'];
?>

<?php

// Total proposals waiting review
$pending_sql = "SELECT COUNT(*) AS pending FROM proposal WHERE status='Submitted'";
$pending_result = mysqli_query($conn, $pending_sql);
$pending_row = mysqli_fetch_assoc($pending_result);
$pending = $pending_row['pending'];

// Approved
$approved_sql = "SELECT COUNT(*) AS approved FROM proposal WHERE status='Approved'";
$approved_result = mysqli_query($conn, $approved_sql);
$approved_row = mysqli_fetch_assoc($approved_result);
$approved = $approved_row['approved'];

// Rejected
$rejected_sql = "SELECT COUNT(*) AS rejected FROM proposal WHERE status='Rejected'";
$rejected_result = mysqli_query($conn, $rejected_sql);
$rejected_row = mysqli_fetch_assoc($rejected_result);
$rejected = $rejected_row['rejected'];

$proposal_sql = "SELECT proposalID, title, submissionDate, status
                 FROM proposal 
                 WHERE status='Submitted'
                 ORDER BY proposalID DESC";

$proposal_result = mysqli_query($conn, $proposal_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Reviewer</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #7c3aed;">
            <i class="fas fa-bars"></i> Research Grant System
        </div>
        <ul class="sidebar-menu">
            <li><a href="reviewer-dashboard.php" class="active-reviewer"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="reviewer-assigned.php"><i class="fas fa-clipboard-list"></i> Assigned Reviews</a></li>
            <li><a href="reviewer-history.php"><i class="fas fa-history"></i> Review History</a></li>
            <li><a href="reviewer-notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3 class="text-purple">Welcome, <?php echo $userName; ?></h3>
            <div class="user-info">
                <span>Reviewer <?php echo $userName; ?> <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            
            <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                
                <div class="stat-card" style="background-color: #8b5cf6; color: white;">
                    <i class="fas fa-clipboard" style="color: rgba(255,255,255,0.5);"></i>
                    <h1><?php echo $pending; ?></h1>
                    <p>Pending</p>
                </div>

                <div class="stat-card" style="background-color: #10b981; color: white;">
                    <i class="fas fa-check-circle" style="color: rgba(255,255,255,0.5);"></i>
                    <h1><?php echo $approved; ?></h1>
                    <p>Approved</p>
                </div>

                <div class="stat-card" style="background-color: #3b82f6; color: white;">
                    <i class="fas fa-stopwatch" style="color: rgba(255,255,255,0.5);"></i>
                    <h1><?php echo $rejected; ?></h1>
                    <p>Rejected</p>
                </div>
            </div>

            <div class="table-container">
                <table class="custom-table">

                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Submitted</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
</tr>
                    </thead>
                    
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($proposal_result)) { ?>
<tr>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['submissionDate']; ?></td>
    <td>-</td>
    <td><?php echo $row['status']; ?></td>
    <td>
        <a href="../backend/approve_proposal.php?id=<?php echo $row['proposalID']; ?>" style="color:green;">Approve</a>
        |
        <a href="../backend/reject_proposal.php?id=<?php echo $row['proposalID']; ?>" style="color:red;">Reject</a>

    </td>

</tr>
<?php } ?>

                        </tbody>
                </table>
                <div style="padding: 15px; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                    <span style="font-size: 13px; color: #666;">Actions:</span>
                    <div style="gap: 10px; display: flex;">
                        <a href="reviewer-evaluation.php?id=<?php echo $row['proposalId']; ?>">StartReview</a>
                        <span style="color:#ddd;">|</span>
                        <a href="reviewer-assigned.html" style="color:#666;">View All Assigned</a>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px; background: #f3e8ff; padding: 20px; border-radius: 8px; border: 1px solid #d8b4fe; width: 50%;">
                <h5 style="color: #6b21a8; margin-bottom: 10px;"><i class="fas fa-book"></i> Review Guidelines</h5>
                <ul style="font-size: 13px; color: #581c87; margin-left: 20px; line-height: 1.6;">
                    <li>Score: 1-10 (10=Excellent)</li>
                    <li>Provide constructive feedback</li>
                    <li>Submit within 14 days of assignment</li>
                    <li>Flag conflicts of interest immediately</li>
                </ul>
            </div>

        </div>
    </div>
</div>

</body>
</html>