document.addEventListener('DOMContentLoaded', function() {
    // Effet de flou sur la navbar lors du défilement
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Animation des éléments au scroll
    const animateElements = document.querySelectorAll('.feature-card, .process-step, .contact-form');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('fade-in');
        }
      });
    }, { threshold: 0.1 });
    
    animateElements.forEach(element => {
      observer.observe(element);
      element.style.opacity = "0";
    });
    
    // Animation de défilement doux pour les liens de navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      });
    });
    
    // Animation du logo
    const logo = document.querySelector('.navbar-brand img');
    if (logo) {
      logo.addEventListener('mouseover', function() {
        this.style.transform = 'rotate(10deg)';
      });
      
      logo.addEventListener('mouseout', function() {
        this.style.transform = 'rotate(0deg)';
      });
    }
    
    // Effet de hover amélioré pour les boutons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
      button.addEventListener('mouseover', function() {
        this.style.transform = 'translateY(-3px)';
        this.style.boxShadow = '0 10px 20px rgba(15, 23, 42, 0.2)';
      });
      
      button.addEventListener('mouseout', function() {
        this.style.transform = '';
        this.style.boxShadow = '';
      });
    });
    
    // Validation simple du formulaire de contact
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
      contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const nameInput = this.querySelector('input[type="text"]');
        const emailInput = this.querySelector('input[type="email"]');
        const messageInput = this.querySelector('textarea');
        
        let isValid = true;
        
        if (!nameInput.value.trim()) {
          highlightError(nameInput);
          isValid = false;
        } else {
          removeError(nameInput);
        }
        
        if (!emailInput.value.trim() || !isValidEmail(emailInput.value)) {
          highlightError(emailInput);
          isValid = false;
        } else {
          removeError(emailInput);
        }
        
        if (!messageInput.value.trim()) {
          highlightError(messageInput);
          isValid = false;
        } else {
          removeError(messageInput);
        }
        
        if (isValid) {
          // Simuler l'envoi du formulaire avec une animation
          const submitBtn = this.querySelector('button[type="submit"]');
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
          
          setTimeout(() => {
            contactForm.innerHTML = `
              <div class="text-center py-4">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                <h4 class="mt-3">Message envoyé avec succès!</h4>
                <p>Nous vous répondrons dans les plus brefs délais.</p>
              </div>
            `;
          }, 1500);
        }
      });
    }
    
    function highlightError(input) {
      input.style.borderColor = '#e53e3e';
      input.style.backgroundColor = 'rgba(229, 62, 62, 0.05)';
    }
    
    function removeError(input) {
      input.style.borderColor = '';
      input.style.backgroundColor = '';
    }
    
    function isValidEmail(email) {
      const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    }
  });


  /* JavaScript functions pour navbar */
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Animation des éléments au scroll
    const animateElements = document.querySelectorAll('.feature-card, .process-step, .contact-form');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('fade-in');
        }
      });
    }, { threshold: 0.1 });
    
    animateElements.forEach(element => {
      observer.observe(element);
      element.style.opacity = "0";
    });
  });
  
  // Back to top button
document.addEventListener('DOMContentLoaded', function() {
  const backToTop = document.querySelector('.back-to-top');
  
  // Affichage progressif au scroll
  window.addEventListener('scroll', () => {
      const scrollPosition = window.pageYOffset;
      if (scrollPosition > 300) {
          backToTop.classList.add('show');
      } else {
          backToTop.classList.remove('show');
      }
  });

  // Défilement fluide
  backToTop.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
          top: 0,
          behavior: 'smooth'
      });
  });
});