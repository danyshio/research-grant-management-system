<?php
session_start();
require_once('../backend/db.php');
require_once('../backend/user-functions.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");

$users = getUsers($conn);
$role_counts = ['Admin' => 0, 'Researcher' => 0, 'Reviewer' => 0, 'HOD' => 0, 'Inactive' => 0];
foreach ($users as $user) {
    if (isset($role_counts[$user['role']])) $role_counts[$user['role']]++;
    if ($user['status'] === 'Inactive') $role_counts['Inactive']++;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - User Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .user-stats {display:grid; grid-template-columns:repeat(5,1fr); gap:15px; margin-bottom:30px;}
        .user-stat {background:white; padding:15px; border-radius:8px; border:1px solid #e2e8f0; text-align:center;}
        .user-stat-number {font-size:1.5em; font-weight:bold; color:#2c3e50; margin:5px 0;}
        .user-stat-label {color:#64748b; font-size:12px;}
        .action-bar {background:white; padding:15px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;}
        .search-box {display:flex; gap:10px;}
        .search-input {padding:8px 12px; border:1px solid #ddd; border-radius:5px; width:250px;}
        .search-btn {padding:8px 16px; background:#3b82f6; color:white; border:none; border-radius:5px; cursor:pointer;}
        .add-btn {padding:8px 16px; background:#22c55e; color:white; border-radius:5px; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:14px;}
        .table-container {background:white; border-radius:8px; border:1px solid #e2e8f0; overflow:hidden;}
        .users-table {width:100%; border-collapse:collapse;}
        .users-table th {background:#f8fafc; padding:15px; text-align:left; color:#64748b; font-weight:600; font-size:14px; border-bottom:2px solid #e2e8f0;}
        .users-table td {padding:15px; border-bottom:1px solid #f1f5f9;}
        .users-table tr:hover {background:#f8fafc;}
        .user-info {display:flex; align-items:center; gap:12px;}
        .user-avatar {width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:14px; color:white;}
        .user-details {display:flex; flex-direction:column;}
        .user-name {font-weight:600; color:#2c3e50; font-size:14px;}
        .user-email {color:#64748b; font-size:12px;}
        .user-role {padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; text-align:center; display:inline-block; min-width:85px;}
        .role-admin {background:#dbeafe; color:#1e40af;}
        .role-researcher {background:#dcfce7; color:#166534;}
        .role-reviewer {background:#f3e8ff; color:#6b21a8;}
        .role-hod {background:#fef3c7; color:#92400e;}
        .user-status {padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; text-align:center; display:inline-block; min-width:75px;}
        .status-active {background:#dcfce7; color:#166534;}
        .status-inactive {background:#fee2e2; color:#991b1b;}
        .user-actions {display:flex; gap:8px;}
        .action-icon {padding:7px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:5px; text-decoration:none; color:#64748b; font-size:13px; display:inline-flex; align-items:center; justify-content:center;}
        .action-icon:hover {background:#f1f5f9;}
        .success-message {background:#dcfce7; color:#166534; padding:12px; border-radius:5px; margin-bottom:20px; border:1px solid #bbf7d0;}
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="sidebar">
            <div class="sidebar-header">Research Grant System</div>
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a></li>
                <li><a href="admin-users.php" class="active"><i class="fas fa-users"></i> User Management</a></li>
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
                <h1 style="margin-bottom:20px;">User Management</h1>
                <p style="color:#64748b; margin-bottom:30px;">Manage system user accounts</p>
                
                <?php if (isset($_GET['added'])): ?><div class="success-message">✓ User added successfully!</div><?php endif; ?>
                <?php if (isset($_GET['deleted'])): ?><div class="success-message">✓ User deleted successfully!</div><?php endif; ?>
                <?php if (isset($_GET['updated'])): ?><div class="success-message">✓ User updated successfully!</div><?php endif; ?>
                
                <div class="user-stats">
                    <div class="user-stat"><div class="user-stat-number"><?php echo count($users); ?></div><div class="user-stat-label">Total Users</div></div>
                    <div class="user-stat"><div class="user-stat-number"><?php echo $role_counts['Admin']; ?></div><div class="user-stat-label">Admins</div></div>
                    <div class="user-stat"><div class="user-stat-number"><?php echo $role_counts['Researcher']; ?></div><div class="user-stat-label">Researchers</div></div>
                    <div class="user-stat"><div class="user-stat-number"><?php echo $role_counts['Reviewer']; ?></div><div class="user-stat-label">Reviewers</div></div>
                    <div class="user-stat"><div class="user-stat-number"><?php echo $role_counts['Inactive']; ?></div><div class="user-stat-label">Inactive</div></div>
                </div>
                
                <div class="action-bar">
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="Search users...">
                        <button class="search-btn"><i class="fas fa-search"></i> Search</button>
                    </div>
                    <a href="admin-add-user.php" class="add-btn"><i class="fas fa-user-plus"></i> Add New User</a>
                </div>
                
                <div class="table-container">
                    <table class="users-table">
                        <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                            <tr><td colspan="5" style="text-align:center; padding:30px; color:#64748b;">No users found. <a href="admin-add-user.php">Add a new user</a></td></tr>
                            <?php else: foreach ($users as $user): 
                                $first_letter = substr($user['name'],0,1); if(empty($first_letter))$first_letter=substr($user['email'],0,1); if(empty($first_letter))$first_letter='U';
                                $avatar_colors=['Admin'=>'#3b82f6','Researcher'=>'#22c55e','Reviewer'=>'#8b5cf6','HOD'=>'#f59e0b'];
                                $avatar_color=$avatar_colors[$user['role']]??'#64748b';
                            ?>
                            <tr>
                                <td><div class="user-info"><div class="user-avatar" style="background:<?php echo $avatar_color; ?>;"><?php echo strtoupper($first_letter); ?></div><div class="user-details"><div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div><div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div></div></div></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><span class="user-role role-<?php echo strtolower($user['role']); ?>"><?php echo htmlspecialchars($user['role']); ?></span></td>
                                <td><span class="user-status status-<?php echo strtolower($user['status']); ?>"><?php echo htmlspecialchars($user['status']); ?></span></td>
                                <td><div class="user-actions">
                                    <a href="admin-edit-user.php?id=<?php echo $user['userId']; ?>" class="action-icon" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="admin-view-user.php?id=<?php echo $user['userId']; ?>" class="action-icon" title="View"><i class="fas fa-eye"></i></a>
                                    <?php if($user['email']!='admin@uni.edu'): ?>
                                    <a href="admin-delete-user.php?id=<?php echo $user['userId']; ?>" class="action-icon" title="Delete" onclick="return confirm('Delete <?php echo addslashes($user['name']); ?>?')"><i class="fas fa-trash"></i></a>
                                    <?php endif; ?>
                                </div></td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelector('.search-input').addEventListener('keyup',function(e){
            const searchTerm=e.target.value.toLowerCase();
            document.querySelectorAll('.users-table tbody tr').forEach(row=>{
                if(row.querySelector('td[colspan]'))return;
                const userName=row.querySelector('.user-name').textContent.toLowerCase();
                const userEmail=row.querySelectorAll('td')[1].textContent.toLowerCase();
                row.style.display=(userName.includes(searchTerm)||userEmail.includes(searchTerm))?'':'none';
            });
        });
    </script>
</body>
</html>
