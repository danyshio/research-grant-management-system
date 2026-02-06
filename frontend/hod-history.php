<?php
session_start();
include("../backend/db.php");

$sql = "
SELECT proposal.*, user.name AS researcher
FROM proposal
JOIN user ON proposal.userId = user.userId
WHERE proposal.status='Approved' 
   OR proposal.status='Rejected'
ORDER BY proposal.proposalId DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approved History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #16a34a;"><i class="fas fa-bars"></i> Research Grant System</div>
        <ul class="sidebar-menu">
            <li><a href="hod-dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="hod-decisions.php"><i class="fas fa-gavel"></i> Pending Decisions</a></li>
            <li><a href="hod-history.php" class="active-hod"><i class="fas fa-check-double"></i> Approved History</a></li>
            <li><a href="hod-notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer"><a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Decision History</h3>
            <div class="user-info"><span>HOD [Name] <i class="fas fa-user-circle"></i></span></div>
        </div>

        <div class="scrollable-content">

            <div class="table-container">
                <div class="filter-bar">
                    <form action="" method="GET" style="display: flex; gap: 10px;">
                        <input type="text" name="search_query" placeholder="Search by Proposal Title or Researcher..." style="padding: 8px; width: 350px; border: 1px solid #ccc; border-radius: 4px;">
                        <button type="submit" class="btn-green">Search</button>
                    </form>
                </div>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ref#</th>
                            <th>Title</th>
                            <th>Researcher</th>
                            <th>Date Decided</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td>#RG-<?php echo $row['proposalId']; ?></td>

    <td><?php echo $row['title']; ?></td>

    <td><?php echo $row['researcher']; ?></td>

    <td><?php echo $row['submissionDate']; ?></td>

    <td>
        <?php if($row['status'] == 'Approved'){ ?>
            <span class="status-badge text-green">
                <i class="fas fa-check"></i> Approved
            </span>
        <?php } else { ?>
            <span class="status-badge text-red">
                <i class="fas fa-times"></i> Rejected
            </span>
        <?php } ?>
    </td>

    <td>
        <a href="#" style="color:#666; font-size:13px;">View Record</a>
    </td>
</tr>

<?php } ?>
                        </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>