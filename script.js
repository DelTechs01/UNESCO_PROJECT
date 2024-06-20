// Get the modal
var modal = document.getElementById("eventModal");

// Get the button that opens the modal
var eventLink = document.querySelector(".side-menu ul li:nth-child(4) a");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
eventLink.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}



document.addEventListener('DOMContentLoaded', function () {
    fetch('fetch_payments.php')
        .then(response => response.json())
        .then(data => {
            const paymentsTable = document.getElementById('payments-table');
            const contributionsList = document.getElementById('contributions-list');
            const totalAmountSpan = document.getElementById('total-amount');

            // Populate recent payments table
            data.recent_payments.forEach(payment => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${payment.name}</td>
                    <td>${payment.payment_id}</td>
                    <td>${payment.payment_date}</td>
                    <td>$${payment.amount}</td>
                `;
                paymentsTable.appendChild(row);
            });

            // Populate total contributions list
            data.total_contributions.forEach(contribution => {
                const item = document.createElement('li');
                item.textContent = `${contribution.name}: $${contribution.total_contributions}`;
                contributionsList.appendChild(item);
            });

            // Display total amount in the account
            totalAmountSpan.textContent = `$${data.total_amount}`;
        })
        .catch(error => console.error('Error fetching payments data:', error));
});


