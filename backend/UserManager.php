<?php
class UserManager {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    public function getAllUsers() {
        $sql = "SELECT * FROM user ORDER BY userId";
        $result = mysqli_query($this->conn, $sql);
        $users = [];
        while($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        return $users;
    }
    
    public function addUser($name, $email, $password, $role, $status) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
        $role = mysqli_real_escape_string($this->conn, $role);
        $status = mysqli_real_escape_string($this->conn, $status);
        
        $sql = "INSERT INTO user (name, email, password, role, status) 
                VALUES ('$name', '$email', '$password', '$role', '$status')";
        
        return mysqli_query($this->conn, $sql);
    }
    
    public function updateUser($id, $name, $email, $role, $status) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $role = mysqli_real_escape_string($this->conn, $role);
        $status = mysqli_real_escape_string($this->conn, $status);
        
        $sql = "UPDATE user SET 
                name = '$name',
                email = '$email',
                role = '$role',
                status = '$status'
                WHERE userId = '$id'";
        
        return mysqli_query($this->conn, $sql);
    }
    
    public function deleteUser($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $sql = "DELETE FROM user WHERE userId = '$id'";
        return mysqli_query($this->conn, $sql);
    }
}
?>