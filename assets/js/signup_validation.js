function checkUsername() {
    const username = document.getElementById('username').value;
    const usernameError = document.getElementById('username-error');
    const signupButton = document.getElementById('signup-button');

    if (username.length === 0) {
        usernameError.textContent = '';
        signupButton.disabled = true;
        return;
    }

    fetch('validate_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `field=username&value=${encodeURIComponent(username)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                usernameError.textContent = 'Username is already taken.';
                signupButton.disabled = true;
            } else {
                usernameError.textContent = '';
                signupButton.disabled = false;
            }
        })
        .catch(error => console.error('Error:', error));
}

function checkEmail() {
    const email = document.getElementById('email').value;
    const emailError = document.getElementById('email-error');
    const signupButton = document.getElementById('signup-button');

    if (email.length === 0) {
        emailError.textContent = '';
        signupButton.disabled = true;
        return;
    }

    fetch('validate_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `field=email&value=${encodeURIComponent(email)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                emailError.textContent = 'Email is already registered.';
                signupButton.disabled = true;
            } else {
                emailError.textContent = '';
                signupButton.disabled = false;
            }
        })
        .catch(error => console.error('Error:', error));
}
