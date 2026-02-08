<?php
function getUsers($conn) {
    $sql = "SELECT * FROM user WHERE name != '' AND name IS NOT NULL ORDER BY name";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) return [];
    
    $users = [];
    while($row = mysqli_fetch_assoc($result)) $users[] = $row;
    return $users;
}

function addNewUser($conn, $name, $email, $password, $role, $status) {
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);
    $status = mysqli_real_escape_string($conn, $status);
    
    $sql = "INSERT INTO user (name, email, password, role, status) VALUES ('$name', '$email', '$password', '$role', '$status')";
    return mysqli_query($conn, $sql);
}

function getUserById($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT * FROM user WHERE userId = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result || mysqli_num_rows($result) === 0) return null;
    return mysqli_fetch_assoc($result);
}

function deleteUser($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "DELETE FROM user WHERE userId = '$id'";
    return mysqli_query($conn, $sql);
}
?>