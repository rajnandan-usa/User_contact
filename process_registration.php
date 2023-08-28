<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //database connection
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'user_registration';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Process and validate other fields

    // Validate Google Captcha
    $captcha_response = $_POST['g-recaptcha-response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => 'YOUR_RECAPTCHA_SECRET_KEY',
        'response' => $captcha_response
    );
    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $captcha_result = json_decode($result);

    if ($captcha_result->success) {
        // Save user data to database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $response = array('status' => 'success', 'message' => 'User registered successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Error saving user data');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Captcha validation failed');
    }

    // Close the database connection
    $conn->close();

    echo json_encode($response);
}
?>
