document.addEventListener('DOMContentLoaded', function() {
  // Initialize the application form
  initializeForm();
  
  // Add intersection observer for scroll animations
  setupScrollAnimations();
  
  // Add image loading handlers
  setupImageLoading();
});

function initializeForm() {
  console.log('Application form initialized');
  
  // Add click handlers for sections
  const sections = document.querySelectorAll('.form-section');
  sections.forEach((section, index) => {
    section.addEventListener('click', function() {
      handleSectionClick(section, index + 1);
    });
    
    // Add keyboard navigation
    section.setAttribute('tabindex', '0');
    section.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        handleSectionClick(section, index + 1);
      }
    });
  });
}

function handleSectionClick(section, sectionNumber) {
  console.log(`Section ${sectionNumber} clicked`);
  
  // Add a subtle pulse effect
  section.style.transform = 'scale(0.98)';
  setTimeout(() => {
    section.style.transform = '';
  }, 150);
  
  // You can add more interactive functionality here
  // For example, opening a modal, expanding the section, etc.
}

function setupScrollAnimations() {
  // Create intersection observer for scroll-triggered animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
      }
    });
  }, observerOptions);
  
  // Observe all form sections
  const sections = document.querySelectorAll('.form-section');
  sections.forEach(section => {
    observer.observe(section);
  });
}

function setupImageLoading() {
  const images = document.querySelectorAll('.section-image');
  
  images.forEach((img, index) => {
    // Add loading state
    img.addEventListener('loadstart', function() {
      this.style.opacity = '0.5';
    });
    
    // Handle successful load
    img.addEventListener('load', function() {
      this.style.opacity = '1';
      console.log(`Section ${index + 1} image loaded successfully`);
    });
    
    // Handle loading errors
    img.addEventListener('error', function() {
      console.error(`Failed to load image for section ${index + 1}`);
      this.alt = `Section ${index + 1} - Image failed to load`;
      this.style.opacity = '0.7';
      this.style.backgroundColor = '#666';
      this.style.color = '#fff';
      this.style.display = 'flex';
      this.style.alignItems = 'center';
      this.style.justifyContent = 'center';
      this.style.minHeight = '200px';
    });
  });
}

// Utility function to smooth scroll to a specific section
function scrollToSection(sectionNumber) {
  const section = document.getElementById(`section-${sectionNumber}`);
  if (section) {
    section.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });
  }
}

// Add keyboard shortcuts for navigation
document.addEventListener('keydown', function(e) {
  // Use number keys 1-5 to jump to sections
  if (e.key >= '1' && e.key <= '5') {
    const sectionNumber = parseInt(e.key);
    scrollToSection(sectionNumber);
  }
});

// Add resize handler for responsive adjustments
window.addEventListener('resize', function() {
  // Debounce resize events
  clearTimeout(window.resizeTimeout);
  window.resizeTimeout = setTimeout(function() {
    console.log('Window resized, adjusting layout');
    // Add any resize-specific logic here
  }, 250);
});
