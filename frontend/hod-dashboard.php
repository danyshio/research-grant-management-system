<?php
session_start();
include("../backend/db.php");

$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM proposal WHERE status='Reviewed'"))['total'];

$approved = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM proposal WHERE status='Approved'"))['total'];

$rejected = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM proposal WHERE status='Rejected'"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOD Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #16a34a;">
            <i class="fas fa-bars"></i> Research Grant System
        </div>
        <ul class="sidebar-menu">
            <li><a href="hod-dashboard.php" class="active-hod"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="hod-decisions.php"><i class="fas fa-gavel"></i> Pending Decisions</a></li>
            <li><a href="hod-history.php"><i class="fas fa-check-double"></i> Approved History</a></li>
            <li><a href="hod-notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Welcome, Prof Thash</h3>
            <div class="user-info">
                <span><?php echo $_SESSION ['userName'] ?? 'Prof Thash HOD'; ?> <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            
            <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                
                <div class="stat-card" style="background-color: #f59e0b; color: white;">
                    <i class="fas fa-balance-scale" style="color: rgba(255,255,255,0.5);"></i>
                    <h1 style="font-size: 48px;"><?php echo $total; ?></h1>
                    <p>Pending Decisions</p>
                </div>

                <div class="stat-card" style="background-color: #10b981; color: white;">
                    <i class="fas fa-check-square" style="color: rgba(255,255,255,0.5);"></i>
                    <h1 style="font-size: 48px;"><?php echo $approved; ?></h1>
                    <p>Monthly Approvals</p>
                </div>

                <div class="stat-card" style="background-color: #3b82f6; color: white;">
                    <i class="fas fa-coins" style="color: rgba(255,255,255,0.5);"></i>
                    <h1 style="font-size: 48px;"><?php echo $rejected; ?></h1>
                    <p>Rejected</p>
                </div>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Proposal Title</th>
                            <th>Reviewer(s)</th>
                            <th>Avg Score</th>
                            <th>Review Status</th>
                            <th>Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>[Proposal Title]</td>
                            <td>[Reviewer Name]</td>
                            <td style="color:#d97706; font-weight:bold;">[Score]/10</td>
                            <td><span class="status-badge text-green"><i class="fas fa-check-circle"></i> Reviews Complete</span></td>
                            <td>
                                <a href="hod-decisions.php" style="color:#16a34a; font-weight:600;">
        Review →
    </a>

                            </td>
                        </tr>
                        </tbody>
                </table>
                <div style="padding: 15px; text-align: right; background: #fafafa;">
                    <a href="hod-decisions.php" style="color: #16a34a; font-size: 13px; text-decoration: none;">View All Pending →</a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>