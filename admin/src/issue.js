document.addEventListener('DOMContentLoaded', () => {
    const issueBookForm = document.getElementById('issue-book-form');
    const userIdInput = document.getElementById('user-id');
    const userFullnameInput = document.getElementById('user-fullname');
    const userSuggestions = document.getElementById('user-suggestions');
    const bookIdInput = document.getElementById('book-id');
    const bookNameInput = document.getElementById('book-name');
    const bookSuggestions = document.getElementById('book-suggestions');

    // Handle form submission
    issueBookForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const bookId = bookIdInput.value;
        const bookName = bookNameInput.value;
        const userId = userIdInput.value;
        const userFullname = userFullnameInput.value;
        const issuedDate = document.getElementById('issued-date').value;
        const returnDate = document.getElementById('return-date').value;
        const remarks = document.getElementById('remarks').value;

        const issuedBook = {
            bookId,
            bookName,
            userId,
            userFullname,
            issuedDate,
            returnDate,
            remarks
        };

        fetch('../php/issue_book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(issuedBook)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Book "${bookName}" issued to "${userFullname}" successfully!`);
                issueBookForm.reset();
            } else {
                alert('Error issuing book: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Fetch user details based on user ID
    userIdInput.addEventListener('input', () => {
        const userId = userIdInput.value;
        if (userId.length > 0) {
            fetch(`../php/fetch_user.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userFullnameInput.value = data.user.fullname;
                    } else {
                        userFullnameInput.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching user:', error);
                });
        }
    });

    // Fetch user suggestions based on user full name
    userFullnameInput.addEventListener('input', () => {
        const userFullname = userFullnameInput.value;
        if (userFullname.length > 0) {
            fetch(`../php/fetch_user.php?user_fullname=${userFullname}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        userSuggestions.innerHTML = '';
                        data.users.forEach(user => {
                            const suggestion = document.createElement('div');
                            suggestion.textContent = `${user.fullname} (${user.userid})`;
                            suggestion.className = 'suggestion-item';
                            suggestion.addEventListener('click', () => {
                                userIdInput.value = user.userid;
                                userFullnameInput.value = user.fullname;
                                userSuggestions.innerHTML = '';
                            });
                            userSuggestions.appendChild(suggestion);
                        });
                    } else {
                        userSuggestions.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                });
        } else {
            userSuggestions.innerHTML = '';
        }
    });

    // Fetch book details based on book ID
    bookIdInput.addEventListener('input', () => {
        const bookId = bookIdInput.value;
        if (bookId.length > 0) {
            fetch(`../php/fetch_book.php?book_id=${bookId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bookNameInput.value = data.book.name;
                    } else {
                        bookNameInput.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching book:', error);
                });
        }
    });

    // Fetch book suggestions based on book name
    bookNameInput.addEventListener('input', () => {
        const bookName = bookNameInput.value;
        if (bookName.length > 0) {
            fetch(`../php/fetch_book.php?book_name=${bookName}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bookSuggestions.innerHTML = '';
                        data.books.forEach(book => {
                            const suggestion = document.createElement('div');
                            suggestion.textContent = `${book.name} (${book.id})`;
                            suggestion.className = 'suggestion-item';
                            suggestion.addEventListener('click', () => {
                                bookIdInput.value = book.id;
                                bookNameInput.value = book.name;
                                bookSuggestions.innerHTML = '';
                            });
                            bookSuggestions.appendChild(suggestion);
                        });
                    } else {
                        bookSuggestions.innerHTML = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching books:', error);
                });
        } else {
            bookSuggestions.innerHTML = '';
        }
    });
});
