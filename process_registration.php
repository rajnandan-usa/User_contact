<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //connection 
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

    //Google Captcha
    $captcha_response = $_POST['g-recaptcha-response'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LeVq94nAAAAAA2e-wykLWxJdqrIYXlguBkVn9h5',
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
        // Save data to database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            // Close connection
            $conn->close();

            // Redirect to list page
            header("Location: user_list.php");
            exit();
        } else {
            $response = array('status' => 'error', 'message' => 'Error saving user data');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Captcha validation failed');
    }

    // Close connection
    $conn->close();

    echo json_encode($response);
}
?>
