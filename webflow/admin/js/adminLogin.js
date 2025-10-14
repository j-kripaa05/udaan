// const loginForm = document.getElementById('adminLoginForm');

// Optional: Add client-side validation logic here if required.
document.addEventListener('DOMContentLoaded', () => {
    console.log("Admin Login page loaded.");
    
    const form = document.getElementById('adminLoginForm');

    form.addEventListener('submit', (e) => {
        const email = form.querySelector('input[name="email"]').value;
        const password = form.querySelector('input[name="password"]').value;

        if (email.trim() === "" || password.trim() === "") {
            // This is largely redundant as 'required' attribute handles it, but good for custom validation.
            // alert("Please fill in both email and password fields.");
            // e.preventDefault();
        }
    });
});