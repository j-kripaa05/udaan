const workerForm = document.getElementById('workerForm');
const employerForm = document.getElementById('employerForm');
const radios = document.querySelectorAll('input[name="role"]');

radios.forEach(radio => {
  radio.addEventListener('change', () => {
    if (radio.value === 'worker') {
      workerForm.classList.add('active');
      employerForm.classList.remove('active');
    } else {
      employerForm.classList.add('active');
      workerForm.classList.remove('active');
    }
  });
});
