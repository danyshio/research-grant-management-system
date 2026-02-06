<?php
session_start();
include("../backend/db.php");

if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}

$userId = $_SESSION['userId'];
$userName = $_SESSION['userName'];

// Total submitted
$total_sql = "SELECT COUNT(*) AS total FROM proposal WHERE userId='$userId'";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total = $total_row['total'];

// Pending (Submitted)
$pending_sql = "SELECT COUNT(*) AS pending FROM proposal 
                WHERE userId='$userId' AND status='Submitted'";
$pending_result = mysqli_query($conn, $pending_sql);
$pending_row = mysqli_fetch_assoc($pending_result);
$pending = $pending_row['pending'];

// Approved
$approved_sql = "SELECT COUNT(*) AS approved FROM proposal 
                 WHERE userId='$userId' AND status='Approved'";
$approved_result = mysqli_query($conn, $approved_sql);
$approved_row = mysqli_fetch_assoc($approved_result);
$approved = $approved_row['approved'];

// Active = Submitted + Under Review
$active_sql = "SELECT COUNT(*) AS active FROM proposal 
               WHERE userId='$userId' 
               AND (status='Submitted' OR status='Pending' OR status='Reviewed')";
$active_result = mysqli_query($conn, $active_sql);
$active_row = mysqli_fetch_assoc($active_result);
$active = $active_row['active'];

// Recent proposals
$recent_sql = "SELECT title, status, submissionDate 
               FROM proposal 
               WHERE userId='$userId'
               ORDER BY proposalId DESC
               LIMIT 5";

$recent_result = mysqli_query($conn, $recent_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Research Grant System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-bars"></i> Research Grant System
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboardresearcher.php" class="active"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="my-proposals.php"><i class="fas fa-folder"></i> My Proposals</a></li>
            <li><a href="submit-new.php"><i class="fas fa-plus"></i> Submit New</a></li>
            <li><a href="notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Researcher Dashboard</h3>
            <div class="user-info">
                <div class="icon-badge">
                    <i class="fas fa-bell" style="font-size: 20px; color: #d97706;"></i>
                    <span class="badge">0</span>
                </div>
                <span><?php echo $userName; ?> <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            <div style="margin-bottom: 25px;">
                <h2>Welcome back, <?php echo $userName; ?>!</h2>
                <p style="color:#666; font-size:14px;">Here's your research grant overview</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card bg-green">
                    <i class="fas fa-clipboard-check"></i>
                    <h1><?php echo $active; ?></h1>
                    <p>Active Proposals</p>
                </div>
                <div class="stat-card bg-yellow">
                    <i class="fas fa-hourglass-half"></i>
                    <h1><?php echo $pending; ?></h1>
                    <p>Pending Reviews</p>
                </div>
                <div class="stat-card bg-red">
                    <i class="fas fa-check-square"></i>
                    <h1><?php echo $approved; ?></h1>
                    <p>Approved</p>
                </div>
                <div class="stat-card bg-purple">
                    <i class="fas fa-chart-line"></i>
                    <h1><?php echo $total; ?></h1>
                    <p>Total Submitted</p>
                </div>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($recent_result)) { ?>
<tr>
    <td>
        <a href="#" style="color:#2563eb;">
            <?php echo $row['title']; ?>
        </a>
    </td>

    <td>
        <span class="status-badge text-gray">
            ● <?php echo $row['status']; ?>
        </span>
    </td>

    <td>
        <?php echo $row['submissionDate']; ?>
    </td>
</tr>
<?php } ?>
</tbody>
                </table>
                <div style="padding: 15px; text-align: right; background: #fafafa;">
                    <a href="my-proposals.php" style="color: #2563eb; font-size: 13px; text-decoration: none;">View All Proposals →</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>