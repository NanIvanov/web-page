document.addEventListener('DOMContentLoaded', function () {
    // Register form
    const registerForm = document.querySelector('form[action="register.php"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            let valid = true;
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const role = document.getElementById('role').value;

            if (username === '') {
                alert('Username is required');
                valid = false;
            }

            if (email === '') {
                alert('Email is required');
                valid = false;
            } else if (!validateEmail(email)) {
                alert('Invalid email format');
                valid = false;
            }

            if (password === '') {
                alert('Password is required');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }

    // Login form
    const loginForm = document.querySelector('form[action="login.php"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            let valid = true;
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username === '') {
                alert('Username is required');
                valid = false;
            }

            if (password === '') {
                alert('Password is required');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    }
});

// Helper function to validate email format
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}
