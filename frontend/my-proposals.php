<?php
include("../backend/db.php");

$userId = 1; 

$sql = "SELECT * FROM proposal WHERE userId='$userId' ORDER BY proposalId DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Proposals - All</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header"><i class="fas fa-bars"></i> Research Grant System</div>
        <ul class="sidebar-menu">
            <li><a href="dashboardresearcher.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="my-proposals.php" class="active"><i class="fas fa-folder"></i> My Proposals</a></li>
            <li><a href="submit-new.php"><i class="fas fa-plus"></i> Submit New</a></li>
            <li><a href="notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
        </ul>
        <div class="sidebar-footer"><a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>My Proposals</h3>
            <div class="user-info"><span><?php echo $_SESSION['userName'] ?? 'Researcher'; ?> <i class="fas fa-user-circle"></i></span></div>
        </div>

        <div class="scrollable-content">
            
            <div class="researcher-tabs">
                <a href="my-proposals.php" class="researcher-tab active">All</a>
                <a href="my-proposals-draft.php" class="researcher-tab">Draft</a>
                <a href="my-proposals-submitted.php" class="researcher-tab">Submitted</a>
                <a href="my-proposals-review.php" class="researcher-tab">Under Review</a>
                <a href="my-proposals-approved.php" class="researcher-tab">Approved</a>
                <a href="my-proposals-rejected.php" class="researcher-tab">Rejected</a>
            </div>

            <div class="table-container" style="border-top-left-radius: 0;">
                <div class="filter-bar">
                    <input type="text" placeholder="Search by title..." style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Ref#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td style="font-weight: bold;">#<?php echo $row['proposalId']; ?></td>
        <td><?php echo $row['title']; ?></td>

        <td>
            <span class="status-badge text-gray">
                ● <?php echo $row['status']; ?>
            </span>
        </td>

        <td><?php echo $row['submissionDate']; ?></td>

        <td>
            <a href="#" style="color: black; margin-right: 10px;">
                <i class="fas fa-eye"></i>
            </a>
            <a href="#" style="color: #666;">
                <i class="fas fa-pencil-alt"></i>
            </a>
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