<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit New - Research Grant System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">
    <aside class="sidebar">
        <div class="sidebar-header"><i class="fas fa-bars"></i> Research Grant System</div>
        <ul class="sidebar-menu">
            <li><a href="dashboardresearcher.php"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
            <li><a href="my-proposals.php"><i class="fas fa-folder"></i> My Proposals</a></li>
            <li><a href="submit-new.php" class="active"><i class="fas fa-plus"></i> Submit New</a></li>
            <li><a href="notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
        </ul>
        <div class="sidebar-footer"><a href="index.html"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </aside>

    <div class="content">
        <div class="top-bar">
            <h3>Submit New Research Proposal</h3>
            <div class="user-info">
                <span>[User Name] <i class="fas fa-user-circle"></i></span>
            </div>
        </div>

        <div class="scrollable-content">
            
            <form action="../backend/submit_proposal.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-section">
                    <h3>1. Proposal Details</h3>
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Title *</label>
                            <input type="text" name="proposal_title" placeholder="Enter descriptive title">
                        </div>
                        <div class="input-group">
                            <label>Research Area *</label>
                            <select name="research_area" style="width:100%; padding:12px; background:#e9ecef; border:none; border-radius:5px;">
                                <option value="cs">Computer Science</option>
                                <option value="eng">Engineering</option>
                                </select>
                        </div>
                        <div class="input-group form-full">
                            <label>Abstract/Description *</label>
                            <textarea name="abstract" style="width:100%; height:100px; padding:12px; background:#e9ecef; border:none; border-radius:5px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>2. Budget & Timeline</h3>
                    <div class="form-grid">
                        <div class="input-group">
                            <label>Requested Grant Amount (RM) *</label>
                            <input type="number" name="amount" placeholder="0.00">
                        </div>
                        <div class="input-group">
                            <label>Project Duration *</label>
                            <select name="duration" style="width:100%; padding:12px; background:#e9ecef; border:none; border-radius:5px;">
                                <option value="12">12 Months</option>
                                <option value="24">24 Months</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>3. Required Documents</h3>
                    <div class="upload-box">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 30px; margin-bottom: 10px;"></i><br>
                        Drag & drop PDF file here<br>
                        <input type="file" name="proposal_file" style="margin-top:10px;">
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" style="padding: 10px 20px; border: none; background: transparent; color: #ef4444; cursor: pointer;">Cancel</button>
                    <button type="submit" name="action" value="draft" style="padding: 10px 20px; border: 1px solid #ccc; background: white; border-radius: 5px;">Save Draft</button>
                    <button type="submit" name="action" value="submit" class="btn-primary" style="width: auto; padding: 10px 30px;">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>