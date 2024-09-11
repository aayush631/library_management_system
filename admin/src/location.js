// document.addEventListener('DOMContentLoaded', () => {
//     const tableBody = document.querySelector('#books-table tbody');
//     const searchInput = document.getElementById('search-bar');

//     const renderBooks = (bookList) => {
//         tableBody.innerHTML = '';
//         bookList.sort((a, b) => a.Book_Name.localeCompare(b.Book_Name));
//         bookList.forEach(book => {
//             const row = document.createElement('tr');
//             row.innerHTML = `
//                 <td>${book.book_id}</td>
//                 <td>${book.Book_Name}</td>
//                 <td>${book.Location_Rack}</td>
//             `;
//             tableBody.appendChild(row);
//         });
//     };

//     const fetchBooks = () => {
//         fetch('../php/fetch_books.php')
//             .then(response => response.json())
//             .then(data => {
//                 renderBooks(data);
//             })
//             .catch(error => {
//                 console.error('Error fetching books:', error);
//             });
//     };

//     searchInput.addEventListener('input', () => {
//         const searchValue = searchInput.value.toLowerCase();
//         fetch('../php/fetch_books.php')
//             .then(response => response.json())
//             .then(data => {
//                 const filteredBooks = data.filter(book => book.Book_Name.toLowerCase().includes(searchValue));
//                 renderBooks(filteredBooks);
//             })
//             .catch(error => {
//                 console.error('Error fetching books:', error);
//             });
//     });

//     // Initial fetch and render
//     fetchBooks();
// });