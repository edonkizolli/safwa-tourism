// Blog Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeBlogPage();
});

function initializeBlogPage() {
    initializeCategoryFilters();
    initializeSearch();
    initializeSorting();
    initializePagination();
    initializeNewsletterForm();
    updateBlogCount();
}

// Category Filters
function initializeCategoryFilters() {
    const categoryLinks = document.querySelectorAll('.category-list a');
    if (categoryLinks.length === 0) return; // Exit if no category links exist
    
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            categoryLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Get category
            const category = this.getAttribute('data-category');
            
            // Filter blog posts
            filterBlogPosts(category);
        });
    });
}

function filterBlogPosts(category) {
    const blogCards = document.querySelectorAll('.blog-card');
    let visibleCount = 0;
    
    blogCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        
        if (category === 'all' || cardCategory === category) {
            card.style.display = 'block';
            // Add animation
            card.style.opacity = '0';
            setTimeout(() => {
                card.style.opacity = '1';
            }, 50);
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    updateBlogCount(visibleCount);
    updatePagination();
}

// Search Functionality
function initializeSearch() {
    const searchInput = document.getElementById('blogSearch');
    if (!searchInput) return; // Exit if search input doesn't exist
    
    const searchButton = searchInput.nextElementSibling;
    
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });
    
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            performSearch(searchInput.value);
        });
    }
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch(this.value);
        }
    });
}

function performSearch(searchTerm) {
    const blogCards = document.querySelectorAll('.blog-card');
    const activeCategory = document.querySelector('.category-list a.active').getAttribute('data-category');
    let visibleCount = 0;
    
    searchTerm = searchTerm.toLowerCase().trim();
    
    blogCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        const title = card.querySelector('h2 a').textContent.toLowerCase();
        const content = card.querySelector('p').textContent.toLowerCase();
        const tags = Array.from(card.querySelectorAll('.tag')).map(tag => tag.textContent.toLowerCase());
        
        const matchesCategory = activeCategory === 'all' || cardCategory === activeCategory;
        const matchesSearch = searchTerm === '' || 
            title.includes(searchTerm) || 
            content.includes(searchTerm) || 
            tags.some(tag => tag.includes(searchTerm));
        
        if (matchesCategory && matchesSearch) {
            card.style.display = 'block';
            highlightSearchTerm(card, searchTerm);
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    updateBlogCount(visibleCount);
    updatePagination();
}

function highlightSearchTerm(card, searchTerm) {
    if (!searchTerm) return;
    
    const title = card.querySelector('h2 a');
    const content = card.querySelector('p');
    
    // Remove previous highlights
    [title, content].forEach(element => {
        element.innerHTML = element.textContent;
    });
    
    // Add new highlights
    if (searchTerm) {
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        title.innerHTML = title.textContent.replace(regex, '<mark>$1</mark>');
        content.innerHTML = content.textContent.replace(regex, '<mark>$1</mark>');
    }
}

// Sorting
function initializeSorting() {
    const sortSelect = document.getElementById('blogSort');
    if (!sortSelect) return; // Exit if sort select doesn't exist
    
    sortSelect.addEventListener('change', function() {
        sortBlogPosts(this.value);
    });
}

function sortBlogPosts(sortType) {
    const blogGrid = document.getElementById('blogGrid');
    const blogCards = Array.from(document.querySelectorAll('.blog-card'));
    
    blogCards.sort((a, b) => {
        const dateA = new Date(getPostDate(a));
        const dateB = new Date(getPostDate(b));
        
        switch (sortType) {
            case 'newest':
                return dateB - dateA;
            case 'oldest':
                return dateA - dateB;
            case 'popular':
                // For demo purposes, sort by reading time (longer = more popular)
                const timeA = parseInt(a.querySelector('.reading-time').textContent);
                const timeB = parseInt(b.querySelector('.reading-time').textContent);
                return timeB - timeA;
            default:
                return 0;
        }
    });
    
    // Remove all cards and re-append in sorted order
    blogCards.forEach(card => blogGrid.removeChild(card));
    blogCards.forEach(card => blogGrid.appendChild(card));
}

function getPostDate(card) {
    const dateText = card.querySelector('.date').textContent.replace('📅 ', '');
    // Convert Turkish date to English format for Date parsing
    const months = {
        'Ocak': 'January', 'Şubat': 'February', 'Mart': 'March',
        'Nisan': 'April', 'Mayıs': 'May', 'Haziran': 'June',
        'Temmuz': 'July', 'Ağustos': 'August', 'Eylül': 'September',
        'Ekim': 'October', 'Kasım': 'November', 'Aralık': 'December'
    };
    
    let englishDate = dateText;
    Object.keys(months).forEach(turkish => {
        englishDate = englishDate.replace(turkish, months[turkish]);
    });
    
    return englishDate;
}

// Pagination
function initializePagination() {
    const pageNumbers = document.querySelectorAll('.page-number');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    if (pageNumbers.length === 0) return; // Exit if no pagination exists
    
    pageNumbers.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            goToPage(index + 1);
        });
    });
    
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            const currentPage = getCurrentPage();
            if (currentPage > 1) {
                goToPage(currentPage - 1);
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            const currentPage = getCurrentPage();
            const totalPages = getTotalPages();
            if (currentPage < totalPages) {
                goToPage(currentPage + 1);
            }
        });
    }
}

function getCurrentPage() {
    const activePage = document.querySelector('.page-number.active');
    return parseInt(activePage.textContent);
}

function getTotalPages() {
    return document.querySelectorAll('.page-number').length;
}

function goToPage(pageNumber) {
    // Update active page button
    document.querySelectorAll('.page-number').forEach(btn => {
        btn.classList.remove('active');
        if (parseInt(btn.textContent) === pageNumber) {
            btn.classList.add('active');
        }
    });
    
    // Update prev/next button states
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const totalPages = getTotalPages();
    
    prevBtn.disabled = pageNumber === 1;
    nextBtn.disabled = pageNumber === totalPages;
    
    // Update page info
    const pageInfo = document.querySelector('.page-info');
    const visiblePosts = getVisiblePostsCount();
    pageInfo.textContent = `Sayfa ${pageNumber} / ${totalPages} (${visiblePosts} yazı)`;
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updatePagination() {
    // For demo purposes, keep static pagination
    // In a real application, this would dynamically update based on filtered results
}

// Newsletter Form
function initializeNewsletterForm() {
    const newsletterForm = document.querySelector('.newsletter-form');
    if (!newsletterForm) return; // Exit if newsletter form doesn't exist
    
    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const emailInput = this.querySelector('input[type="email"]');
        const email = emailInput.value.trim();
        
        if (validateEmail(email)) {
            // Show success message
            showNewsletterMessage('Başarıyla abone oldunuz! Teşekkür ederiz.', 'success');
            
            // Reset form
            emailInput.value = '';
        } else {
            showNewsletterMessage('Lütfen geçerli bir e-posta adresi giriniz.', 'error');
        }
    });
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showNewsletterMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `newsletter-message ${type}`;
    messageDiv.textContent = message;
    
    messageDiv.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 10px;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 14px;
        text-align: center;
    `;
    
    const newsletterContent = document.querySelector('.newsletter-content');
    newsletterContent.style.position = 'relative';
    newsletterContent.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Blog Count Update
function updateBlogCount(count) {
    const blogCountElement = document.getElementById('blogCount');
    if (!blogCountElement) return; // Exit if element doesn't exist
    
    const totalPosts = document.querySelectorAll('.blog-card').length;
    
    if (count !== undefined) {
        blogCountElement.textContent = `${count} yazı bulundu`;
    } else {
        blogCountElement.textContent = `${totalPosts} yazı bulundu`;
    }
}

function getVisiblePostsCount() {
    return document.querySelectorAll('.blog-card[style*="block"], .blog-card:not([style*="none"])').length;
}

// Tag Cloud Functionality
function initializeTagCloud() {
    const tags = document.querySelectorAll('.tag-cloud .tag');
    
    tags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            e.preventDefault();
            
            const tagText = this.textContent.toLowerCase();
            const searchInput = document.getElementById('blogSearch');
            
            searchInput.value = tagText;
            performSearch(tagText);
        });
    });
}

// Initialize tag cloud
initializeTagCloud();

// Popular Posts Tracking
function trackPopularPost(postId) {
    // In a real application, this would send analytics data
    console.log(`Popular post clicked: ${postId}`);
}

// Add click tracking to popular posts
document.querySelectorAll('.popular-post a').forEach(link => {
    link.addEventListener('click', function() {
        const postId = this.href.split('id=')[1];
        trackPopularPost(postId);
    });
});

// Responsive Menu for Blog (if needed)
function initializeResponsiveMenu() {
    const menuBtn = document.querySelector('.menu-btn');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuBtn && mainNav) {
        menuBtn.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
}

initializeResponsiveMenu();

// Lazy Loading for Blog Images (Performance Enhancement)
function initializeLazyLoading() {
    const blogImages = document.querySelectorAll('.blog-image img');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.style.opacity = '0';
                img.onload = () => {
                    img.style.transition = 'opacity 0.3s';
                    img.style.opacity = '1';
                };
                observer.unobserve(img);
            }
        });
    });
    
    blogImages.forEach(img => {
        imageObserver.observe(img);
    });
}

// Initialize lazy loading if supported
if ('IntersectionObserver' in window) {
    initializeLazyLoading();
}

// Reading Time Calculator (for future blog posts)
function calculateReadingTime(text) {
    const wordsPerMinute = 200;
    const words = text.trim().split(/\s+/).length;
    const readingTime = Math.ceil(words / wordsPerMinute);
    return readingTime;
}

// Search Suggestions (Enhanced Feature)
function initializeSearchSuggestions() {
    const searchInput = document.getElementById('blogSearch');
    if (!searchInput) return; // Exit if search input doesn't exist
    
    const suggestions = [
        'Umre rehberi', 'Kudüs seyahati', 'Türkiye turları',
        'Seyahat ipuçları', 'Mekke deneyimi', 'İstanbul rehberi',
        'Bütçe seyahati', 'Medine ziyareti'
    ];
    
    searchInput.addEventListener('focus', function() {
        // Create suggestions dropdown
        if (!document.querySelector('.search-suggestions')) {
            createSearchSuggestions(suggestions);
        }
    });
    
    searchInput.addEventListener('blur', function() {
        // Remove suggestions after a delay
        setTimeout(() => {
            const dropdown = document.querySelector('.search-suggestions');
            if (dropdown) {
                dropdown.remove();
            }
        }, 200);
    });
}

function createSearchSuggestions(suggestions) {
    const searchBox = document.querySelector('.search-box');
    const dropdown = document.createElement('div');
    dropdown.className = 'search-suggestions';
    
    dropdown.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    `;
    
    suggestions.forEach(suggestion => {
        const item = document.createElement('div');
        item.textContent = suggestion;
        item.style.cssText = `
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        `;
        
        item.addEventListener('mouseenter', function() {
            this.style.background = '#f9fafb';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
        
        item.addEventListener('click', function() {
            document.getElementById('blogSearch').value = suggestion;
            performSearch(suggestion);
            dropdown.remove();
        });
        
        dropdown.appendChild(item);
    });
    
    searchBox.style.position = 'relative';
    searchBox.appendChild(dropdown);
}

// Initialize search suggestions
initializeSearchSuggestions();

// Export functions for external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        filterBlogPosts,
        performSearch,
        sortBlogPosts,
        goToPage,
        calculateReadingTime
    };
}