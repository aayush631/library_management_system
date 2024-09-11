document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const borrowedBooksTableBody = document.querySelector('#borrowed-books-table tbody');

    async function fetchBorrowedBooks() {
        try {
            const response = await fetch('../php/borrowed_books_byuser.php');
            const data = await response.json();

            if (data.success) {
                return data.data;
            } else {
                console.error('Error fetching borrowed books:', data.message);
                return [];
            }
        } catch (error) {
            console.error('Error:', error);
            return [];
        }
    }

    function renderTable(data) {
        borrowedBooksTableBody.innerHTML = '';

        data.forEach(book => {
            const row = document.createElement('tr');
            const isOverdue = new Date(book.return_date) < new Date();
            row.innerHTML = `
                <td>${book.user_id}</td>
                <td>${book.user_fullname}</td>
                <td>${book.book_id}</td>
                <td>${book.book_name}</td>
                <td>${book.return_date}${isOverdue ? '*' : ''}</td>
                <td>${book.fine}</td>
            `;
            borrowedBooksTableBody.appendChild(row);
        });
    }

    function filterBooks(borrowedBooks) {
        const query = searchInput.value.toLowerCase();
        const filteredBooks = borrowedBooks.filter(book => 
            book.user_fullname.toLowerCase().includes(query) || 
            book.book_name.toLowerCase().includes(query) ||
            book.user_id.toLowerCase().includes(query) ||
            book.book_id.toLowerCase().includes(query)
        );
        renderTable(filteredBooks);
    }

    fetchBorrowedBooks().then(borrowedBooks => {
        searchInput.addEventListener('input', () => filterBooks(borrowedBooks));

        // Sort books by due date
        borrowedBooks.sort((a, b) => new Date(a.return_date) - new Date(b.return_date));

        // Initial render
        renderTable(borrowedBooks);
    });
});
