document.addEventListener('DOMContentLoaded', function() {
    const userList = document.getElementById('user-list');
    const searchInput = document.getElementById('search');

    // Function to display users
    const displayUsers = (usersToDisplay) => {
        userList.innerHTML = '';
        usersToDisplay.forEach(user => {
            const userItem = document.createElement('div');
            userItem.classList.add('user-item');
            userItem.textContent = `${user.fullname} (${user.userid})`;
            userItem.addEventListener('click', () => {
                // Redirect to user details page
                window.location.href = `userprofile.html?userid=${user.userid}`;
            });
            userList.appendChild(userItem);
        });
    };

    // Function to fetch users from the server
    const fetchUsers = (searchTerm = '') => {
        fetch(`../php/fetch_users.php?search=${searchTerm}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayUsers(data.users);
                } else {
                    console.error('Error fetching users:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

    // Fetch all users initially
    fetchUsers();

    // Search functionality
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value;
        fetchUsers(searchTerm);
    });
});
