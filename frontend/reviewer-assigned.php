<?php
session_start();
if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}
include("../backend/db.php");

$sql = "SELECT proposalID, title, submissionDate, status 
        FROM proposal 
        WHERE status='Submitted'
        ORDER BY proposalID DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assigned Reviews</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Specific style for the text-link buttons in the screenshot */
        .action-link {
            font-weight: 600;
            text-decoration: none;
            font-size: 13px;
        }
        .action-link:hover { text-decoration: underline; }
        
        .btn-start { color: #7c3aed; } /* Purple */
        .btn-continue { color: #2563eb; } /* Blue */
        .btn-view { color: #4b5563; } /* Gray */
        .btn-overdue { color: #ef4444; } /* Red */
    </style>
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #7c3aed;"><i class="fas fa-bars"></i> Research Grant System</div>
        <ul class="sidebar-menu">
            <li><a href="reviewer-dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="reviewer-assigned.php" class="active-reviewer"><i class="fas fa-clipboard-list"></i> Assigned Reviews</a></li>
            <li><a href="reviewer-history.php"><i class="fas fa-history"></i> Review History</a></li>
            <li><a href="reviewer-notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer"><a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Assigned Reviews</h3>
            <div class="user-info"><span>Reviewer <?php echo $_SESSION['userName']; ?> <i class="fas fa-user-circle"></i></span></div>
        </div>

        <div class="scrollable-content">
            
            <div class="tabs" style="background: #4b5563;"> 
                <a href="reviewer-assigned.php" class="tab" style="background: #7c3aed; color:white; font-weight:600;">All</a>
                <a href="reviewer-assigned-not-started.html" class="tab" style="color:white;">Not Started</a>
                <a href="reviewer-assigned-in-progress.html" class="tab" style="color:white;">In Progress</a>
                <a href="reviewer-assigned-completed.html" class="tab" style="color:white;">Completed</a>
                <a href="reviewer-assigned-overdue.html" class="tab" style="color:white;">Overdue</a>
            </div>

            <div class="table-container" style="border-top-left-radius: 0;">
                <div class="filter-bar">
                    <input type="text" placeholder="Search by title or ID..." style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ref#</th>
                            <th>Title</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Days Left</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td>#<?php echo $row['proposalID']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['submissionDate']; ?></td>
            <td>
                <span class="status-badge text-gray">
                    ● <?php echo $row['status']; ?>
                </span>
            </td>
            <td>--</td>
            <td>
                <a href="reviewer-evaluation.php?id=<?php echo $row['proposalID']; ?>" 
                   class="action-link btn-start">
                   [Start Review]
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
                        

                    </tbody>
                </table>
                
                <div style="padding: 15px; font-size: 13px; color: #666; background: #fafafa; border-top: 1px solid #eee; display:flex; justify-content:space-between;">
                    <span>
                        <i class="fas fa-file-alt"></i> 4 proposals assigned • <span style="color:#ef4444;">1 overdue</span>
                    </span>
                    <span>Average completion time: 4.2 days</span>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>