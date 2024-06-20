document.getElementById('addMemberForm').onsubmit = function(event) {
    event.preventDefault(); // Prevent the default form submission
    
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var regNumber = document.getElementById('regNumber').value;
    var yearOfStudy = document.getElementById('yearOfStudy').value;
    var courseOfStudy = document.getElementById('courseOfStudy').value;
    var profilePicture = document.getElementById('profilePicture').files[0];
    
    // Create FormData object and append form fields
    var formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('regNumber', regNumber);
    formData.append('yearOfStudy', yearOfStudy);
    formData.append('courseOfStudy', courseOfStudy);
    formData.append('profilePicture', profilePicture);
    
    // Send the form data to the server using Fetch API
    fetch('add_member.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Handle the response from the server
        alert(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
};


document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const membersTable = document.getElementById('members-table');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = membersTable.getElementsByTagName('tr');

        Array.from(rows).forEach(function(row) {
            const name = row.cells[1]?.textContent.toLowerCase();
            const email = row.cells[2]?.textContent.toLowerCase();
            const regNumber = row.cells[4]?.textContent.toLowerCase();
            const course = row.cells[5]?.textContent.toLowerCase();

            if (
                name?.includes(searchTerm) ||
                email?.includes(searchTerm) ||
                regNumber?.includes(searchTerm) ||
                course?.includes(searchTerm)
            ) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

