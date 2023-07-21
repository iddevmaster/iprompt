import './bootstrap';

document.getElementById('togglePasswordBtn').addEventListener('click', togglePasswordVisibility);

function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var toggleButton = document.getElementById('togglePasswordBtn');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.textContent = 'Hide';
    } else {
        passwordInput.type = 'password';
        toggleButton.textContent = 'Show';
    }
}