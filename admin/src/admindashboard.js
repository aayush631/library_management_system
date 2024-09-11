// document.addEventListener('DOMContentLoaded', () => {
//     console.log('DOM loaded, fetching data...');
//     fetchDashboardData();
// });

// function fetchDashboardData() {
//     fetch("../php/fetch_dashboard_data.php")
//         .then(response => {
//             console.log('Response status:', response.status); // Log response status
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.json();
//         })
//         .then(data => {
//             console.log('Fetched data:', data); // Log fetched data
//             if (data.error) {
//                 console.error('Error fetching data:', data.error);
//             } else {
//                 document.getElementById('total-users').innerText = data.total_users;
//                 document.getElementById('total-books').innerText = data.total_books;
//                 document.getElementById('books-available').innerText = data.books_available;
//             }
//         })
//         .catch(error => console.error('Fetch error:', error));
// }
