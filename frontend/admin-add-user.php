<?php
session_start();
require_once('../backend/db.php');
require_once('../backend/user-functions.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");

$error = ''; $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? ''; $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? ''; $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? ''; $status = $_POST['status'] ?? 'Active';
    
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 5) {
        $error = "Password must be at least 5 characters!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $check_sql = "SELECT * FROM user WHERE email = '$email'";
        if (mysqli_num_rows(mysqli_query($conn, $check_sql)) > 0) {
            $error = "Email already exists!";
        } else {
            if (addNewUser($conn, $name, $email, $password, $role, $status)) {
                header("Location: admin-users.php?added=1");
                exit();
            } else {
                $error = "Error adding user: " . mysqli_error($conn);
            }
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - Add User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {max-width:600px; margin:0 auto; background:white; padding:30px; border-radius:8px; border:1px solid #e2e8f0;}
        .form-group {margin-bottom:20px;}
        .form-label {display:block; margin-bottom:8px; color:#2c3e50; font-weight:500;}
        .form-input {width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:5px; font-size:14px;}
        .form-select {width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:5px; font-size:14px; background:white;}
        .form-actions {display:flex; gap:15px; margin-top:30px;}
        .submit-btn {padding:10px 20px; background:#22c55e; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
        .cancel-btn {padding:10px 20px; background:#64748b; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500; text-decoration:none; display:inline-flex; align-items:center;}
        .error-message {background:#fee2e2; color:#dc2626; padding:12px; border-radius:5px; margin-bottom:20px; border:1px solid #fca5a5;}
        .success-message {background:#dcfce7; color:#166534; padding:12px; border-radius:5px; margin-bottom:20px; border:1px solid #bbf7d0;}
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
                <h1 style="margin-bottom:20px;">Add New User</h1>
                <p style="color:#64748b; margin-bottom:30px;">Add a new user to the system</p>
                
                <?php if (!empty($error)): ?><div class="error-message"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
                
                <div class="form-container">
                    <form method="POST" action="">
                        <div class="form-group"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-input" value="<?php echo isset($_POST['name'])?htmlspecialchars($_POST['name']):''; ?>" placeholder="Enter full name" required></div>
                        <div class="form-group"><label class="form-label">Email Address *</label><input type="email" name="email" class="form-input" value="<?php echo isset($_POST['email'])?htmlspecialchars($_POST['email']):''; ?>" placeholder="Enter email address" required></div>
                        <div class="form-group"><label class="form-label">Password *</label><input type="password" name="password" class="form-input" placeholder="Enter password" required><small style="color:#64748b; font-size:12px;">Minimum 5 characters</small></div>
                        <div class="form-group"><label class="form-label">Confirm Password *</label><input type="password" name="confirm_password" class="form-input" placeholder="Confirm password" required></div>
                        <div class="form-group"><label class="form-label">Role *</label><select name="role" class="form-select" required><option value="">Select Role</option><option value="Researcher" <?php echo (isset($_POST['role'])&&$_POST['role']=='Researcher')?'selected':''; ?>>Researcher</option><option value="Reviewer" <?php echo (isset($_POST['role'])&&$_POST['role']=='Reviewer')?'selected':''; ?>>Reviewer</option><option value="HOD" <?php echo (isset($_POST['role'])&&$_POST['role']=='HOD')?'selected':''; ?>>HOD</option><option value="Admin" <?php echo (isset($_POST['role'])&&$_POST['role']=='Admin')?'selected':''; ?>>Admin</option></select></div>
                        <div class="form-group"><label class="form-label">Status *</label><select name="status" class="form-select" required><option value="Active" <?php echo (isset($_POST['status'])&&$_POST['status']=='Active')?'selected':'selected'; ?>>Active</option><option value="Inactive" <?php echo (isset($_POST['status'])&&$_POST['status']=='Inactive')?'selected':''; ?>>Inactive</option></select></div>
                        <div class="form-actions"><button type="submit" class="submit-btn"><i class="fas fa-save"></i> Add User</button><a href="admin-users.php" class="cancel-btn"><i class="fas fa-times"></i> Cancel</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>