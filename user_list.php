<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
    <h1>User List</h1>
    
    <?php
    // Database connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'user_registration';
    
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Fetch users from database
    $sql = "SELECT id, name, email FROM users";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['name']} ({$row['email']})";
            echo " <a href='edit_user.php?id={$row['id']}'>Edit</a>";
            echo " <a href='delete_user.php?id={$row['id']}'>Delete</a></li>";
        }
        echo "</ul>";
    } else {
        echo "No users found.";
    }
    
    $conn->close();
    ?>
</body>
</html>
