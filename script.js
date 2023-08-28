document.getElementById('registration-form').addEventListener('submit', function(event) {
    event.preventDefault();
    // Perform client-side validation here

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
