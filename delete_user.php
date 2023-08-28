<?php
// Database connection 
$db_host = 'localhost';
    $db_user = 'username';
    $db_pass = 'password';
    $db_name = 'user_registration';
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete user from the database
    $sql = "DELETE FROM users WHERE id=$userId";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to user list page after delete
        header("Location: user_list.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
</head>
<body>
    <h1>Delete User</h1>
    
    <p>Are you sure you want to delete this user?</p>
    
    <form method="post">
        <input type="submit" value="Delete">
    </form>
</body>
</html>
