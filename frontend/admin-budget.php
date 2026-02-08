<?php
session_start();
require_once('../backend/db.php');

if (!isset($_SESSION['user_id'])) header("Location: ../index.html");
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - Budget Allocation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .budget-summary {background:white; padding:25px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:30px;}
        .summary-grid {display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:20px;}
        .summary-item {text-align:center;}
        .summary-amount {font-size:2em; font-weight:bold; color:#2c3e50; margin:10px 0;}
        .summary-label {color:#64748b; font-size:14px;}
        .budget-table {width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden; border:1px solid #e2e8f0;}
        .budget-table th {background:#f8fafc; padding:15px 20px; text-align:left; color:#64748b; font-weight:600; border-bottom:2px solid #e2e8f0;}
        .budget-table td {padding:15px 20px; border-bottom:1px solid #e2e8f0;}
        .budget-table tr:hover {background:#f8fafc;}
        .amount {font-weight:bold; color:#2c3e50;}
        .allocate-btn {padding:6px 12px; background:#3b82f6; color:white; border:none; border-radius:4px; cursor:pointer; font-size:14px;}
        .action-buttons {margin-top:30px; display:flex; gap:15px;}
        .export-btn {padding:10px 20px; background:#22c55e; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
        .reset-btn {padding:10px 20px; background:#f59e0b; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
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
                <li><a href="admin-budget.php" class="active"><i class="fas fa-money-bill-wave"></i> Budget Allocation</a></li>
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
                <h1 style="margin-bottom:20px;">Budget Allocation</h1>
                <p style="color:#64748b; margin-bottom:30px;">Manage grant funds and allocations</p>
                
                <div class="budget-summary">
                    <h3 style="color:#2c3e50; margin-bottom:20px;">Budget Overview</h3>
                    <div class="summary-grid">
                        <div class="summary-item"><div class="summary-amount">RM 500,000</div><div class="summary-label">Total Budget</div></div>
                        <div class="summary-item"><div class="summary-amount" style="color:#22c55e;">RM 120,000</div><div class="summary-label">Allocated</div></div>
                        <div class="summary-item"><div class="summary-amount" style="color:#3b82f6;">RM 380,000</div><div class="summary-label">Remaining</div></div>
                    </div>
                </div>
                
                <div style="margin-top:30px;">
                    <h3 style="margin-bottom:20px; color:#2c3e50;">Proposal Budget Allocation</h3>
                    <table class="budget-table">
                        <thead><tr><th>Proposal</th><th>Researcher</th><th>Requested</th><th>Allocated</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            <tr><td>AI-Based Flood Prediction System</td><td>John Researcher</td><td class="amount">RM 50,000</td><td class="amount" style="color:#22c55e;">RM 50,000</td><td style="color:#22c55e; font-weight:600;">Approved</td><td><button class="allocate-btn" onclick="modifyBudget(1)">Modify</button></td></tr>
                            <tr><td>AI Cancer Detection</td><td>Jane Researcher</td><td class="amount">RM 75,000</td><td class="amount" style="color:#f59e0b;">RM 70,000</td><td style="color:#f59e0b; font-weight:600;">Partial</td><td><button class="allocate-btn" onclick="modifyBudget(2)">Modify</button></td></tr>
                            <tr><td>Renewable Energy Research</td><td>Mike Researcher</td><td class="amount">RM 30,000</td><td class="amount" style="color:#ef4444;">RM 0</td><td style="color:#ef4444; font-weight:600;">Pending</td><td><button class="allocate-btn" onclick="allocateBudget(3)">Allocate</button></td></tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="action-buttons">
                    <button class="export-btn" onclick="exportBudget()"><i class="fas fa-file-export"></i> Export Budget Report</button>
                    <button class="reset-btn" onclick="resetAllocations()"><i class="fas fa-undo"></i> Reset Allocations</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function allocateBudget(id) {alert('Allocate budget for proposal ID: ' + id);}
        function modifyBudget(id) {alert('Modify budget for proposal ID: ' + id);}
        function exportBudget() {alert('Exporting budget report...');}
        function resetAllocations() {if(confirm('Reset all budget allocations?')) alert('Budget allocations reset.');}
    </script>
</body>
</html>
