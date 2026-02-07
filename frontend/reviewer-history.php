<?php
session_start();

if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}

include("../backend/db.php");

$sql = "SELECT review.*, proposal.proposalId, proposal.title AS proposalTitle, proposal.status AS proposalStatus
FROM review
JOIN proposal ON review.proposalId = proposal.proposalId
ORDER BY review.reviewDate DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review History - Research Grant System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #7c3aed;">
            <i class="fas fa-bars"></i> Research Grant System
        </div>
        <ul class="sidebar-menu">
            <li><a href="reviewer-dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="reviewer-assigned.php"><i class="fas fa-clipboard-list"></i> Assigned Reviews</a></li>
            <li><a href="reviewer-history.php" class="active-reviewer"><i class="fas fa-history"></i> Review History</a></li>
            <li><a href="reviewer-notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Review History</h3>
            <div class="user-info">
                <span><?php echo $_SESSION['userName'] ?? 'Reviewer Dr Danysh'; ?> <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            
            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="background: white; padding: 15px 25px; border-radius: 8px; border: 1px solid #e2e8f0; flex: 1; display: flex; align-items: center; gap: 15px;">
                    <div style="background: #f3e8ff; padding: 10px; border-radius: 50%; color: #7c3aed;"><i class="fas fa-check-double"></i></div>
                    <div>
                        <h4 style="margin: 0; font-size: 20px;">[Count]</h4>
                        <span style="font-size: 13px; color: #666;">Total Reviewed</span>
                    </div>
                </div>
                <div style="background: white; padding: 15px 25px; border-radius: 8px; border: 1px solid #e2e8f0; flex: 1; display: flex; align-items: center; gap: 15px;">
                    <div style="background: #dcfce7; padding: 10px; border-radius: 50%; color: #16a34a;"><i class="fas fa-thumbs-up"></i></div>
                    <div>
                        <h4 style="margin: 0; font-size: 20px;">[Count]</h4>
                        <span style="font-size: 13px; color: #666;">Recommended Approval</span>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="filter-bar">
                    <input type="text" name="search_title" placeholder="Search by Proposal Title..." style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
                    
                    <input type="text" name="search_researcher" placeholder="Filter by Researcher Name..." style="padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 4px; margin-left: 10px;">
                    
                    <button class="btn-purple" style="padding: 8px 15px; margin-left: 10px;">Search</button>
                </div>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ref#</th>
                            <th>Proposal Title</th>
                            <th>Researcher</th>
                            <th>Date Reviewed</th>
                            <th>Score Given</th>
                            <th>Your Decision</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td>#<?php echo $row['proposalId']; ?></td>
    <td><?php echo $row['proposaltitle']; ?></td>
    <td>--</td>
    <td><?php echo $row['reviewDate']; ?></td>
    <td>--</td>
    <td>
        <span class="status-badge text-green">
            <?php echo $row['decision']; ?>
        </span>
    </td>
    <td>
        <?php
if($row['status'] == "Approved"){
    echo "<span style='color:green;font-weight:600;'>Approved by HOD</span>";
}
elseif($row['status'] == "Rejected"){
    echo "<span style='color:red;font-weight:600;'>Rejected by HOD</span>";
}
else{
    echo "<span style='color:orange;'>Waiting HOD</span>";
}
?>
    </td>
        <a href="#" class="btn-purple" style="padding:5px 15px; font-size:12px;">
            View Details
        </a>
    </td>
</tr>
<?php } ?>
</tbody>
                </table>
                
                <div style="padding: 15px; text-align: center; border-top: 1px solid #eee;">
                    <span style="font-size: 13px; color: #666; cursor: pointer;">&laquo; Previous</span>
                    <span style="font-size: 13px; margin: 0 10px;">Page 
                    1 of 5</span>
                    <span style="font-size: 13px; color: #7c3aed; cursor: pointer; font-weight: 600;">Next &raquo;</span>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>