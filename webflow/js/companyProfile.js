document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // MODAL ELEMENTS
    const postJobButton = document.getElementById('post-job-btn');
    const jobModal = document.getElementById('job-modal');
    const modalCloseButtons = document.querySelectorAll('#modal-close-btn, #modal-cancel-btn'); // Close and Cancel buttons

    // EDIT PROFILE ELEMENTS
    const editButton = document.getElementById('edit-profile-btn');
    const formContainer = document.getElementById('company-info-form');
    let isEditing = false; 


    // ===============================================
    // --- Tab Switching Functionality ---
    // ===============================================
    function switchTab(tabId) {
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        const activeButton = document.querySelector(`.tab-button[data-tab="${tabId}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
        
        const activeContent = document.getElementById(tabId);
        if (activeContent) {
            activeContent.classList.add('active');
        }
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const tabId = event.target.getAttribute('data-tab');
            if (tabId) {
                switchTab(tabId);
            }
        });
    });

    // Initialize: Ensure the first tab is active on load
    switchTab('vacancies'); 


    // ===============================================
    // --- Edit Profile Functionality ---
    // ===============================================
    function toggleEditMode(event) {
        event.preventDefault();
        
        const editableFields = formContainer.querySelectorAll('input, textarea');

        editableFields.forEach(field => {
            field.disabled = !field.disabled;
        });
        
        isEditing = !isEditing;

        if (isEditing) {
            // Updated content using textContent/appendChild for slightly better security practice avoidance
            editButton.innerHTML = '<i class="fas fa-save"></i> Save Profile';
            editButton.classList.add('btn-save'); 
            if (editableFields.length > 0) editableFields[0].focus(); 
        } else {
            // Logic to handle saving/submitting data would go here
            editButton.innerHTML = '<i class="fas fa-edit"></i> Edit Profile';
            editButton.classList.remove('btn-save'); 
        }
    }

    if (editButton && formContainer) {
        editButton.addEventListener('click', toggleEditMode);
    }


    // ===============================================
    // --- Post New Job Modal Functionality ---
    // ===============================================
    function openModal() {
        if (jobModal) {
            jobModal.style.display = 'flex';
        }
    }

    function closeModal() {
        if (jobModal) {
            jobModal.style.display = 'none';
        }
    }

    if (postJobButton) {
        postJobButton.addEventListener('click', openModal);
    }

    modalCloseButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });

    // Close the modal if the user clicks anywhere outside of the modal content
    if (jobModal) {
        jobModal.addEventListener('click', (event) => {
            if (event.target === jobModal) {
                closeModal();
            }
        });
    }
});
