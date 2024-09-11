
    document.addEventListener('DOMContentLoaded', () => {
        const receiveBookForm = document.getElementById('receive-book-form');

        receiveBookForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const bookId = document.getElementById('book-id').value;
            const bookName = document.getElementById('book-name').value;
            const userId = document.getElementById('user-id').value;
            const userFullname = document.getElementById('user-fullname').value;
            const lastIssuedDate = document.getElementById('issued-date').value;
            const returnDate = document.getElementById('return-date').value;
            const fine = document.getElementById('fine').value;
            const status = document.getElementById('status').value;

            const receivedBook = {
                bookId,
                bookName,
                userId,
                userFullname,
                lastIssuedDate,
                returnDate,
                fine,
                status
            };

            fetch('../php/receive_book.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(receivedBook)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Book "${bookName}" received from "${userFullname}" successfully!`);
                    receiveBookForm.reset();
                } else {
                    alert(`Failed to receive book: ${data.message}`);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        const fetchIssuedBookDetails = (userId, bookId) => {
            fetch(`../php/get_issued_book_details.php?user_id=${userId}&book_id=${bookId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('book-name').value = data.book_name;
                    document.getElementById('user-id').value = data.user_id;
                    document.getElementById('user-fullname').value = data.user_fullname;
                    document.getElementById('issued-date').value = data.return_date;
                    document.getElementById('fine').value = data.fine;
                } else {
                    alert(`Failed to fetch book details: ${data.message}`);
                }
            })
            .catch(error => console.error('Error:', error));
        };

        document.getElementById('book-id').addEventListener('blur', function() {
            const bookId = this.value;
            const userId = document.getElementById('user-id').value;
            
            if (userId && bookId) {
                fetchIssuedBookDetails(userId, bookId);
            }
        });

        document.getElementById('user-fullname').addEventListener('blur', function() {
            const userFullname = this.value;
            
            if (userFullname) {
                fetch(`../php/get_user_id_by_name.php?user_fullname=${userFullname}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('user-id').value = data.user_id;
                        const bookId = document.getElementById('book-id').value;
                        if (bookId) {
                            fetchIssuedBookDetails(data.user_id, bookId);
                        }
                    } else {
                        alert(`Failed to fetch user ID: ${data.message}`);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });