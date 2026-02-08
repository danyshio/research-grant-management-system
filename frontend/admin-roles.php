<?php
session_start();
require_once('../backend/db.php');
require_once('../backend/user-functions.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");

$users = getUsers($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $new_role = mysqli_real_escape_string($conn, $_POST['new_role']);
    mysqli_query($conn, "UPDATE user SET role = '$new_role' WHERE userId = '$user_id'");
    header("Location: admin-roles.php?updated=1");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - Role Assignment</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .role-assignment {background:white; padding:25px; border-radius:8px; border:1px solid #e2e8f0; margin-top:20px;}
        .role-item {display:flex; align-items:center; padding:15px; border-bottom:1px solid #e2e8f0;}
        .role-item:last-child {border-bottom:none;}
        .user-details {flex:1;}
        .user-name {font-weight:600; color:#2c3e50;}
        .user-email {color:#64748b; font-size:14px;}
        .current-role {padding:6px 12px; border-radius:20px; font-size:13px; font-weight:600; margin-right:20px; min-width:100px; text-align:center;}
        .role-select {padding:8px 12px; border:1px solid #e2e8f0; border-radius:5px; margin-right:15px; min-width:150px; background:white;}
        .update-btn {padding:8px 16px; background:#3b82f6; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
        .update-btn:hover {background:#2563eb;}
        .bulk-actions {display:flex; gap:15px; margin-top:20px; padding-top:20px; border-top:1px solid #e2e8f0;}
        .save-all-btn {padding:10px 20px; background:#22c55e; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
        .reset-btn {padding:10px 20px; background:#f59e0b; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
        .cancel-btn {padding:10px 20px; background:#64748b; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500; text-decoration:none; display:inline-flex; align-items:center;}
        .success-message {background:#dcfce7; color:#166534; padding:12px; border-radius:5px; margin-bottom:20px; border:1px solid #bbf7d0;}
        .role-admin {background:#dbeafe; color:#1e40af;}
        .role-researcher {background:#dcfce7; color:#166534;}
        .role-reviewer {background:#f3e8ff; color:#6b21a8;}
        .role-hod {background:#fef3c7; color:#92400e;}
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="sidebar">
            <div class="sidebar-header">Research Grant System</div>
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
                <li><a href="admin-users.php"><i class="fas fa-users"></i> User Management</a></li>
                <li><a href="admin-roles.php" class="active"><i class="fas fa-user-tag"></i> Role Assignment</a></li>
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
                <h1 style="margin-bottom:20px;">Role Assignment</h1>
                <p style="color:#64748b; margin-bottom:30px;">Assign roles to system users</p>
                
                <?php if (isset($_GET['updated'])): ?><div class="success-message">✓ Role updated successfully!</div><?php endif; ?>
                
                <div class="role-assignment">
                    <?php foreach ($users as $user): ?>
                    <form method="POST" class="role-item">
                        <div class="user-details">
                            <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                            <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                        
                        <span class="current-role role-<?php echo strtolower($user['role']); ?>">
                            <?php echo htmlspecialchars($user['role']); ?>
                        </span>
                        
                        <input type="hidden" name="user_id" value="<?php echo $user['userId']; ?>">
                        
                        <select name="new_role" class="role-select">
                            <option value="Researcher" <?php echo $user['role'] == 'Researcher' ? 'selected' : ''; ?>>Researcher</option>
                            <option value="Reviewer" <?php echo $user['role'] == 'Reviewer' ? 'selected' : ''; ?>>Reviewer</option>
                            <option value="HOD" <?php echo $user['role'] == 'HOD' ? 'selected' : ''; ?>>HOD</option>
                            <option value="Admin" <?php echo $user['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        
                        <button type="submit" name="update_role" class="update-btn">Update</button>
                    </form>
                    <?php endforeach; ?>
                </div>
                
                <div class="bulk-actions">
                    <a href="admin-users.php" class="cancel-btn"><i class="fas fa-arrow-left"></i> Back to Users</a>
                    <div style="flex:1;"></div>
                    <button class="reset-btn" onclick="resetAllRoles()"><i class="fas fa-undo"></i> Reset All to Default</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function resetAllRoles() {
            if (confirm('Reset all roles to their original values?')) {
                window.location.reload();
            }
        }
    </script>
</body>
</html>
