document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    form.addEventListener('submit', function(event) {
        const email = form.querySelector('input[name="email"]');
        const password = form.querySelector('input[name="password"]');
        
        if (email.value.trim() === '') {
            alert('Please enter your email.');
            email.focus();
            event.preventDefault();
        } else if (password.value.trim() === '') {
            alert('Please enter your password.');
            password.focus();
            event.preventDefault();
        }
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const editButton = document.getElementById('edit-button');
    const editForm = document.getElementById('edit-form');

    editButton.addEventListener('click', () => {
        editForm.style.display = (editForm.style.display === 'none') ? 'block' : 'none';
    });

    const loginForm = document.getElementById('login-form');
    loginForm.addEventListener('submit', (e) => {
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;

        if (!email || !password) {
            e.preventDefault();
            alert('Please fill out all fields.');
        }
    });
});

