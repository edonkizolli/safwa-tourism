// Tour Detail Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeTourDetail();
});

function initializeTourDetail() {
    initializeNavigation();
    initializeGallery();
    initializeBookingForm();
    initializePriceCalculation();
    initializeStickyElements();
    initializeReviews();
    initializeShareButtons();
}

// Navigation
function initializeNavigation() {
    const navLinks = document.querySelectorAll('.tour-nav .nav-link');
    
    // Smooth scrolling
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerHeight = 180; // Header + nav height
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Active navigation highlight
    window.addEventListener('scroll', updateActiveNavigation);
}

function updateActiveNavigation() {
    const navLinks = document.querySelectorAll('.tour-nav .nav-link');
    const sections = document.querySelectorAll('.content-section');
    
    let currentSection = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop - 200;
        const sectionHeight = section.offsetHeight;
        
        if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
            currentSection = section.id;
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${currentSection}`) {
            link.classList.add('active');
        }
    });
}

// Gallery
function initializeGallery() {
    const mainImage = document.getElementById('mainGalleryImage');
    const thumbnails = document.querySelectorAll('.gallery-thumbs img');
    
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            changeMainImage(this);
        });
    });
}

function changeMainImage(thumbnail) {
    const mainImage = document.getElementById('mainGalleryImage');
    const newSrc = thumbnail.src;
    const newAlt = thumbnail.alt;
    
    // Smooth transition
    mainImage.style.opacity = '0.5';
    
    setTimeout(() => {
        mainImage.src = newSrc;
        mainImage.alt = newAlt;
        mainImage.style.opacity = '1';
    }, 150);
    
    // Add active state to thumbnail
    document.querySelectorAll('.gallery-thumbs img').forEach(img => {
        img.style.border = 'none';
    });
    thumbnail.style.border = '3px solid #1e3a8a';
}

function openGalleryModal() {
    // Implementation for gallery modal
    // You could create a lightbox here
    console.log('Opening gallery modal...');
    alert('Gallery modal would open here with all images');
}

// Booking Form
function initializeBookingForm() {
    const bookingForm = document.getElementById('tourBookingForm');
    
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleBookingSubmit);
        
        // Form validation
        const inputs = bookingForm.querySelectorAll('input[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', validateBookingField);
            input.addEventListener('input', clearBookingError);
        });
    }
}

function handleBookingSubmit(e) {
    e.preventDefault();
    
    if (validateBookingForm(this)) {
        const formData = new FormData(this);
        const bookingData = {
            tour: '8 Günlük Lüks Umre Programı',
            date: formData.get('bookingDate'),
            adults: formData.get('adults'),
            children: formData.get('children'),
            name: formData.get('fullName'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            requests: formData.get('specialRequests'),
            totalPrice: document.getElementById('grandTotal').textContent
        };
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'İşleniyor...';
        submitBtn.disabled = true;
        
        // Simulate booking process
        setTimeout(() => {
            alert(`Rezervasyon talebiniz alındı!\n\nTur: ${bookingData.tour}\nTarih: ${bookingData.date}\nKişi Sayısı: ${bookingData.adults} Yetişkin, ${bookingData.children} Çocuk\nToplam: ${bookingData.totalPrice}\n\nSize en kısa sürede dönüş yapılacaktır.`);
            
            // Reset form
            this.reset();
            updatePriceCalculation();
            
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }, 2000);
    }
}

function validateBookingForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!validateBookingField({ target: field })) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateBookingField(e) {
    const field = e.target;
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Clear existing error
    clearBookingError(e);
    
    // Required validation
    if (field.hasAttribute('required') && !value) {
        errorMessage = 'Bu alan zorunludur.';
        isValid = false;
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            errorMessage = 'Geçerli bir e-posta adresi giriniz.';
            isValid = false;
        }
    }
    
    // Phone validation
    if (field.type === 'tel' && value) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
        if (!phoneRegex.test(value)) {
            errorMessage = 'Geçerli bir telefon numarası giriniz.';
            isValid = false;
        }
    }
    
    if (!isValid) {
        showBookingError(field, errorMessage);
    }
    
    return isValid;
}

function showBookingError(field, message) {
    field.style.borderColor = '#ef4444';
    
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    errorElement.style.color = '#ef4444';
    errorElement.style.fontSize = '12px';
    errorElement.style.marginTop = '5px';
    
    field.parentElement.appendChild(errorElement);
}

function clearBookingError(e) {
    const field = e.target;
    field.style.borderColor = '#e5e7eb';
    
    const errorMessage = field.parentElement.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

// Price Calculation
function initializePriceCalculation() {
    const adultsSelect = document.getElementById('adults');
    const childrenSelect = document.getElementById('children');
    
    if (adultsSelect && childrenSelect) {
        adultsSelect.addEventListener('change', updatePriceCalculation);
        childrenSelect.addEventListener('change', updatePriceCalculation);
    }
}

function updatePriceCalculation() {
    const adults = parseInt(document.getElementById('adults')?.value || 2);
    const children = parseInt(document.getElementById('children')?.value || 0);
    
    const adultPrice = 1750;
    const childPrice = adultPrice * 0.5; // 50% discount for children
    
    const adultTotal = adults * adultPrice;
    const childTotal = children * childPrice;
    const grandTotal = adultTotal + childTotal;
    
    // Update display
    const adultTotalElement = document.getElementById('adultTotal');
    const childTotalElement = document.getElementById('childTotal');
    const grandTotalElement = document.getElementById('grandTotal');
    
    if (adultTotalElement) {
        adultTotalElement.textContent = `$${adultTotal}`;
        document.querySelector('.price-item:first-child span:first-child').textContent = `Yetişkin (${adults} x $${adultPrice})`;
    }
    
    if (childTotalElement) {
        childTotalElement.textContent = `$${childTotal}`;
        document.querySelector('.price-item:nth-child(2) span:first-child').textContent = `Çocuk (${children} x $${childPrice})`;
    }
    
    if (grandTotalElement) {
        grandTotalElement.textContent = `$${grandTotal}`;
    }
}

// Sticky Elements
function initializeStickyElements() {
    window.addEventListener('scroll', handleStickyElements);
}

function handleStickyElements() {
    const tourNavigation = document.querySelector('.tour-navigation');
    const tourContent = document.querySelector('.tour-content');
    
    if (tourContent) {
        const rect = tourContent.getBoundingClientRect();
        
        if (rect.top <= 120) {
            tourNavigation.style.position = 'fixed';
            tourNavigation.style.top = '120px';
            tourNavigation.style.width = '100%';
            tourNavigation.style.zIndex = '1000';
        } else {
            tourNavigation.style.position = 'sticky';
            tourNavigation.style.top = '120px';
            tourNavigation.style.width = 'auto';
        }
    }
}

// Reviews
function initializeReviews() {
    const helpfulButtons = document.querySelectorAll('.review-helpful button');
    
    helpfulButtons.forEach(button => {
        button.addEventListener('click', function() {
            const currentText = this.textContent;
            const match = currentText.match(/\((\d+)\)/);
            if (match) {
                const currentCount = parseInt(match[1]);
                const newCount = currentCount + 1;
                this.textContent = currentText.replace(/\(\d+\)/, `(${newCount})`);
                this.style.background = '#10b981';
                this.style.color = 'white';
                this.style.borderColor = '#10b981';
                this.disabled = true;
            }
        });
    });
}

// Share Functions
function initializeShareButtons() {
    // Share button event listeners are already in the HTML onclick attributes
}

function shareOnFacebook() {
    const url = window.location.href;
    const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(facebookUrl, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = window.location.href;
    const text = document.querySelector('h1').textContent;
    const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
    window.open(twitterUrl, '_blank', 'width=600,height=400');
}

function copyToClipboard() {
    const url = window.location.href;
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            showToast('Link kopyalandı!');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('Link kopyalandı!');
    }
}

function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        z-index: 10000;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInUp 0.3s ease-out;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease-out';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Scroll to booking
function scrollToBooking() {
    const bookingSection = document.getElementById('booking');
    if (bookingSection) {
        const headerHeight = 180;
        const targetPosition = bookingSection.offsetTop - headerHeight;
        
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}

// URL Parameter Handling
function getTourIdFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}

// Dynamic Content Loading (for future enhancement)
function loadTourData(tourId) {
    // In a real application, you would fetch tour data from an API
    const tourData = {
        'umre-8-gun': {
            title: '8 Günlük Lüks Umre Programı',
            price: 1750,
            oldPrice: 2000,
            // ... other data
        }
        // ... other tours
    };
    
    return tourData[tourId] || null;
}

// Initialize with URL parameter
const tourId = getTourIdFromURL();
if (tourId) {
    const tourData = loadTourData(tourId);
    if (tourData) {
        // Update page content with dynamic data
        console.log('Loading tour:', tourId, tourData);
    }
}

// Accessibility improvements


// Initialize accessibility features
initializeAccessibility();

// Performance monitoring
function trackPerformance() {
    if ('performance' in window) {
        window.addEventListener('load', () => {
            const perfData = performance.timing;
            const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log(`Page load time: ${pageLoadTime}ms`);
        });
    }
}

trackPerformance();

// Export functions for external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        changeMainImage,
        shareOnFacebook,
        shareOnTwitter,
        copyToClipboard,
        scrollToBooking,
        openGalleryModal
    };
}