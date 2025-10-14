const loginForm = document.getElementById('loginForm');
const radios = document.querySelectorAll('input[name="role"]');

radios.forEach(radio => {
  radio.addEventListener('change', () => {
    console.log(`Selected role: ${radio.value}`);
    // This allows the PHP logic to determine the role upon form submission
  });
});

