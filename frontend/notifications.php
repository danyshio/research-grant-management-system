<?php
session_start();
include("../backend/db.php");

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
    <title>Notifications - Research Grant System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header"><i class="fas fa-bars"></i> Research Grant System</div>
        <ul class="sidebar-menu">
            <li><a href="dashboardresearcher.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="my-proposals.php"><i class="fas fa-folder"></i> My Proposals</a></li>
            <li><a href="submit-new.php"><i class="fas fa-plus"></i> Submit New</a></li>
            <li><a href="notifications.php" class="active"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
        </ul>
        <div class="sidebar-footer"><a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Notifications</h3>
            <div class="user-info">
                <span>[User Name] <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            
            <div style="background: #374151; color: white; padding: 10px 20px; border-radius: 5px 5px 0 0; display: flex; justify-content: space-between;">
                <span>Notifications (<?php echo mysqli_num_rows($result); ?>)</span>
                <span style="font-size: 13px; cursor: pointer;">Mark All as Read | Filter ▼</span>
            </div>

            <div class="notification-group">
    <h4>Recent</h4>

<?php if(mysqli_num_rows($result) == 0) { ?>
    <p style="padding:20px;">No notifications yet</p>
<?php } else { ?>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

    <div class="notification-card" style="border-left: 4px solid #22c55e;">
        <div class="notif-content">
            <h5 class="text-green">
                <i class="fas fa-check-circle"></i> Notification
            </h5>

            <p><?php echo $row['message']; ?></p>
        </div>

        <div class="notif-meta">
            <span><?php echo $row['dateTime']; ?></span><br>
            <span style="color: <?php echo $row['status']=='Unread' ? 'red' : 'green'; ?>">
                <?php echo $row['status']; ?>
            </span>
        </div>
    </div>

<?php } ?>
<?php } ?>

</div>
    </div>
</div>

</body>
</html>