// Tours page specific JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeToursPage();
});

function initializeToursPage() {
    initializeFilters();
    initializeSearch();
    initializeQuickBooking();
    initializeWishlist();
    initializeSorting();
    initializeLoadMore();
    
    // Check URL parameters for initial filter
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');
    if (category && category !== 'all') {
        filterToursByCategory(category);
        document.querySelector(`[data-category="${category}"]`).classList.add('active');
        document.querySelector('[data-category="all"]').classList.remove('active');
    }
}

// Filter Functionality
function initializeFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter tours
            filterToursByCategory(category);
            
            // Update URL
            const url = new URL(window.location);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.history.pushState({}, '', url);
        });
    });
}

function filterToursByCategory(category) {
    const tourCards = document.querySelectorAll('.tour-card');
    
    tourCards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
            card.classList.add('fade-in');
        } else {
            card.style.display = 'none';
            card.classList.remove('fade-in');
        }
    });
    
    // Update results count
    updateResultsCount();
}

// Search Functionality
function initializeSearch() {
    const searchInput = document.getElementById('tourSearch');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = this.value.toLowerCase().trim();
            searchTours(query);
        }, 300);
    });
}

function searchTours(query) {
    const tourCards = document.querySelectorAll('.tour-card');
    
    tourCards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const description = card.querySelector('.tour-content > p').textContent.toLowerCase();
        const category = card.querySelector('.tour-category').textContent.toLowerCase();
        
        if (query === '' || 
            title.includes(query) || 
            description.includes(query) || 
            category.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    updateResultsCount();
}

// Sorting Functionality
function initializeSorting() {
    const sortSelect = document.getElementById('sortBy');
    const priceRangeSelect = document.getElementById('priceRange');
    
    sortSelect.addEventListener('change', function() {
        sortTours(this.value);
    });
    
    priceRangeSelect.addEventListener('change', function() {
        filterByPriceRange(this.value);
    });
}

function sortTours(sortType) {
    const toursGrid = document.getElementById('toursGrid');
    const tourCards = Array.from(toursGrid.querySelectorAll('.tour-card'));
    
    tourCards.sort((a, b) => {
        switch (sortType) {
            case 'price-low':
                return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            case 'price-high':
                return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            case 'duration':
                return parseInt(a.dataset.duration) - parseInt(b.dataset.duration);
            case 'popular':
                // Sort by rating (you could add data-rating attribute)
                const aRating = a.querySelectorAll('.stars .fas').length;
                const bRating = b.querySelectorAll('.stars .fas').length;
                return bRating - aRating;
            default:
                return 0;
        }
    });
    
    // Clear and re-append sorted cards
    toursGrid.innerHTML = '';
    tourCards.forEach(card => {
        toursGrid.appendChild(card);
    });
    
    // Add animation
    tourCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('slide-in-up');
        }, index * 50);
    });
}

function filterByPriceRange(range) {
    const tourCards = document.querySelectorAll('.tour-card');
    
    tourCards.forEach(card => {
        const price = parseInt(card.dataset.price);
        let show = false;
        
        switch (range) {
            case 'all':
                show = true;
                break;
            case '0-1000':
                show = price <= 1000;
                break;
            case '1000-2000':
                show = price > 1000 && price <= 2000;
                break;
            case '2000-3000':
                show = price > 2000 && price <= 3000;
                break;
            case '3000+':
                show = price > 3000;
                break;
        }
        
        card.style.display = show ? 'block' : 'none';
    });
    
    updateResultsCount();
}

// Quick Booking Modal
function initializeQuickBooking() {
    const quickBookButtons = document.querySelectorAll('.quick-book');
    const modal = document.getElementById('quickBookModal');
    const modalClose = modal.querySelector('.modal-close');
    const form = document.getElementById('quickBookingForm');
    
    quickBookButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tourId = this.dataset.tour;
            const tourTitle = this.closest('.tour-card').querySelector('h3').textContent;
            
            document.getElementById('selectedTour').value = tourId;
            modal.querySelector('.modal-header h3').textContent = `${tourTitle} - Hızlı Rezervasyon`;
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });
    
    modalClose.addEventListener('click', closeQuickBookModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeQuickBookModal();
        }
    });
    
    form.addEventListener('submit', handleQuickBookingSubmit);
    
    // ESC key to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeQuickBookModal();
        }
    });
}

function closeQuickBookModal() {
    const modal = document.getElementById('quickBookModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function handleQuickBookingSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const formValid = validateQuickBookingForm(this);
    
    if (formValid) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.textContent = 'Gönderiliyor...';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            alert('Rezervasyon talebiniz başarıyla gönderildi! Size en kısa sürede dönüş yapılacaktır.');
            closeQuickBookModal();
            this.reset();
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }, 2000);
    }
}

function validateQuickBookingForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        const value = field.value.trim();
        if (!value) {
            showFieldError(field, 'Bu alan zorunludur.');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    return isValid;
}

// Wishlist Functionality
function initializeWishlist() {
    const wishlistButtons = document.querySelectorAll('.tour-wishlist');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.style.color = '#dc2626';
                
                // Add to wishlist animation
                this.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
                
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.style.color = '';
            }
        });
    });
}

// Load More Functionality
function initializeLoadMore() {
    const loadMoreBtn = document.getElementById('loadMore');
    let isLoading = false;
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (isLoading) return;
            
            isLoading = true;
            this.textContent = 'Yükleniyor...';
            this.disabled = true;
            
            // Simulate loading more tours
            setTimeout(() => {
                // In a real app, you would fetch more tours from the server
                loadMoreBtn.style.display = 'none'; // Hide if no more tours
                isLoading = false;
            }, 1500);
        });
    }
}

// Utility Functions
function updateResultsCount() {
    const visibleTours = document.querySelectorAll('.tour-card[style*="block"], .tour-card:not([style*="none"])').length;
    
    // You could add a results counter element to show this
    console.log(`Showing ${visibleTours} tours`);
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('error');
    
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    errorElement.style.display = 'block';
    
    field.parentElement.appendChild(errorElement);
}

function clearFieldError(field) {
    field.classList.remove('error');
    
    const errorMessage = field.parentElement.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

// Share functionality
function shareTour(tourId, platform) {
    const tourCard = document.querySelector(`[data-tour="${tourId}"]`).closest('.tour-card');
    const tourTitle = tourCard.querySelector('h3').textContent;
    const tourUrl = `${window.location.origin}/tour-detail.html?id=${tourId}`;
    
    switch (platform) {
        case 'facebook':
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(tourUrl)}`, '_blank');
            break;
        case 'twitter':
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(tourTitle)}&url=${encodeURIComponent(tourUrl)}`, '_blank');
            break;
        case 'whatsapp':
            window.open(`https://wa.me/?text=${encodeURIComponent(tourTitle + ' ' + tourUrl)}`, '_blank');
            break;
    }
}

// Advanced filtering (for future enhancement)
function applyAdvancedFilters() {
    const filters = {
        category: document.querySelector('.filter-btn.active').dataset.category,
        priceRange: document.getElementById('priceRange').value,
        search: document.getElementById('tourSearch').value.toLowerCase(),
        sortBy: document.getElementById('sortBy').value
    };
    
    let tourCards = Array.from(document.querySelectorAll('.tour-card'));
    
    // Apply all filters
    tourCards = tourCards.filter(card => {
        // Category filter
        if (filters.category !== 'all' && card.dataset.category !== filters.category) {
            return false;
        }
        
        // Price range filter
        const price = parseInt(card.dataset.price);
        switch (filters.priceRange) {
            case '0-1000':
                if (price > 1000) return false;
                break;
            case '1000-2000':
                if (price <= 1000 || price > 2000) return false;
                break;
            case '2000-3000':
                if (price <= 2000 || price > 3000) return false;
                break;
            case '3000+':
                if (price <= 3000) return false;
                break;
        }
        
        // Search filter
        if (filters.search) {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.querySelector('.tour-content > p').textContent.toLowerCase();
            if (!title.includes(filters.search) && !description.includes(filters.search)) {
                return false;
            }
        }
        
        return true;
    });
    
    // Show/hide cards
    document.querySelectorAll('.tour-card').forEach(card => {
        card.style.display = 'none';
    });
    
    tourCards.forEach(card => {
        card.style.display = 'block';
    });
    
    // Apply sorting
    if (filters.sortBy && filters.sortBy !== 'default') {
        sortTours(filters.sortBy);
    }
    
    updateResultsCount();
}

// Lazy loading for images (performance optimization)
function initializeLazyLoading() {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Export functions for external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        filterToursByCategory,
        searchTours,
        sortTours,
        shareTour
    };
}