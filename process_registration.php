<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        // Handle file upload, database insertion, etc.
        // Return a JSON response indicating success or failure
        $response = array('status' => 'success', 'message' => 'User registered successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Captcha validation failed');
    }

    echo json_encode($response);
}
?>
