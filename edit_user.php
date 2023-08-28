<?php
// Database connection and user retrieval logic
$db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'user_registration';
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user details in the database
    $newName = $_POST['new_name'];
    $newEmail = $_POST['new_email'];
    // Update other fields
    
    $sql = "UPDATE users SET name='$newName', email='$newEmail' WHERE id=$userId";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to user list page after update
        header("Location: user_list.php");
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    
    <form method="post">
        New Name: <input type="text" name="new_name"><br>
        New Email: <input type="email" name="new_email"><br>
        <!-- Add other fields -->
        <input type="submit" value="Update">
    </form>
</body>
</html>
