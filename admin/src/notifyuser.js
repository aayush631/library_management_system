document.addEventListener('DOMContentLoaded', function() {
    const notifyForm = document.getElementById('notify-form');

    notifyForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const userId = document.getElementById('userid').value.trim();
        const message = document.getElementById('message').value.trim();

        if (message === '') {
            alert('Message cannot be empty.');
            return;
        }

        if (userId === '') {
            sendNotificationToAllUsers(message);
        } else {
            sendNotificationToUser(userId, message);
        }
    });

    function sendNotificationToUser(userId, message) {
        // Simulate sending notification to a single user
        console.log(`Notification sent to User ID ${userId}: ${message}`);
        alert(`Notification sent to User ID ${userId}`);
        notifyForm.reset();
    }

    function sendNotificationToAllUsers(message) {
        // Simulate sending notification to all users
        console.log(`Notification sent to all users: ${message}`);
        alert('Notification sent to all users');
        notifyForm.reset();
    }
});
