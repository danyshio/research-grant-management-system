<?php
// admin-users.php
session_start();
require_once 'db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $delete_query = "DELETE FROM user WHERE userId = $user_id";
    mysqli_query($conn, $delete_query);
    header("Location: admin-users.php?msg=User+deleted");
    exit();
}

// Handle user addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    
    $insert_query = "INSERT INTO user (name, email, password, role, status) 
                     VALUES ('$name', '$email', '$password', '$role', 'Active')";
    mysqli_query($conn, $insert_query);
    header("Location: admin-users.php?msg=User+added");
    exit();
}

// Fetch all users
$users_query = "SELECT * FROM user ORDER BY userId DESC";
$users_result = mysqli_query($conn, $users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .user-table th, .user-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .user-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .user-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .role-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        .role-researcher { background: #e3f2fd; color: #1565c0; }
        .role-reviewer { background: #f3e5f5; color: #7b1fa2; }
        .role-hod { background: #e8f5e9; color: #2e7d32; }
        .role-admin { background: #fff3e0; color: #ef6c00; }
        
        .action-buttons a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9em;
        }
        
        .edit-btn { background: #3498db; color: white; }
        .delete-btn { background: #e74c3c; color: white; }
        
        .add-user-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .submit-btn {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>User Management</h1>
            <a href="admin-dashboard.php" style="text-decoration: none; color: #3498db;">← Back to Dashboard</a>
        </div>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="message success">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Add User Form -->
        <div class="add-user-form">
            <h2>Add New User</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="role">User Role</label>
                    <select id="role" name="role" required>
                        <option value="Researcher">Researcher</option>
                        <option value="Reviewer">Reviewer</option>
                        <option value="HOD">Head of Department</option>
                        <option value="Admin">Administrator</option>
                    </select>
                </div>
                
                <button type="submit" name="add_user" class="submit-btn">Add User</button>
            </form>
        </div>
        
        <!-- Users Table -->
        <h2>All Users</h2>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                <tr>
                    <td><?php echo $user['userId']; ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <span class="role-badge role-<?php echo strtolower($user['role']); ?>">
                            <?php echo $user['role']; ?>
                        </span>
                    </td>
                    <td><?php echo $user['status']; ?></td>
                    <td class="action-buttons">
                        <a href="edit-user.php?id=<?php echo $user['userId']; ?>" class="edit-btn">Edit</a>
                        <a href="admin-users.php?delete=<?php echo $user['userId']; ?>" 
                           class="delete-btn"
                           onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
