<?php
session_start();
require_once('../backend/db.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");

$stats = ['users' => 0, 'proposals' => 0, 'pending' => 0, 'approved' => 0];

$sql = "SELECT COUNT(*) as count FROM user WHERE name != ''";
$result = mysqli_query($conn, $sql);
if ($result) $stats['users'] = mysqli_fetch_assoc($result)['count'];

$check_table = "SHOW TABLES LIKE 'proposal'";
if (mysqli_query($conn, $check_table) && mysqli_num_rows(mysqli_query($conn, $check_table)) > 0) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM proposal");
    if ($result) $stats['proposals'] = mysqli_fetch_assoc($result)['count'];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM proposal WHERE status = 'pending'");
    if ($result) $stats['pending'] = mysqli_fetch_assoc($result)['count'];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM proposal WHERE status = 'approved'");
    if ($result) $stats['approved'] = mysqli_fetch_assoc($result)['count'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-menu {display: grid; grid-template-columns: repeat(2,1fr); gap:20px; margin-top:20px;}
        .menu-card {background:white; padding:25px; border-radius:8px; border:1px solid #e2e8f0; text-decoration:none; color:#333; transition:all 0.3s;}
        .menu-card:hover {box-shadow:0 5px 15px rgba(0,0,0,0.1);}
        .menu-card h3 {color:#3b82f6; margin-bottom:10px; font-size:18px;}
        .menu-card p {color:#64748b; font-size:14px;}
        .quick-actions {background:white; padding:20px; border-radius:8px; border:1px solid #e2e8f0; margin-top:30px;}
        .action-buttons {display:flex; gap:15px; margin-top:15px;}
        .action-btn {padding:10px 20px; background:#3b82f6; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500; text-decoration:none; display:inline-block;}
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="sidebar">
            <div class="sidebar-header">Research Grant System</div>
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
                <li><a href="admin-users.php"><i class="fas fa-users"></i> User Management</a></li>
                <li><a href="admin-roles.php"><i class="fas fa-user-tag"></i> Role Assignment</a></li>
                <li><a href="admin-budget.php"><i class="fas fa-money-bill-wave"></i> Budget Allocation</a></li>
                <li><a href="admin-reports.php"><i class="fas fa-chart-bar"></i> System Reports</a></li>
            </ul>
            <div class="sidebar-footer"><a href="../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
        </div>
        
        <div class="content">
            <div class="top-bar">
                <div class="user-info">
                    <span>Welcome, <strong><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Admin'; ?></strong></span>
                    <span style="color:#64748b;">Admin</span>
                </div>
                <div style="display:flex; gap:20px;">
                    <div class="icon-badge"><i class="fas fa-bell"></i><span class="badge">3</span></div>
                </div>
            </div>
            
            <div class="scrollable-content">
                <h1 style="margin-bottom:20px;">Admin Dashboard</h1>
                <div class="stats-grid">
                    <div class="stat-card bg-green"><i class="fas fa-users"></i><h1><?php echo $stats['users']; ?></h1><p>Total Users</p></div>
                    <div class="stat-card bg-yellow"><i class="fas fa-file-alt"></i><h1><?php echo $stats['proposals']; ?></h1><p>Total Proposals</p></div>
                    <div class="stat-card bg-red"><i class="fas fa-clock"></i><h1><?php echo $stats['pending']; ?></h1><p>Pending Reviews</p></div>
                    <div class="stat-card bg-purple"><i class="fas fa-check-circle"></i><h1><?php echo $stats['approved']; ?></h1><p>Approved Proposals</p></div>
                </div>
                
                <h2 style="margin:30px 0 15px;">Administration Menu</h2>
                <div class="admin-menu">
                    <a href="admin-users.php" class="menu-card"><h3>👤 User Management</h3><p>Manage user accounts, add new users, update user information</p></a>
                    <a href="admin-roles.php" class="menu-card"><h3>🎭 Role Assignment</h3><p>Assign roles to users (Researcher, Reviewer, HOD)</p></a>
                    <a href="admin-budget.php" class="menu-card"><h3>💰 Budget Allocation</h3><p>Allocate budgets to approved proposals</p></a>
                    <a href="admin-reports.php" class="menu-card"><h3>📊 System Reports</h3><p>Generate reports and view system analytics</p></a>
                </div>
                
                <div class="quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="action-buttons">
                        <a href="admin-add-user.php" class="action-btn"><i class="fas fa-user-plus"></i> Add New User</a>
                        <a href="#" class="action-btn" style="background:#22c55e;"><i class="fas fa-file-alt"></i> View All Proposals</a>
                        <a href="#" class="action-btn" style="background:#8b5cf6;"><i class="fas fa-cog"></i> System Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
