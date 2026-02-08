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
    <title>Research Grant System - System Reports</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .report-filters {background:white; padding:20px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:30px;}
        .filter-row {display:flex; gap:20px; align-items:flex-end;}
        .filter-group {display:flex; flex-direction:column;}
        .filter-label {margin-bottom:5px; color:#64748b; font-size:14px;}
        .filter-input {padding:10px; border:1px solid #e2e8f0; border-radius:5px; min-width:200px;}
        .generate-btn {padding:10px 20px; background:#3b82f6; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500;}
        .reports-grid {display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-top:20px;}
        .report-card {background:white; padding:25px; border-radius:8px; border:1px solid #e2e8f0;}
        .report-card h3 {color:#2c3e50; margin-bottom:15px; display:flex; align-items:center; gap:10px;}
        .report-card p {color:#64748b; margin-bottom:20px; font-size:14px;}
        .report-stats {background:#f8fafc; padding:15px; border-radius:6px; margin-bottom:20px;}
        .stat-item {display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #e2e8f0;}
        .stat-item:last-child {border-bottom:none;}
        .download-btn {padding:8px 16px; background:#22c55e; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:500; display:inline-flex; align-items:center; gap:8px;}
        .report-history {background:white; padding:25px; border-radius:8px; border:1px solid #e2e8f0; margin-top:30px;}
        .history-table {width:100%; border-collapse:collapse; margin-top:20px;}
        .history-table th {background:#f8fafc; padding:12px 15px; text-align:left; color:#64748b; font-weight:600; border-bottom:2px solid #e2e8f0;}
        .history-table td {padding:12px 15px; border-bottom:1px solid #e2e8f0;}
        .view-btn {padding:6px 12px; background:#3b82f6; color:white; border:none; border-radius:4px; cursor:pointer; font-size:14px;}
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
                <li><a href="admin-reports.php" class="active"><i class="fas fa-chart-bar"></i> System Reports</a></li>
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
                <h1 style="margin-bottom:20px;">System Reports</h1>
                <p style="color:#64748b; margin-bottom:30px;">Generate and view system analytics</p>
                
                <div class="report-filters">
                    <h3 style="color:#2c3e50; margin-bottom:20px;">Generate Custom Report</h3>
                    <div class="filter-row">
                        <div class="filter-group"><label class="filter-label">Start Date</label><input type="date" class="filter-input"></div>
                        <div class="filter-group"><label class="filter-label">End Date</label><input type="date" class="filter-input"></div>
                        <div class="filter-group"><label class="filter-label">Report Type</label><select class="filter-input"><option>All Reports</option><option>User Activity</option><option>Budget Utilization</option><option>Proposal Statistics</option><option>Performance Metrics</option></select></div>
                        <button class="generate-btn" onclick="generateReport()"><i class="fas fa-chart-line"></i> Generate Report</button>
                    </div>
                </div>
                
                <h3 style="color:#2c3e50; margin-bottom:20px;">Available Reports</h3>
                <div class="reports-grid">
                    <div class="report-card">
                        <h3><i class="fas fa-users"></i> User Activity Report</h3>
                        <p>Shows login frequency and user engagement metrics</p>
                        <div class="report-stats">
                            <div class="stat-item"><span>Active Users:</span><strong>142</strong></div>
                            <div class="stat-item"><span>New Users (30 days):</span><strong>5</strong></div>
                            <div class="stat-item"><span>Total Users:</span><strong>147</strong></div>
                        </div>
                        <button class="download-btn" onclick="downloadReport('user-activity')"><i class="fas fa-download"></i> Download PDF</button>
                    </div>
                    
                    <div class="report-card">
                        <h3><i class="fas fa-file-alt"></i> Proposal Statistics</h3>
                        <p>Comprehensive proposal submission and approval metrics</p>
                        <div class="report-stats">
                            <div class="stat-item"><span>Total Proposals:</span><strong>47</strong></div>
                            <div class="stat-item"><span>Approved:</span><strong>32</strong></div>
                            <div class="stat-item"><span>Pending:</span><strong>8</strong></div>
                            <div class="stat-item"><span>Rejected:</span><strong>7</strong></div>
                        </div>
                        <button class="download-btn" onclick="downloadReport('proposal')"><i class="fas fa-download"></i> Download CSV</button>
                    </div>
                </div>
                
                <div class="report-history">
                    <h3 style="color:#2c3e50; margin-bottom:20px;">Report Generation History</h3>
                    <table class="history-table">
                        <thead><tr><th>Report Name</th><th>Generated On</th><th>Format</th><th>Size</th><th>Action</th></tr></thead>
                        <tbody>
                            <tr><td>Monthly Summary - Jan 2026</td><td>2026-02-01</td><td>PDF</td><td>2.4 MB</td><td><button class="view-btn" onclick="viewReport(1)">View</button></td></tr>
                            <tr><td>User Activity - Dec 2025</td><td>2026-01-05</td><td>CSV</td><td>3.1 MB</td><td><button class="view-btn" onclick="viewReport(3)">View</button></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function generateReport() {
            const startDate = document.querySelector('input[type="date"]:first-child').value;
            const endDate = document.querySelectorAll('input[type="date"]')[1].value;
            if (!startDate || !endDate) {alert('Please select both start and end dates'); return;}
            alert(`Generating report from ${startDate} to ${endDate}...`);
        }
        function downloadReport(type) {alert(`Downloading ${type} report...`);}
        function viewReport(id) {alert(`Viewing report ID: ${id}`);}
    </script>
</body>
</html>
