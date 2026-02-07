<?php
// admin-dashboard.php
session_start();
require_once 'db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// Get statistics
$users_query = "SELECT COUNT(*) as total FROM user";
$users_result = mysqli_query($conn, $users_query);
$users_row = mysqli_fetch_assoc($users_result);
$users_count = $users_row['total'];

$proposals_query = "SELECT COUNT(*) as total FROM proposal";
$proposals_result = mysqli_query($conn, $proposals_query);
$proposals_row = mysqli_fetch_assoc($proposals_result);
$proposals_count = $proposals_row['total'];

$pending_query = "SELECT COUNT(*) as total FROM proposal WHERE status = 'Pending' OR status = 'Submitted'";
$pending_result = mysqli_query($conn, $pending_query);
$pending_row = mysqli_fetch_assoc($pending_result);
$pending_count = $pending_row['total'];

$approved_query = "SELECT COUNT(*) as total FROM proposal WHERE status = 'Approved'";
$approved_result = mysqli_query($conn, $approved_query);
$approved_row = mysqli_fetch_assoc($approved_result);
$approved_count = $approved_row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Research Grant System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card h3 {
            margin-top: 0;
            color: #333;
        }
        
        .stat-card .number {
            font-size: 2.5em;
            font-weight: bold;
            color: #2c3e50;
            margin: 10px 0;
        }
        
        .admin-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .menu-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: transform 0.3s;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .menu-card h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .menu-card p {
            color: #666;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['name'] ?? 'Admin'; ?>!</p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="number"><?php echo $users_count; ?></div>
                <p>Registered in system</p>
            </div>
            
            <div class="stat-card">
                <h3>Total Proposals</h3>
                <div class="number"><?php echo $proposals_count; ?></div>
                <p>All research proposals</p>
            </div>
            
            <div class="stat-card">
                <h3>Pending Reviews</h3>
                <div class="number"><?php echo $pending_count; ?></div>
                <p>Awaiting review/approval</p>
            </div>
            
            <div class="stat-card">
                <h3>Approved Proposals</h3>
                <div class="number"><?php echo $approved_count; ?></div>
                <p>Successfully approved</p>
            </div>
        </div>
        
        <h2>Administration Menu</h2>
        <div class="admin-menu">
            <a href="admin-users.php" class="menu-card">
                <h3>👥 User Management</h3>
                <p>Add, edit, or remove users from the system</p>
            </a>
            
            <a href="admin-roles.php" class="menu-card">
                <h3>🎭 Role Assignment</h3>
                <p>Assign or change user roles (Researcher, Reviewer, HOD)</p>
            </a>
            
            <a href="admin-budget.php" class="menu-card">
                <h3>💰 Budget Allocation</h3>
                <p>Allocate funds to approved research proposals</p>
            </a>
            
            <a href="admin-reports.php" class="menu-card">
                <h3>📊 System Reports</h3>
                <p>View system analytics and generate reports</p>
            </a>
        </div>
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="logout.php" style="color: #e74c3c; text-decoration: none;">Logout</a>
        </div>
    </div>
</body>
</html>
