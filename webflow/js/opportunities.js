// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Header scroll effect
window.addEventListener('scroll', function() {
  const header = document.querySelector('.header');
  if (window.scrollY > 100) {
    header.style.background = 'rgba(255, 255, 255, 0.95)';
    header.style.backdropFilter = 'blur(10px)';
  } else {
    header.style.background = '#ffffff';
    header.style.backdropFilter = 'none';
  }
});

// Apply button click handler
document.querySelectorAll('.apply-btn').forEach(button => {
  button.addEventListener('click', function() {
    // Add click animation
    this.style.transform = 'scale(0.95)';
    setTimeout(() => {
      this.style.transform = 'translateY(-2px)';
    }, 150);
    
    // Here you would typically handle the application process
    alert('Application process would be initiated here!');
  });
});

// Post opportunity button click handler
document.querySelector('.post-opportunity-btn').addEventListener('click', function() {
  // Add click animation
  this.style.transform = 'scale(0.95)';
  setTimeout(() => {
    this.style.transform = 'scale(1)';
  }, 150);
  
  // Here you would typically redirect to posting form
  alert('Redirect to opportunity posting form!');
});

// Newsletter form submission
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const emailInput = this.querySelector('.email-input');
  const email = emailInput.value.trim();
  
  if (email && isValidEmail(email)) {
    // Here you would typically send the email to your backend
    alert('Thank you for subscribing to our newsletter!');
    emailInput.value = '';
  } else {
    alert('Please enter a valid email address.');
  }
});

// Email validation function
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

// Language selector functionality
document.querySelector('.language-selector').addEventListener('click', function() {
  // Here you would typically show a dropdown with language options
  alert('Language selection would be implemented here!');
});

// Login button functionality
document.querySelector('.login-btn').addEventListener('click', function() {
  // Here you would typically redirect to login/signup page
  alert('Redirect to login/signup page!');
});

// Job card hover effects
document.querySelectorAll('.job-card').forEach(card => {
  card.addEventListener('mouseenter', function() {
    this.style.transform = 'translateY(-5px)';
    this.style.boxShadow = '0px 10px 20px rgba(0, 0, 0, 0.15)';
  });
  
  card.addEventListener('mouseleave', function() {
    this.style.transform = 'translateY(0)';
    this.style.boxShadow = '0px 0px 6px rgba(0, 0, 0, 0.25)';
  });
});

// Intersection Observer for animations
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
    }
  });
}, observerOptions);

// Observe job cards for animation
document.querySelectorAll('.job-card').forEach(card => {
  card.style.opacity = '0';
  card.style.transform = 'translateY(30px)';
  card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  observer.observe(card);
});

// Mobile menu toggle (if needed for responsive design)
function toggleMobileMenu() {
  const navbar = document.querySelector('.navbar');
  navbar.classList.toggle('mobile-active');
}

// Add mobile menu styles dynamically if needed
if (window.innerWidth <= 768) {
  const style = document.createElement('style');
  style.textContent = `
    .navbar.mobile-active {
      display: flex !important;
      flex-direction: column;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }
  `;
  document.head.appendChild(style);
}

// Lazy loading for images
const imageObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const img = entry.target;
      img.src = img.dataset.src || img.src;
      img.classList.remove('lazy');
      observer.unobserve(img);
    }
  });
});

document.querySelectorAll('img').forEach(img => {
  imageObserver.observe(img);
});

// Performance optimization: Debounce scroll events
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Apply debounce to scroll handler
const debouncedScrollHandler = debounce(function() {
  const header = document.querySelector('.header');
  if (window.scrollY > 100) {
    header.style.background = 'rgba(255, 255, 255, 0.95)';
    header.style.backdropFilter = 'blur(10px)';
  } else {
    header.style.background = '#ffffff';
    header.style.backdropFilter = 'none';
  }
}, 10);

window.addEventListener('scroll', debouncedScrollHandler);