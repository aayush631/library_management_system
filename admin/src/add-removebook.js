document.addEventListener('DOMContentLoaded', function() {
    const addBookForm = document.getElementById('add-book-form');
    const removeBookForm = document.getElementById('remove-book-form');
    const removeBookIdInput = document.getElementById('remove-book-id');
    const removeBookNameInput = document.getElementById('remove-book-name');

    // Fetch book name when Book ID is entered in the Remove Book form
    removeBookIdInput.addEventListener('blur', function() {
        const bookId = removeBookIdInput.value.trim();
        if (bookId) {
            fetch('../php/get_book_name.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `book-id=${bookId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.book_name) {
                    removeBookNameInput.value = data.book_name;
                } else {
                    alert('Book ID not found');
                    removeBookNameInput.value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });

    // Handle Add Book form submission
    addBookForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        const formData = new FormData(addBookForm);

        fetch('../php/add_book.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Book added successfully!');
            } else {
                alert('Error adding book: ' + data.error);
            }
            addBookForm.reset();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Handle Remove Book form submission
    removeBookForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        const formData = new FormData(removeBookForm);

        fetch('../php/remove_book.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Book removed successfully!');
            } else {
                alert('Error removing book: ' + data.error);
            }
            removeBookForm.reset(); // Clear the form after submission
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
