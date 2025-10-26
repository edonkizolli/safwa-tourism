// Blog Detail Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeBlogDetail();
});

function initializeBlogDetail() {
    initializeTableOfContents();
    initializeReadingProgress();
    initializeComments();
    initializeNewsletterForm();
    initializeShareButtons();
    initializeSmoothScrolling();
    trackReadingTime();
}

// Table of Contents Navigation
function initializeTableOfContents() {
    const tocLinks = document.querySelectorAll('.table-of-contents a');
    
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.querySelector(`#${targetId}`) || 
                                document.querySelector(`h2, h3`);
            
            if (targetElement) {
                const headerHeight = 140;
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Highlight active section in TOC
    window.addEventListener('scroll', updateActiveTocItem);
}

function updateActiveTocItem() {
    const tocLinks = document.querySelectorAll('.table-of-contents a');
    const headings = document.querySelectorAll('.article-text h2, .article-text h3');
    
    let currentHeading = '';
    
    headings.forEach(heading => {
        const headingTop = heading.offsetTop - 200;
        if (window.scrollY >= headingTop) {
            currentHeading = heading.id || heading.textContent.toLowerCase().replace(/\s+/g, '-');
        }
    });
    
    tocLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href').substring(1);
        if (href === currentHeading) {
            link.classList.add('active');
        }
    });
}

// Reading Progress Indicator
function initializeReadingProgress() {
    const progressBar = document.createElement('div');
    progressBar.className = 'reading-progress';
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, #1e3a8a, #10b981);
        z-index: 9999;
        transition: width 0.3s ease;
    `;
    
    document.body.appendChild(progressBar);
    
    window.addEventListener('scroll', updateReadingProgress);
}

function updateReadingProgress() {
    const article = document.querySelector('.article-text');
    if (!article) return;
    
    const articleTop = article.offsetTop;
    const articleHeight = article.offsetHeight;
    const windowHeight = window.innerHeight;
    const scrollTop = window.scrollY;
    
    const articleStart = articleTop - windowHeight;
    const articleEnd = articleTop + articleHeight;
    
    if (scrollTop >= articleStart && scrollTop <= articleEnd) {
        const progress = ((scrollTop - articleStart) / (articleEnd - articleStart)) * 100;
        const progressBar = document.querySelector('.reading-progress');
        progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
    }
}

// Comments System
function initializeComments() {
    const commentForm = document.querySelector('.comment-form form');
    const likeButtons = document.querySelectorAll('.like-btn');
    const replyButtons = document.querySelectorAll('.reply-btn');
    const loadMoreBtn = document.querySelector('.load-more-comments');
    
    // Comment form submission
    if (commentForm) {
        commentForm.addEventListener('submit', handleCommentSubmit);
    }
    
    // Like buttons
    likeButtons.forEach(btn => {
        btn.addEventListener('click', handleLikeComment);
    });
    
    // Reply buttons
    replyButtons.forEach(btn => {
        btn.addEventListener('click', handleReplyComment);
    });
    
    // Load more comments
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', loadMoreComments);
    }
}

function handleCommentSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const name = this.querySelector('input[type="text"]').value.trim();
    const email = this.querySelector('input[type="email"]').value.trim();
    const comment = this.querySelector('textarea').value.trim();
    
    if (!name || !email || !comment) {
        showMessage('Lütfen tüm alanları doldurun.', 'error');
        return;
    }
    
    if (!validateEmail(email)) {
        showMessage('Lütfen geçerli bir e-posta adresi giriniz.', 'error');
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('.submit-btn');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Gönderiliyor...';
    submitBtn.disabled = true;
    
    // Simulate comment submission
    setTimeout(() => {
        // Create new comment element
        const newComment = createCommentElement(name, comment);
        const commentsList = document.querySelector('.comments-list');
        commentsList.insertBefore(newComment, commentsList.firstChild);
        
        // Update comment count
        updateCommentCount();
        
        // Reset form
        this.reset();
        
        // Show success message
        showMessage('Yorumunuz başarıyla gönderildi!', 'success');
        
        // Reset button
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        // Scroll to new comment
        newComment.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 2000);
}

function createCommentElement(name, comment) {
    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment';
    
    const now = new Date();
    const timeAgo = 'Az önce';
    
    commentDiv.innerHTML = `
        <div class="comment-avatar">
            <img src="images/default-avatar.jpg" alt="${name}">
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <h5>${name}</h5>
                <span class="comment-date">${timeAgo}</span>
            </div>
            <p>${comment}</p>
            <div class="comment-actions">
                <button class="like-btn"><i class="fas fa-thumbs-up"></i> 0</button>
                <button class="reply-btn">Yanıtla</button>
            </div>
        </div>
    `;
    
    // Add event listeners to new comment
    const likeBtn = commentDiv.querySelector('.like-btn');
    const replyBtn = commentDiv.querySelector('.reply-btn');
    
    likeBtn.addEventListener('click', handleLikeComment);
    replyBtn.addEventListener('click', handleReplyComment);
    
    return commentDiv;
}

function handleLikeComment(e) {
    const btn = e.currentTarget;
    const currentLikes = parseInt(btn.textContent.split(' ')[1] || 0);
    const newLikes = currentLikes + 1;
    
    btn.innerHTML = `<i class="fas fa-thumbs-up"></i> ${newLikes}`;
    btn.style.color = '#10b981';
    btn.disabled = true;
    
    // Animation
    btn.style.transform = 'scale(0.9)';
    setTimeout(() => {
        btn.style.transform = 'scale(1)';
    }, 150);
}

function handleReplyComment(e) {
    const comment = e.currentTarget.closest('.comment');
    const existingForm = comment.querySelector('.reply-form');
    
    if (existingForm) {
        existingForm.remove();
        return;
    }
    
    const replyForm = document.createElement('div');
    replyForm.className = 'reply-form';
    replyForm.style.cssText = `
        margin-top: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
    `;
    
    replyForm.innerHTML = `
        <form>
            <div class="form-group">
                <textarea placeholder="Yanıtınızı yazın..." rows="3" required style="width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; resize: vertical;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button type="submit" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Yanıtla</button>
                <button type="button" class="cancel-reply" style="background: #6b7280; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">İptal</button>
            </div>
        </form>
    `;
    
    comment.appendChild(replyForm);
    
    // Focus on textarea
    replyForm.querySelector('textarea').focus();
    
    // Handle form submission
    replyForm.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const replyText = this.querySelector('textarea').value.trim();
        if (replyText) {
            showMessage('Yanıtınız gönderildi!', 'success');
            replyForm.remove();
        }
    });
    
    // Handle cancel
    replyForm.querySelector('.cancel-reply').addEventListener('click', function() {
        replyForm.remove();
    });
}

function loadMoreComments() {
    const btn = this;
    const originalText = btn.textContent;
    
    btn.textContent = 'Yükleniyor...';
    btn.disabled = true;
    
    // Simulate loading
    setTimeout(() => {
        // For demo, just hide the button
        btn.style.display = 'none';
        showMessage('Tüm yorumlar yüklendi.', 'info');
    }, 1500);
}

function updateCommentCount() {
    const commentsTitle = document.querySelector('.comments-section h3');
    const currentCount = parseInt(commentsTitle.textContent.match(/\d+/)[0]);
    const newCount = currentCount + 1;
    commentsTitle.textContent = `Yorumlar (${newCount})`;
}

// Newsletter Form
function initializeNewsletterForm() {
    const newsletterForms = document.querySelectorAll('.newsletter-form');
    
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value.trim();
            
            if (validateEmail(email)) {
                const btn = this.querySelector('button');
                const originalText = btn.textContent;
                
                btn.textContent = 'Kaydediliyor...';
                btn.disabled = true;
                
                setTimeout(() => {
                    showMessage('Başarıyla abone oldunuz!', 'success');
                    emailInput.value = '';
                    btn.textContent = originalText;
                    btn.disabled = false;
                }, 1500);
            } else {
                showMessage('Geçerli bir e-posta adresi giriniz.', 'error');
            }
        });
    });
}

// Share Functions
function initializeShareButtons() {
    // Share button events are handled by onclick attributes in HTML
}

function shareOnFacebook() {
    const url = window.location.href;
    const title = document.querySelector('h1').textContent;
    const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}&quote=${encodeURIComponent(title)}`;
    openShareWindow(facebookUrl);
}

function shareOnTwitter() {
    const url = window.location.href;
    const title = document.querySelector('h1').textContent;
    const twitterUrl = `https://twitter.intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}`;
    openShareWindow(twitterUrl);
}

function shareOnWhatsApp() {
    const url = window.location.href;
    const title = document.querySelector('h1').textContent;
    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
    openShareWindow(whatsappUrl);
}

function copyToClipboard() {
    const url = window.location.href;
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            showMessage('Link kopyalandı!', 'success');
        });
    } else {
        // Fallback
        const textArea = document.createElement('textarea');
        textArea.value = url;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showMessage('Link kopyalandı!', 'success');
    }
}

function openShareWindow(url) {
    window.open(url, '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
}

// Smooth Scrolling for all internal links
function initializeSmoothScrolling() {
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerHeight = 140;
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Reading Time Tracker
function trackReadingTime() {
    let startTime = Date.now();
    let totalTime = 0;
    let isReading = true;
    
    // Track when user leaves/returns to page
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (isReading) {
                totalTime += Date.now() - startTime;
                isReading = false;
            }
        } else {
            startTime = Date.now();
            isReading = true;
        }
    });
    
    // Track reading completion
    window.addEventListener('beforeunload', function() {
        if (isReading) {
            totalTime += Date.now() - startTime;
        }
        
        const readingTimeMinutes = Math.round(totalTime / 60000);
        
        // In a real application, you would send this data to analytics
        console.log(`Reading time: ${readingTimeMinutes} minutes`);
        
        // Store in localStorage for demo
        localStorage.setItem('lastReadingTime', readingTimeMinutes);
    });
}

// Utility Functions
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showMessage(message, type = 'info') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message-toast ${type}`;
    messageDiv.textContent = message;
    
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        info: '#3b82f6',
        warning: '#f59e0b'
    };
    
    messageDiv.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: ${colors[type]};
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        z-index: 10000;
        font-weight: 500;
        font-size: 14px;
        max-width: 300px;
        animation: slideInRight 0.3s ease-out;
        cursor: pointer;
    `;
    
    document.body.appendChild(messageDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        messageDiv.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.parentNode.removeChild(messageDiv);
            }
        }, 300);
    }, 5000);
    
    // Remove on click
    messageDiv.addEventListener('click', function() {
        this.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (this.parentNode) {
                this.parentNode.removeChild(this);
            }
        }, 300);
    });
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .table-of-contents a.active {
        background: #f0fdf4 !important;
        color: #10b981 !important;
        padding-left: 20px !important;
        border-left: 3px solid #10b981;
    }
`;
document.head.appendChild(style);

// Print functionality
function printArticle() {
    const printContent = document.querySelector('.article-content').innerHTML;
    const printWindow = window.open('', '_blank');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>${document.title}</title>
            <style>
                body { font-family: 'Poppins', sans-serif; line-height: 1.6; color: #333; }
                .content-wrapper { padding: 20px; }
                h1, h2, h3 { color: #1e3a8a; }
                .article-share, .article-tags { display: none; }
            </style>
        </head>
        <body>
            ${printContent}
        </body>
        </html>
    `);
    
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}

// Initialize font size features
// Font size controls removed

// Export functions for external use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        shareOnFacebook,
        shareOnTwitter,
        shareOnWhatsApp,
        copyToClipboard,
        printArticle
    };
}