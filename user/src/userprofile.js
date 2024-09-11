document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.getElementById('edit-button');
    const saveButton = document.getElementById('save-button');
    const cancelButton = document.getElementById('cancel-button');
    const inputs = document.querySelectorAll('#profile-form input:not([disabled])');
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('toggle-password');

    // Enable inputs for editing
    editButton.addEventListener('click', () => {
        document.querySelectorAll('#profile-form input').forEach(input => input.disabled = false);
        saveButton.style.display = 'inline-block';
        cancelButton.style.display = 'inline-block';
        editButton.style.display = 'none';
    });

    // Save changes
    saveButton.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelectorAll('#profile-form input').forEach(input => input.disabled = true);
        saveButton.style.display = 'none';
        cancelButton.style.display = 'none';
        editButton.style.display = 'inline-block';
        document.getElementById('profile-form').submit(); // Submit the form to update profile
    });

    // Cancel editing
    cancelButton.addEventListener('click', () => {
        document.querySelectorAll('#profile-form input').forEach(input => input.disabled = true);
        saveButton.style.display = 'none';
        cancelButton.style.display = 'none';
        editButton.style.display = 'inline-block';
        // Optionally, reload the page to discard changes
        window.location.reload();
    });

    // Toggle password visibility
    togglePasswordButton.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordButton.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            togglePasswordButton.textContent = 'Show';
        }
    });
});
