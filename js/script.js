// DOM Elements
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const categoryTabs = document.querySelectorAll('.category-tab');
const tourGrids = document.querySelectorAll('.tour-grid');
const navToggle = document.querySelector('.nav-toggle');
const navMenu = document.querySelector('.nav-menu');
const tourApplicationForm = document.getElementById('tourApplicationForm');
const contactForm = document.getElementById('contactForm');

// Global Variables
let currentSlide = 0;
const totalSlides = slides.length;

// Initialize Website
document.addEventListener('DOMContentLoaded', function() {
    initializeSlider();
    initializeNavigation();
    initializeTourCategories();
    initializeForms();
    initializeScrollEffects();
    initializeAnimations();
});

// Banner Slider Functionality
function initializeSlider() {
    // Auto-play slider
    setInterval(nextSlide, 5000);
    
    // Event listeners for controls
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    // Event listeners for dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });
}

function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Show current slide
    if (slides[index]) {
        slides[index].classList.add('active');
    }
    if (dots[index]) {
        dots[index].classList.add('active');
    }
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

function goToSlide(index) {
    currentSlide = index;
    showSlide(currentSlide);
}

// Navigation Functionality
function initializeNavigation() {
    // Mobile menu toggle for both old and new header
    const menuBtn = document.querySelector('.menu-btn');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuBtn && mainNav) {
        menuBtn.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    // Legacy mobile menu toggle
    if (navToggle) {
        navToggle.addEventListener('click', toggleMobileMenu);
    }
    
    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', smoothScroll);
    });
    
    // Header scroll effect
    window.addEventListener('scroll', handleHeaderScroll);
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mainNav && !e.target.closest('.main-header')) {
            mainNav.classList.remove('active');
            if (menuBtn) menuBtn.classList.remove('active');
        }
    });
}

function toggleMobileMenu() {
    navMenu.classList.toggle('active');
    navToggle.classList.toggle('active');
    
    // Animate hamburger menu
    const spans = navToggle.querySelectorAll('span');
    spans.forEach(span => span.classList.toggle('active'));
}

function smoothScroll(e) {
    e.preventDefault();
    const targetId = this.getAttribute('href');
    const targetElement = document.querySelector(targetId);
    
    if (targetElement) {
        const headerHeight = document.querySelector('.header').offsetHeight;
        const targetPosition = targetElement.offsetTop - headerHeight;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
    
    // Close mobile menu if open
    if (navMenu.classList.contains('active')) {
        toggleMobileMenu();
    }
}

function handleHeaderScroll() {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
}

// Tour Categories Functionality
function initializeTourCategories() {
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.dataset.category;
            switchTourCategory(category, this);
        });
    });
}

function switchTourCategory(category, activeTab) {
    // Remove active class from all tabs and grids
    categoryTabs.forEach(tab => tab.classList.remove('active'));
    tourGrids.forEach(grid => grid.classList.remove('active'));
    
    // Add active class to clicked tab
    activeTab.classList.add('active');
    
    // Show corresponding tour grid
    const targetGrid = document.getElementById(category);
    if (targetGrid) {
        targetGrid.classList.add('active');
        
        // Animate tour cards
        const tourCards = targetGrid.querySelectorAll('.tour-card');
        tourCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
}

// Form Functionality
function initializeForms() {
    // Tour application form
    if (tourApplicationForm) {
        tourApplicationForm.addEventListener('submit', handleTourApplicationSubmit);
        
        // Real-time validation
        const inputs = tourApplicationForm.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearError);
        });
    }
    
    // Contact form
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactFormSubmit);
        
        // Real-time validation
        const contactInputs = contactForm.querySelectorAll('input, textarea');
        contactInputs.forEach(input => {
            input.addEventListener('blur', validateField);
            input.addEventListener('input', clearError);
        });
    }
}

function handleTourApplicationSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const formValid = validateForm(this);
    
    if (formValid) {
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Gönderiliyor...';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            showSuccessMessage(this, 'Başvurunuz başarıyla gönderildi! Size en kısa sürede dönüş yapılacaktır.');
            this.reset();
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }, 2000);
    }
}

function handleContactFormSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const formValid = validateForm(this);
    
    if (formValid) {
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Gönderiliyor...';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            showSuccessMessage(this, 'Mesajınız başarıyla gönderildi! Size en kısa sürede dönüş yapılacaktır.');
            this.reset();
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }, 2000);
    }
}

function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!validateField({ target: field })) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(e) {
    const field = e.target;
    const value = field.value.trim();
    const fieldType = field.type;
    const isRequired = field.hasAttribute('required');
    
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error
    clearError(e);
    
    // Required field validation
    if (isRequired && !value) {
        errorMessage = 'Bu alan zorunludur.';
        isValid = false;
    }
    
    // Email validation
    if (fieldType === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            errorMessage = 'Geçerli bir e-posta adresi giriniz.';
            isValid = false;
        }
    }
    
    // Phone validation
    if (fieldType === 'tel' && value) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
        if (!phoneRegex.test(value)) {
            errorMessage = 'Geçerli bir telefon numarası giriniz.';
            isValid = false;
        }
    }
    
    // Show error if validation fails
    if (!isValid) {
        showFieldError(field, errorMessage);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    field.classList.add('error');
    
    // Remove existing error message
    const existingError = field.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Create and show error message
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    errorElement.style.display = 'block';
    field.parentElement.appendChild(errorElement);
}

function clearError(e) {
    const field = e.target;
    field.classList.remove('error');
    
    const errorMessage = field.parentElement.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

function showSuccessMessage(form, message) {
    // Remove existing success message
    const existingSuccess = form.querySelector('.success-message');
    if (existingSuccess) {
        existingSuccess.remove();
    }
    
    // Create and show success message
    const successElement = document.createElement('div');
    successElement.className = 'success-message';
    successElement.textContent = message;
    successElement.style.display = 'block';
    form.appendChild(successElement);
    
    // Auto-hide success message
    setTimeout(() => {
        successElement.style.display = 'none';
    }, 5000);
}

// Scroll Effects
function initializeScrollEffects() {
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(handleIntersection, observerOptions);
    
    // Observe sections for animations
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        observer.observe(section);
    });
    
    // Observe tour cards and blog cards
    const cards = document.querySelectorAll('.tour-card, .blog-card');
    cards.forEach(card => {
        observer.observe(card);
    });
}

function handleIntersection(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('loading');
            
            // Animate tour cards with stagger effect
            if (entry.target.classList.contains('tour-card') || 
                entry.target.classList.contains('blog-card')) {
                const cards = entry.target.parentElement.querySelectorAll('.tour-card, .blog-card');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('loading');
                    }, index * 100);
                });
            }
        }
    });
}

// Animation Utilities
function initializeAnimations() {
    // Counter animation for statistics
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        animateCounter(counter);
    });
    
    // Parallax effect for background images
    window.addEventListener('scroll', handleParallax);
}

function animateCounter(counter) {
    const target = parseInt(counter.dataset.target);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        counter.textContent = Math.floor(current).toLocaleString();
    }, 16);
}

function handleParallax() {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.parallax');
    
    parallaxElements.forEach(element => {
        const rate = scrolled * -0.5;
        element.style.transform = `translateY(${rate}px)`;
    });
}

// Utility Functions
function debounce(func, wait, immediate) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            timeout = null;
            if (!immediate) func(...args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func(...args);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Tour Details Modal (for future enhancement)
function openTourModal(tourId) {
    // Implementation for tour details modal
    console.log('Opening tour details for:', tourId);
}

// WhatsApp Integration
function openWhatsApp(message = 'Merhaba, turlarınız hakkında bilgi almak istiyorum.') {
    const phoneNumber = '+905516562798';
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    window.open(whatsappUrl, '_blank');
}

// Phone Call Function
function makePhoneCall(number = '+902165945458') {
    window.location.href = `tel:${number}`;
}

// Email Function
function sendEmail(email = 'info@safwaturism.com') {
    window.location.href = `mailto:${email}`;
}

// Search Functionality (for future enhancement)
function searchTours(query) {
    const tours = document.querySelectorAll('.tour-card');
    tours.forEach(tour => {
        const title = tour.querySelector('h3').textContent.toLowerCase();
        const description = tour.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(query.toLowerCase()) || description.includes(query.toLowerCase())) {
            tour.style.display = 'block';
        } else {
            tour.style.display = 'none';
        }
    });
}

// Language Switcher (for future enhancement)
function switchLanguage(lang) {
    // Implementation for language switching
    console.log('Switching to language:', lang);
}

// Cookie Consent (for future enhancement)
function acceptCookies() {
    localStorage.setItem('cookiesAccepted', 'true');
    const cookieBanner = document.querySelector('.cookie-banner');
    if (cookieBanner) {
        cookieBanner.style.display = 'none';
    }
}

// Newsletter Subscription (for future enhancement)
function subscribeNewsletter(email) {
    // Implementation for newsletter subscription
    console.log('Subscribing email:', email);
}

// Print Page Function
function printPage() {
    window.print();
}

// Share Functions
function shareOnFacebook(url = window.location.href) {
    const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(facebookUrl, '_blank', 'width=600,height=400');
}

function shareOnTwitter(url = window.location.href, text = 'Safwa Tourism ile harika turlar!') {
    const twitterUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
    window.open(twitterUrl, '_blank', 'width=600,height=400');
}

// Accessibility Functions
function increaseFontSize() {
    const currentSize = parseFloat(getComputedStyle(document.body).fontSize);
    document.body.style.fontSize = (currentSize * 1.1) + 'px';
}

function decreaseFontSize() {
    const currentSize = parseFloat(getComputedStyle(document.body).fontSize);
    document.body.style.fontSize = (currentSize * 0.9) + 'px';
}

function toggleHighContrast() {
    document.body.classList.toggle('high-contrast');
}

// Performance Optimization
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Error Handling
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    // Could send error to analytics service
});

// Service Worker Registration (for PWA)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => console.log('SW registered'))
            .catch(registrationError => console.log('SW registration failed'));
    });
}

// Export functions for module use (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        nextSlide,
        prevSlide,
        goToSlide,
        switchTourCategory,
        validateForm,
        openWhatsApp,
        makePhoneCall,
        sendEmail
    };
}