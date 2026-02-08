<?php
session_start();
require_once('../backend/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Grant System - System Settings</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .settings-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }
        
        .settings-sidebar {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0;
            overflow: hidden;
        }
        
        .settings-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .settings-nav li {
            border-bottom: 1px solid #f1f5f9;
        }
        
        .settings-nav a {
            display: block;
            padding: 15px 20px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .settings-nav a:hover {
            background: #f8fafc;
            color: #3b82f6;
        }
        
        .settings-nav a.active {
            background: #e3f2fd;
            color: #3b82f6;
            border-left: 4px solid #3b82f6;
        }
        
        .settings-content {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 30px;
        }
        
        .settings-section {
            margin-bottom: 40px;
            display: none;
        }
        
        .settings-section.active {
            display: block;
        }
        
        .settings-section h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .form-input {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-textarea {
            width: 100%;
            max-width: 600px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            font-size: 14px;
            min-height: 100px;
            resize: vertical;
        }
        
        .form-checkbox {
            margin-right: 10px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .save-btn {
            padding: 10px 25px;
            background: #22c55e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .reset-btn {
            padding: 10px 25px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            margin-left: 10px;
        }
        
        .form-actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }
        
        .info-text {
            color: #64748b;
            font-size: 13px;
            margin-top: 5px;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #22c55e;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
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
                <li><a href="admin-proposals.php">
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
                <li><a href="admin-settings.php" class="active">
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
                        <span class="badge">3</span>
                    </div>
                </div>
            </div>
            
            <div class="scrollable-content">
                <h1 style="margin-bottom: 20px;">System Settings</h1>
                <p style="color: #64748b; margin-bottom: 30px;">Configure system parameters and preferences</p>
                
                <div class="settings-container">
                    <div class="settings-sidebar">
                        <ul class="settings-nav">
                            <li><a href="#" class="active" onclick="showSection('general')">General Settings</a></li>
                            <li><a href="#" onclick="showSection('email')">Email Settings</a></li>
                            <li><a href="#" onclick="showSection('notifications')">Notifications</a></li>
                            <li><a href="#" onclick="showSection('security')">Security</a></li>
                            <li><a href="#" onclick="showSection('backup')">Backup & Restore</a></li>
                            <li><a href="#" onclick="showSection('maintenance')">Maintenance</a></li>
                        </ul>
                    </div>
                    
                    <div class="settings-content">
                        <!-- General Settings -->
                        <div class="settings-section active" id="general-section">
                            <h3>General System Settings</h3>
                            
                            <div class="form-group">
                                <label class="form-label">System Name</label>
                                <input type="text" class="form-input" value="Research Grant System">
                                <div class="info-text">Display name shown on all pages</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Default Timezone</label>
                                <select class="form-input">
                                    <option>UTC</option>
                                    <option selected>Asia/Kuala_Lumpur (GMT+8)</option>
                                    <option>Asia/Singapore</option>
                                    <option>Europe/London</option>
                                    <option>America/New_York</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Date Format</label>
                                <select class="form-input">
                                    <option>DD/MM/YYYY</option>
                                    <option selected>MM/DD/YYYY</option>
                                    <option>YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Default Currency</label>
                                <input type="text" class="form-input" value="RM (Malaysian Ringgit)">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Max File Upload Size (MB)</label>
                                <input type="number" class="form-input" value="10" min="1" max="100">
                                <div class="info-text">Maximum file size for proposal attachments</div>
                            </div>
                            
                            <div class="form-actions">
                                <button class="save-btn" onclick="saveSettings('general')">
                                    <i class="fas fa-save"></i> Save General Settings
                                </button>
                                <button class="reset-btn" onclick="resetSettings('general')">
                                    <i class="fas fa-undo"></i> Reset to Default
                                </button>
                            </div>
                        </div>
                        
                        <!-- Email Settings -->
                        <div class="settings-section" id="email-section">
                            <h3>Email Configuration</h3>
                            
                            <div class="form-group">
                                <label class="form-label">SMTP Host</label>
                                <input type="text" class="form-input" value="smtp.gmail.com">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">SMTP Port</label>
                                <input type="number" class="form-input" value="587">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">SMTP Username</label>
                                <input type="email" class="form-input" value="noreply@university.edu">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">SMTP Password</label>
                                <input type="password" class="form-input" value="********">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email From Name</label>
                                <input type="text" class="form-input" value="Research Grant System">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email From Address</label>
                                <input type="email" class="form-input" value="noreply@university.edu">
                            </div>
                            
                            <div class="form-actions">
                                <button class="save-btn" onclick="saveSettings('email')">
                                    <i class="fas fa-save"></i> Save Email Settings
                                </button>
                                <button class="reset-btn" onclick="resetSettings('email')">
                                    <i class="fas fa-undo"></i> Reset to Default
                                </button>
                            </div>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="settings-section" id="notifications-section">
                            <h3>Notification Settings</h3>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span>Enable email notifications</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span>Notify on new proposal submission</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span>Notify on proposal status change</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span>Notify on review assignment</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox">
                                    <span>Notify on budget allocation</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Notification Frequency</label>
                                <select class="form-input">
                                    <option>Immediately</option>
                                    <option selected>Daily Digest</option>
                                    <option>Weekly Summary</option>
                                </select>
                            </div>
                            
                            <div class="form-actions">
                                <button class="save-btn" onclick="saveSettings('notifications')">
                                    <i class="fas fa-save"></i> Save Notification Settings
                                </button>
                            </div>
                        </div>
                        
                        <!-- Security -->
                        <div class="settings-section" id="security-section">
                            <h3>Security Settings</h3>
                            
                            <div class="form-group">
                                <label class="form-label">Session Timeout (minutes)</label>
                                <input type="number" class="form-input" value="30" min="5" max="240">
                                <div class="info-text">Automatically logout inactive users</div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span>Require strong passwords</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox">
                                    <span>Enable two-factor authentication</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-label">
                                    <input type="checkbox" class="form-checkbox" checked>
                                    <span>Enable login attempt limiting</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Max Login Attempts</label>
                                <input type="number" class="form-input" value="5" min="1" max="10">
                                <div class="info-text">Lock account after failed attempts</div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Password Expiry (days)</label>
                                <input type="number" class="form-input" value="90" min="30" max="365">
                                <div class="info-text">0 = Never expire</div>
                            </div>
                            
                            <div class="form-actions">
                                <button class="save-btn" onclick="saveSettings('security')">
                                    <i class="fas fa-save"></i> Save Security Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showSection(section) {
            document.querySelectorAll('.settings-nav a').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
            
            document.querySelectorAll('.settings-section').forEach(sec => {
                sec.classList.remove('active');
            });
            document.getElementById(section + '-section').classList.add('active');
        }
        
        function saveSettings(section) {
            alert(`Saving ${section} settings...`);
        }
        
        function resetSettings(section) {
            if (confirm(`Reset ${section} settings to default?`)) {
                alert(`Resetting ${section} settings...`);
            }
        }
    </script>
</body>
</html>