document.getElementById('registration-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Clear previous error messages
    clearErrors();

    // Perform validation
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const userImage = document.getElementById('user_image').value;
    const captchaResponse = document.getElementById('g-recaptcha-response').value;

    if (name === '') {
        displayError('name', 'Name is required');
        return;
    }

    if (!validateEmail(email)) {
        displayError('email', 'Invalid email format');
        return;
    }

    if (password === '') {
        displayError('password', 'Password is required');
        return;
    }

    if (password !== confirmPassword) {
        displayError('confirm_password', 'Passwords do not match');
        return;
    }

    if (userImage === '') {
        displayError('user_image', 'User image is required');
        return;
    }

    if (captchaResponse === '') {
        displayError('captcha', 'Please complete the captcha');
        return;
    }

    // Submit the form data using AJAX
    const formData = new FormData(this);
    fetch('process_registration.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Handle response from server
        console.log(data);
    })
    .catch(error => {
        console.error(error);
    });
});

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function displayError(field, message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.innerText = message;
    document.getElementById(field + '-error').appendChild(errorElement);
}

function clearErrors() {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(element => element.remove());
}
