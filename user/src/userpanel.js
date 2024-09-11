// JavaScript for User Dashboard Page

document.addEventListener("DOMContentLoaded", function () {
    const hamburgerIcon = document.getElementById("hamburger-icon");
    const responsiveMenu = document.getElementById("responsive-menu");
    const closeIcon = document.getElementById("close-icon");
    const notificationBell = document.getElementById("notification-bell");
    const notificationPanel = document.getElementById("notification-panel");
    const closeNotificationBtn = document.getElementById("close-notifications");
    const responsiveNotifications = document.getElementById("responsive-notifications");

    // Toggle the responsive menu
    hamburgerIcon.addEventListener("click", function () {
        responsiveMenu.style.display = "block";
    });

    closeIcon.addEventListener("click", function () {
        responsiveMenu.style.display = "none";
    });

    // Handle notifications
    notificationBell.addEventListener("click", function () {
        notificationPanel.style.display = "flex";
    });

    responsiveNotifications.addEventListener("click", function () {
        notificationPanel.style.display = "flex";
    });

    closeNotificationBtn.addEventListener("click", function () {
        notificationPanel.style.display = "none";
    });

    // Close the responsive menu when clicking outside of it
    window.addEventListener("click", function (event) {
        if (event.target == responsiveMenu) {
            responsiveMenu.style.display = "none";
        }
        if (event.target == notificationPanel) {
            notificationPanel.style.display = "none";
        }
    });
});
