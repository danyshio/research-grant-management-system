<?php
session_start();
require_once('../backend/db.php');
require_once('../backend/user-functions.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");

$user = null;
if (isset($_GET['id'])) $user = getUserById($conn, $_GET['id']);
if (!$user) header("Location: admin-users.php");

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - View User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {max-width:600px; margin:0 auto; background:white; padding:30px; border-radius:8px; border:1px solid #e2e8f0;}
        .user-avatar-large {width:80px; height:80px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:bold; color:white; margin:0 auto 20px;}
        .user-info-item {display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #e2e8f0;}
        .user-info-item:last-child {border-bottom:none;}
        .info-label {color:#64748b; font-weight:500;}
        .info-value {font-weight:600; color:#2c3e50;}
        .role-badge {padding:6px 15px; border-radius:20px; font-size:14px; font-weight:600;}
        .status-badge {padding:6px 15px; border-radius:20px; font-size:14px; font-weight:600;}
        .action-buttons {display:flex; gap:15px; margin-top:30px;}
        .back-btn {padding:10px 20px; background:#64748b; color:white; border-radius:5px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;}
        .edit-btn {padding:10px 20px; background:#3b82f6; color:white; border-radius:5px; text-decoration:none; display:inline-flex; align-items:center; gap:8px;}
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="sidebar">
            <div class="sidebar-header">Research Grant System</div>
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
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
            </div>
            
            <div class="scrollable-content">
                <h1 style="margin-bottom:20px;">User Details</h1>
                <p style="color:#64748b; margin-bottom:30px;">View user information</p>
                
                <div class="profile-container">
                    <?php 
                    $first_letter = substr($user['name'],0,1); if(empty($first_letter))$first_letter=substr($user['email'],0,1);
                    $avatar_colors=['Admin'=>'#3b82f6','Researcher'=>'#22c55e','Reviewer'=>'#8b5cf6','HOD'=>'#f59e0b'];
                    $avatar_color=$avatar_colors[$user['role']]??'#64748b';
                    $role_color=['Admin'=>'dbeafe','Researcher'=>'dcfce7','Reviewer'=>'f3e8ff','HOD'=>'fef3c7'];
                    $status_color=['Active'=>'dcfce7','Inactive'=>'fee2e2'];
                    ?>
                    <div class="user-avatar-large" style="background:<?php echo $avatar_color; ?>;"><?php echo strtoupper($first_letter); ?></div>
                    
                    <div style="text-align:center; margin-bottom:30px;">
                        <h2 style="color:#2c3e50; margin-bottom:5px;"><?php echo htmlspecialchars($user['name']); ?></h2>
                        <p style="color:#64748b;"><?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    
                    <div class="user-info-item"><span class="info-label">User ID:</span><span class="info-value">#<?php echo $user['userId']; ?></span></div>
                    <div class="user-info-item"><span class="info-label">Email:</span><span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span></div>
                    <div class="user-info-item"><span class="info-label">Role:</span><span class="role-badge" style="background:#<?php echo $role_color[$user['role']]??'f1f5f9'; ?>; color:inherit;"><?php echo htmlspecialchars($user['role']); ?></span></div>
                    <div class="user-info-item"><span class="info-label">Status:</span><span class="status-badge" style="background:#<?php echo $status_color[$user['status']]??'f1f5f9'; ?>; color:inherit;"><?php echo htmlspecialchars($user['status']); ?></span></div>
                    <div class="user-info-item"><span class="info-label">Account Created:</span><span class="info-value"><?php echo date('d M Y', strtotime($user['created_at'] ?? '2025-01-01')); ?></span></div>
                    
                    <div class="action-buttons">
                        <a href="admin-users.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Users</a>
                        <a href="admin-edit-user.php?id=<?php echo $user['userId']; ?>" class="edit-btn"><i class="fas fa-edit"></i> Edit User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>