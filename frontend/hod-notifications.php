<?php
session_start();
include("../backend/db.php");

if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}

$userId = $_SESSION['userId'];

$sql = "SELECT * FROM notification 
        WHERE userId='$userId'
        ORDER BY dateTime DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications - HOD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #16a34a;">
            <i class="fas fa-bars"></i> Research Grant System
        </div>
        <ul class="sidebar-menu">
            <li><a href="hod-dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="hod-decisions.php"><i class="fas fa-gavel"></i> Pending Decisions</a></li>
            <li><a href="hod-history.php"><i class="fas fa-check-double"></i> Approved History</a></li>
            <li><a href="hod-notifications.php" class="active-hod"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Notifications</h3>
            <div class="user-info">
                <span><?php echo $_SESSION['userName'] ?? 'Prof Thash HOD'; ?> <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            
            <div style="background: #16a34a; color: white; padding: 15px 20px; border-radius: 5px 5px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 500;">Notifications (<?php echo mysqli_num_rows($result); ?>)</span>
                <span style="font-size: 13px; cursor: pointer; opacity: 0.9;">Mark All as Read | Filter ▼</span>
            </div>

            <div style="background: white; border: 1px solid #e2e8f0; border-top: none; padding: 20px; border-radius: 0 0 5px 5px; min-height: 500px;">
                
                <h4 style="margin-bottom: 20px; color: #16a34a; font-size: 14px; font-weight: 600;">
                    <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i> Recent
                </h4>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="notification-card" style="border-left: 4px solid #16a34a; margin-bottom: 15px; background: white; border-radius: 4px; padding: 15px; display: flex; justify-content: space-between; align-items: flex-start; border-right: 1px solid #eee; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">

    <div class="notif-content" style="flex: 1;">
        <h5 style="color: #16a34a; font-size: 15px; margin-bottom: 5px; font-weight: 600;">
            Notification
        </h5>

        <p style="color: #666; font-size: 13px; margin: 0;">
            <?php echo $row['message']; ?>
        </p>
    </div>

    <div class="notif-meta" style="text-align: right; margin-left: 20px; min-width: 120px;">
        <span style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 5px;">
            <?php echo $row['dateTime']; ?>
        </span>

        <span style="font-size: 12px; font-weight: 600; color: <?php echo $row['status']=='Unread' ? 'red' : 'green'; ?>">
            <?php echo $row['status']; ?>
        </span>
    </div>

</div>

<?php } ?>
                </div>

        </div>
    </div>
</div>

</body>
</html>