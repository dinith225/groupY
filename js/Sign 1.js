document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('signup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Clear previous error messages
        document.getElementById('usernameError').textContent = '';

        if (data.error) {
            // Display error message under the username field
            document.getElementById('usernameError').textContent = data.error;

            // Optionally suggest alternative usernames here
            // For simplicity, just show a placeholder suggestion
            // This part can be expanded based on specific requirements
        } else if (data.success) {
            // Handle successful account creation
            alert(data.success);
            window.location.href = "User Account.html"; // Redirect or handle as needed
        }
    })
    .catch(error => console.error('Error:', error));
});

