document.addEventListener('DOMContentLoaded', function() {
    const subscribeBtn = document.getElementById('subscribeBtn');
    const popup = document.getElementById('popup');
    const closePopup = document.getElementById('closePopup');
    const emailInput = document.getElementById('emailInput');

    // Function to check if email is valid
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    if (subscribeBtn && popup && closePopup && emailInput) {
        subscribeBtn.addEventListener('click', () => {
            const email = emailInput.value.trim();
            if (email === "") {
                alert("Please enter your email address.");
            } else if (!isValidEmail(email)) {
                alert("Please enter a valid email address.");
            } else {
                // In a real application, you would send the email to the server here
                popup.style.display = 'flex';
                emailInput.value = '';
            }
        });

        closePopup.addEventListener('click', () => {
            popup.style.display = 'none';
        });
    }
});