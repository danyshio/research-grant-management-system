<?php
session_start();
require_once('../backend/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

// Fetch proposals from database
$sql = "SELECT p.*, u.name as researcher_name 
        FROM proposal p 
        LEFT JOIN user u ON p.researcher_id = u.userId 
        ORDER BY p.submission_date DESC";
$result = mysqli_query($conn, $sql);
$proposals = [];
if ($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $proposals[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - All Proposals</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            margin-bottom: 30px;
        }
        
        .filters-bar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: flex-end;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-label {
            margin-bottom: 5px;
            color: #64748b;
            font-size: 14px;
        }
        
        .filter-select {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            min-width: 150px;
        }
        
        .apply-btn {
            padding: 8px 20px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .proposals-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        
        .proposals-table th {
            background: #f8fafc;
            padding: 15px;
            text-align: left;
            color: #64748b;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .proposals-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .proposals-table tr:hover {
            background: #f8fafc;
        }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-draft { background: #f3f4f6; color: #6b7280; }
        .status-submitted { background: #dbeafe; color: #1e40af; }
        .status-review { background: #fef3c7; color: #92400e; }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        
        .action-btns {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .view-btn { background: #3b82f6; color: white; }
        .edit-btn { background: #10b981; color: white; }
        .delete-btn { background: #ef4444; color: white; }
        
        .export-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .export-btn {
            padding: 8px 16px;
            background: #22c55e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="sidebar">
            <div class="sidebar-header">
                Research Grant System
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="admin-dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                </a></li>
                <li><a href="admin-users.php">
                    <i class="fas fa-users"></i> User Management
                </a></li>
                <li><a href="admin-proposals.php" class="active">
                    <i class="fas fa-file-alt"></i> All Proposals
                </a></li>
                <li><a href="admin-roles.php">
                    <i class="fas fa-user-tag"></i> Role Assignment
                </a></li>
                <li><a href="admin-budget.php">
                    <i class="fas fa-money-bill-wave"></i> Budget Allocation
                </a></li>
                <li><a href="admin-reports.php">
                    <i class="fas fa-chart-bar"></i> System Reports
                </a></li>
                <li><a href="admin-settings.php">
                    <i class="fas fa-cog"></i> System Settings
                </a></li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="../backend/logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <div class="content">
            <div class="top-bar">
                <div class="user-info">
                    <span>Welcome, <strong>
                        <?php 
                        if (isset($_SESSION['name'])) {
                            echo htmlspecialchars($_SESSION['name']);
                        } else {
                            echo "Admin";
                        }
                        ?>
                    </strong></span>
                    <span style="color: #64748b;">Admin</span>
                </div>
                <div style="display: flex; gap: 20px;">
                    <div class="icon-badge">
                        <i class="fas fa-bell"></i>
                        <span class="badge"><?php echo count($proposals); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="scrollable-content">
                <h1 style="margin-bottom: 20px;">All Proposals</h1>
                <p style="color: #64748b; margin-bottom: 30px;">View and manage all research proposals</p>
                
                <div class="stats-grid">
                    <div class="stat-card bg-green">
                        <i class="fas fa-file-alt"></i>
                        <h1><?php echo count($proposals); ?></h1>
                        <p>Total Proposals</p>
                    </div>
                    
                    <div class="stat-card bg-yellow">
                        <i class="fas fa-clock"></i>
                        <h1><?php echo count(array_filter($proposals, function($p) { return $p['status'] == 'pending' || $p['status'] == 'under_review'; })); ?></h1>
                        <p>Under Review</p>
                    </div>
                    
                    <div class="stat-card bg-purple">
                        <i class="fas fa-check-circle"></i>
                        <h1><?php echo count(array_filter($proposals, function($p) { return $p['status'] == 'approved'; })); ?></h1>
                        <p>Approved</p>
                    </div>
                    
                    <div class="stat-card bg-red">
                        <i class="fas fa-times-circle"></i>
                        <h1><?php echo count(array_filter($proposals, function($p) { return $p['status'] == 'rejected'; })); ?></h1>
                        <p>Rejected</p>
                    </div>
                </div>
                
                <div class="filters-bar">
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select class="filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="submitted">Submitted</option>
                            <option value="review">Under Review</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Date Range</label>
                        <select class="filter-select" id="dateFilter">
                            <option value="">All Time</option>
                            <option value="week">Last 7 Days</option>
                            <option value="month">Last 30 Days</option>
                            <option value="quarter">Last 3 Months</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Researcher</label>
                        <select class="filter-select" id="researcherFilter">
                            <option value="">All Researchers</option>
                            <?php
                            $uniqueResearchers = [];
                            foreach ($proposals as $proposal) {
                                if ($proposal['researcher_name'] && !in_array($proposal['researcher_name'], $uniqueResearchers)) {
                                    $uniqueResearchers[] = $proposal['researcher_name'];
                                    echo '<option value="' . htmlspecialchars($proposal['researcher_name']) . '">' . htmlspecialchars($proposal['researcher_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <button class="apply-btn" onclick="applyFilters()">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    
                    <div style="flex: 1;"></div>
                    
                    <button class="add-btn" onclick="location.href='submit-new.php'">
                        <i class="fas fa-plus"></i> New Proposal
                    </button>
                </div>
                
                <div class="table-container">
                    <table class="proposals-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Researcher</th>
                                <th>Submission Date</th>
                                <th>Budget</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($proposals)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #64748b;">
                                    No proposals found.
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($proposals as $proposal): 
                                $status_class = 'status-' . str_replace(' ', '-', strtolower($proposal['status']));
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($proposal['title']); ?></strong><br>
                                    <small style="color: #64748b;">ID: <?php echo $proposal['proposal_id']; ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($proposal['researcher_name'] ?? 'Unknown'); ?></td>
                                <td><?php echo date('M d, Y', strtotime($proposal['submission_date'])); ?></td>
                                <td>
                                    <?php if (isset($proposal['budget']) && $proposal['budget'] > 0): ?>
                                    RM <?php echo number_format($proposal['budget'], 2); ?>
                                    <?php else: ?>
                                    <span style="color: #64748b;">Not specified</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php echo ucfirst($proposal['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button class="action-btn view-btn" onclick="viewProposal(<?php echo $proposal['proposal_id']; ?>)">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="action-btn edit-btn" onclick="editProposal(<?php echo $proposal['proposal_id']; ?>)">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="action-btn delete-btn" onclick="deleteProposal(<?php echo $proposal['proposal_id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="export-bar">
                    <div style="color: #64748b;">
                        Showing <?php echo count($proposals); ?> proposals
                    </div>
                    <div>
                        <button class="export-btn" onclick="exportProposals()">
                            <i class="fas fa-download"></i> Export to Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;
            const researcher = document.getElementById('researcherFilter').value;
            alert(`Applying filters:\nStatus: ${status || 'All'}\nDate: ${date || 'All Time'}\nResearcher: ${researcher || 'All'}`);
        }
        
        function viewProposal(id) {
            alert(`View proposal ID: ${id}`);
        }
        
        function editProposal(id) {
            alert(`Edit proposal ID: ${id}`);
        }
        
        function deleteProposal(id) {
            if (confirm('Are you sure you want to delete this proposal?')) {
                alert(`Delete proposal ID: ${id}`);
            }
        }
        
        function exportProposals() {
            alert('Exporting proposals to Excel...');
        }
    </script>
</body>
</html>