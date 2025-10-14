document.addEventListener('DOMContentLoaded', function() {
  // Story indicators functionality
  const indicators = document.querySelectorAll('.indicator');
  const prevButton = document.querySelector('.prev-button');
  const nextButton = document.querySelector('.next-button');
  const backButton = document.querySelector('.back-button');
  
  let currentStory = 0;
  const totalStories = indicators.length;
  
  // Update active indicator
  function updateIndicators() {
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentStory);
    });
  }
  
  // Navigate to previous story
  function goToPrevious() {
    if (currentStory > 0) {
      currentStory--;
      updateIndicators();
      // Add animation or content change logic here
      console.log(`Navigating to story ${currentStory + 1}`);
    }
  }
  
  // Navigate to next story
  function goToNext() {
    if (currentStory < totalStories - 1) {
      currentStory++;
      updateIndicators();
      // Add animation or content change logic here
      console.log(`Navigating to story ${currentStory + 1}`);
    }
  }
  
  // Navigate to specific story
  function goToStory(index) {
    if (index >= 0 && index < totalStories) {
      currentStory = index;
      updateIndicators();
      console.log(`Navigating to story ${currentStory + 1}`);
    }
  }
  
  // Event listeners
  prevButton.addEventListener('click', goToPrevious);
  nextButton.addEventListener('click', goToNext);
  
  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => goToStory(index));
  });
  
  backButton.addEventListener('click', function() {
    // Navigate back to previous page
    console.log('Navigating back');
    // You can implement actual navigation logic here
    // window.history.back();
  });
  
  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    switch(e.key) {
      case 'ArrowLeft':
        goToPrevious();
        break;
      case 'ArrowRight':
        goToNext();
        break;
      case 'Escape':
        backButton.click();
        break;
    }
  });
  
  // Smooth scroll for story sections
  const storyCards = document.querySelectorAll('.story-card');
  
  // Add intersection observer for scroll animations
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
  
  // Initialize story cards with animation
  storyCards.forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
  });
  
  // Add hover effects for interactive elements
  const interactiveElements = document.querySelectorAll('.nav-button, .indicator, .back-button');
  
  interactiveElements.forEach(element => {
    element.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.05)';
    });
    
    element.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1)';
    });
  });
  
  // Add loading animation for images
  const images = document.querySelectorAll('img');
  
  images.forEach(img => {
    img.addEventListener('load', function() {
      this.style.opacity = '1';
    });
    
    img.style.opacity = '0';
    img.style.transition = 'opacity 0.3s ease';
    
    // If image is already loaded
    if (img.complete) {
      img.style.opacity = '1';
    }
  });
  
  // Initialize the page
  updateIndicators();
  
  // Add touch/swipe support for mobile
  let touchStartX = 0;
  let touchEndX = 0;
  
  document.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
  });
  
  document.addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe left - next story
        goToNext();
      } else {
        // Swipe right - previous story
        goToPrevious();
      }
    }
  }
});
