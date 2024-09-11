document.addEventListener('DOMContentLoaded', () => {
    const today = new Date();
    const fineRate = 10; // Rs. 10 per day
    const tableBody = document.querySelector('#books-table tbody');

    // Function to calculate fine
    const calculateFine = (returnDate, status) => {
        const returnDateObj = new Date(returnDate);
        if (status === 'Returned') {
            return 'Rs. 0';
        }
        if (today > returnDateObj) {
            const diffTime = today.getTime() - returnDateObj.getTime();
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) - 1; // Calculate days after due date
            return `Rs. ${diffDays * fineRate} <span style="color: red;">*</span>`;
        }
        return 'Rs. 0';
    };

    // Function to update table data
    const updateTableData = () => {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const returnDate = row.cells[3].textContent;
            const status = row.cells[5].textContent;
            const fine = calculateFine(returnDate, status);
            row.cells[4].innerHTML = fine; // Use innerHTML to include HTML tags
        });
    };

    updateTableData();

    // Search functionality
    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', () => {
        const searchValue = searchInput.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const bookName = row.cells[1].textContent.toLowerCase();
            if (bookName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
