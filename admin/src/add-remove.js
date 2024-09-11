// document.addEventListener('DOMContentLoaded', function() {
//     const addUserForm = document.getElementById('add-user-form');
//     const removeUserForm = document.getElementById('remove-user-form');

//     const togglePasswordVisibility = (toggleElement, passwordField) => {
//         toggleElement.addEventListener('click', function() {
//             const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
//             passwordField.setAttribute('type', type);
//             toggleElement.classList.toggle('fa-eye-slash');
//         });
//     };

//     addUserForm.addEventListener('submit', function(event) {
//         event.preventDefault();
//         const formData = new FormData(addUserForm);

//         fetch('../php/add_user.php', {
//             method: 'POST',
//             body: formData
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.error) {
//                 console.error('Error adding user:', data.error);
//                 alert('Error adding user. Please try again.');
//             } else {
//                 console.log('User added successfully:', data.success);
//                 alert('User added successfully!');
//                 addUserForm.reset();
//             }
//         })
//         .catch(error => console.error('Add user fetch error:', error));
//     });

//     removeUserForm.addEventListener('submit', function(event) {
//         event.preventDefault();
//         const formData = new FormData(removeUserForm);

//         fetch('../php/remove_user.php', {
//             method: 'POST',
//             body: formData
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.error) {
//                 console.error('Error removing user:', data.error);
//                 alert('Error removing user. Please try again.');
//             } else {
//                 console.log('User removed successfully:', data.success);
//                 alert('User removed successfully!');
//                 removeUserForm.reset();
//             }
//         })
//         .catch(error => console.error('Remove user fetch error:', error));
//     });

//     const passwordToggle = document.querySelector('.password-toggle');
//     const confirmPasswordToggle = document.querySelector('.confirm-password-toggle');
//     const passwordField = document.getElementById('password');
//     const confirmPasswordField = document.getElementById('confirm-password');

//     togglePasswordVisibility(passwordToggle, passwordField);
//     togglePasswordVisibility(confirmPasswordToggle, confirmPasswordField);
// });
