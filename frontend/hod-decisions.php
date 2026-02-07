<?php
session_start();
include("../backend/db.php");

if(!isset($_SESSION['userId'])){
    header("Location: index.html");
    exit();
}

$sql = "
SELECT proposal.proposalId, proposal.title, proposal.pdfFile, user.name AS researcher
FROM proposal
JOIN user ON proposal.userId = user.userId
WHERE proposal.status='Reviewed'
ORDER BY proposal.proposalId DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Decisions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header" style="color: #16a34a;"><i class="fas fa-bars"></i> Research Grant System</div>
        <ul class="sidebar-menu">
            <li><a href="hod-dashboard.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="hod-decisions.php" class="active-hod"><i class="fas fa-gavel"></i> Pending Decisions</a></li>
            <li><a href="hod-history.php"><i class="fas fa-check-double"></i> Approved History</a></li>
            <li><a href="hod-notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
        </ul>
        <div class="sidebar-footer"><a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Pending Decisions</h3>
            <div class="user-info"><span><?php echo $_SESSION['userName'] ?? 'Prof Thash HOD'; ?> <i class="fas fa-user-circle"></i></span></div>
        </div>

        <div class="scrollable-content">

            <div class="table-container">
                <div class="filter-bar">
                    <input type="text" placeholder="Search by title..." style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ref#</th>
                            <th>Proposal Details</th>
                            <th>Reviewer Score</th>
                            <th>Budget Req.</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td>#RG-<?php echo $row['proposalId']; ?></td>

    <td>
        <strong><?php echo $row['title']; ?></strong><br>
        <span style="font-size: 12px; color: #666;">
            Researcher: <?php echo $row['researcher']; ?>
        </span><br>
    </td>

    <td style="vertical-align: top;">
        <div style="font-weight: bold; color: #16a34a;">-- / 10</div>
        <span style="font-size: 11px; color: #666;">Reviewer</span>
    </td>

    <td style="vertical-align: top;">
        RM 0
    </td>

    <td style="vertical-align: top;">
        <?php if (!empty($row['pdfFile'])) { ?>
        <a href="../uploads/<?php echo $row['pdfFile']; ?>" target="_blank" style="font-weight:600;">
            View PDF
        </a>
        <br><br>
    <?php } ?>

    <form action="../backend/process_decision.php" method="POST" style="display:flex; gap:5px;">
        <input type="hidden" name="proposal_id" value="<?php echo $row['proposalId']; ?>">

        <button type="submit" name="decision" value="approve" class="btn-green">Approve</button>
        <button type="submit" name="decision" value="reject" class="btn-outline-red">Reject</button>
    </form>

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