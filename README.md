# Safwa Tourism Website

A modern, responsive tourism website specializing in Umre (pilgrimage), Jerusalem, Turkey, and international tours.

## Features

- 🎯 **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- 🖼️ **Dynamic Banner Slider** - Auto-playing image carousel with controls
- 🗂️ **Tour Categories** - Organized by Umre, Jerusalem, Turkey, and International tours  
- 📝 **Tour Application Form** - Complete booking form with validation
- 📞 **Contact System** - Multiple contact methods and contact form
- 📱 **Mobile-Friendly** - Optimized mobile navigation and layout
- ⚡ **Fast Loading** - Optimized performance and lazy loading
- 🎨 **Modern UI/UX** - Clean, professional Islamic-tourism theme

## Tour Categories

### Umre Tours
- 8-day Luxury Umre programs
- 10-day VIP Umre experiences  
- Family-friendly packages
- Starting from Istanbul

### Jerusalem Tours
- 5-day Jerusalem visits
- Three Mosques tour (Mecca-Medina-Jerusalem)
- Historical and religious sites
- Professional guided tours

### Turkey Tours
- Istanbul cultural tours
- Cappadocia balloon experiences
- Historical sites and museums
- Domestic travel packages

### International Tours
- Japan cultural tours
- Malaysia-Singapore packages
- Seasonal travel opportunities
- Custom international itineraries

## Technology Stack

- **HTML5** - Semantic markup and structure
- **CSS3** - Modern styling with Flexbox/Grid
- **JavaScript ES6** - Interactive functionality
- **Font Awesome** - Icon library
- **Google Fonts** - Typography (Poppins)

## Project Structure

```
safwa/
├── index.html          # Main HTML file
├── css/
│   └── style.css      # All CSS styles
├── js/
│   └── script.js      # JavaScript functionality
├── assets/            # Images and media files
│   ├── logo.png       # Company logo
│   └── [tour-images]  # Tour and promotional images
└── # Safwa Tourism Website

A complete tourism website for Safwa Tourism with modern design and comprehensive functionality.

## 🏗️ Project Structure

### Pages
- **index.html** - Homepage with banner slider, tours, blog, contact forms
- **tours.html** - Tours listing with filtering and search
- **tour-detail.html** - Individual tour details with booking form
- **blog.html** - Blog listing with categories and search
- **blog-detail.html** - Individual blog post with comments

### Stylesheets
- **css/style.css** - Main stylesheet with responsive design
- **css/pages.css** - Additional styles for listing pages
- **css/tour-detail.css** - Tour detail page specific styles
- **css/blog-detail.css** - Blog detail page specific styles

### JavaScript
- **js/script.js** - Main homepage functionality
- **js/tours.js** - Tours page interactions
- **js/tour-detail.js** - Tour detail functionality
- **js/blog.js** - Blog page features
- **js/blog-detail.js** - Blog detail interactions

## ✅ Features Completed

### 🎨 Design & Layout
- ✅ Modern, responsive design with Islamic tourism theme
- ✅ **FIXED**: Tour cards now display exactly 3 per row (no more flexible columns)
- ✅ **FIXED**: Blog cards now display exactly 3 per row with proper responsive breakdowns
- ✅ Consistent header across all pages
- ✅ Professional color scheme (Blue #1e3a8a, Green #10b981)
- ✅ Font Awesome icons and Google Fonts (Poppins)

### 🏠 Homepage
- ✅ Fixed navigation header with mobile menu
- ✅ Dynamic banner slider with 3 slides
- ✅ Tour categories with tabs (Umre, Kudüs, Turkey, International)
- ✅ Blog section with featured articles
- ✅ Contact and application forms with validation
- ✅ Complete footer with company information

### 🎫 Tours Section
- ✅ Tours listing page with filtering by category
- ✅ Search functionality
- ✅ Tour cards with ratings and quick booking
- ✅ Tour detail pages with:
  - Image gallery with thumbnails
  - Complete itinerary timeline
  - Hotel information
  - Reviews and ratings
  - **Integrated booking form as requested**
  - Share functionality

### 📝 Blog Section
- ✅ Blog listing with category filters
- ✅ Search and sorting capabilities
- ✅ Blog detail pages with:
  - Full article content
  - Table of contents
  - Author bio
  - Comments system
  - Related articles
  - Share buttons

### 📱 Responsive Design
- ✅ **Desktop**: 3 cards per row for tours and blog
- ✅ **Tablet (1024px)**: 2 cards per row
- ✅ **Mobile (768px)**: 1 card per row
- ✅ Mobile-first approach
- ✅ Touch-friendly navigation
- ✅ Optimized layouts for all screen sizes

### 🔧 Technical Features
- ✅ Cross-browser compatibility
- ✅ SEO-friendly structure
- ✅ Fast loading performance
- ✅ Accessibility improvements
- ✅ Form validation
- ✅ Interactive elements and animations

## 🚀 Recent Fixes Applied

### Layout Issues Resolved:
1. **Tour Grid Layout**: Changed from `repeat(auto-fit, minmax(350px, 1fr))` to `repeat(3, 1fr)` for exactly 3 cards per row
2. **Blog Grid Layout**: Applied same fix for consistent 3-column layout
3. **Header Consistency**: Standardized all pages to use `main-header` class
4. **Footer Styling**: Added proper `main-footer` styles for consistent footer across all pages
5. **Responsive Breakpoints**: Added proper responsive rules for 2 columns on tablet, 1 column on mobile

## 📂 File Organization

```
safwa/
├── index.html              # Homepage
├── tours.html              # Tours listing
├── tour-detail.html        # Tour details
├── blog.html               # Blog listing  
├── blog-detail.html        # Blog details
├── css/
│   ├── style.css          # Main styles
│   ├── pages.css          # Page-specific styles
│   ├── tour-detail.css    # Tour detail styles
│   └── blog-detail.css    # Blog detail styles
├── js/
│   ├── script.js          # Main JavaScript
│   ├── tours.js           # Tours functionality
│   ├── tour-detail.js     # Tour details JS
│   ├── blog.js            # Blog functionality
│   └── blog-detail.js     # Blog details JS
└── README.md              # This file
```

## 🎯 Ready for WordPress Conversion

The static website is now complete and ready for WordPress conversion with:
- Clean, semantic HTML structure
- Modular CSS architecture
- Component-based design
- Standard web practices
- Responsive layouts
- Interactive functionality

## 💻 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📞 Contact Information

**Safwa Tourism**
- 📧 Email: info@safwaturizm.com
- 📱 Phone: +90 212 555 0123
- 📍 Location: İstanbul, Türkiye

---

*Project completed with modern web standards and best practices for optimal user experience.*          # This file
```

## Setup Instructions

1. **Clone or Download**
   ```bash
   # Clone the repository or download the files
   git clone [repository-url]
   cd safwa
   ```

2. **File Organization**
   - Ensure all image files are in the `assets/` folder
   - The logo.png should be in the `assets/` directory
   - Tour images should follow the naming convention in HTML

3. **Local Development**
   - Open `index.html` in a modern web browser
   - For development, use a local server:
   ```bash
   # Using Python
   python -m http.server 8000
   
   # Using Node.js
   npx serve .
   
   # Using PHP
   php -S localhost:8000
   ```

4. **Customization**
   - Update contact information in `index.html`
   - Replace placeholder images in `assets/` folder
   - Modify tour details and pricing in HTML
   - Customize colors and branding in `css/style.css`

## Key Components

### Banner Slider
- Auto-playing image carousel (5-second intervals)
- Navigation dots and arrow controls
- Smooth transitions and animations
- Responsive image handling

### Tour Sections
- Tabbed interface for different tour categories
- Interactive tour cards with hover effects
- Pricing and promotional badges
- Detailed tour information display

### Forms
- **Tour Application Form** - Complete booking system
- **Contact Form** - General inquiries
- Real-time validation
- Success/error messaging
- Mobile-optimized inputs

### Navigation
- Fixed header with scroll effects
- Mobile hamburger menu
- Smooth scrolling to sections
- Social media integration

## Customization Guide

### Contact Information
Update these sections in `index.html`:
```html
<!-- Phone numbers -->
+90 216 594 54 58
+90 551 656 27 98

<!-- Email -->
info@safwaturism.com

<!-- Address -->
İstiklal Caddesi, No:62/57
Taksim, Beyoğlu, İstanbul
```

### Tour Prices
Modify tour pricing in the tour card sections:
```html
<div class="tour-price">
    <span class="old-price">$2000</span>
    <span class="current-price">$1750</span>
</div>
```

### Color Scheme
Primary colors in `css/style.css`:
```css
/* Primary Blue */
#1e3a8a

/* Secondary Blue */  
#3b82f6

/* Accent Gold */
#fbbf24
```

## Browser Support

- ✅ Chrome 80+
- ✅ Firefox 75+
- ✅ Safari 13+
- ✅ Edge 80+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Features

- Lazy loading for images
- Optimized CSS and JavaScript
- Smooth animations with CSS transforms
- Debounced scroll events
- Compressed and minified assets ready

## SEO Features

- Semantic HTML structure
- Meta descriptions and titles
- Alt text for all images
- Structured data ready
- Mobile-first responsive design

## Deployment

### GitHub Pages
1. Push to GitHub repository
2. Enable GitHub Pages in repository settings
3. Choose source branch (usually `main`)

### Web Hosting
1. Upload all files to web server
2. Ensure file permissions are correct
3. Test all functionality on live site

### WordPress Conversion (Next Phase)
The static website is designed for easy WordPress conversion:
- Semantic HTML structure
- Modular CSS organization  
- Separated content and presentation
- Form integration points prepared

## Future Enhancements

- [ ] WordPress theme conversion
- [ ] Online booking system integration
- [ ] Payment gateway integration
- [ ] Multi-language support (Turkish/English/Arabic)
- [ ] Tour search and filtering
- [ ] Customer testimonials system
- [ ] Blog management system
- [ ] Social media feed integration
- [ ] Live chat support
- [ ] Progressive Web App (PWA) features

## Support

For technical support or customization requests:
- Email: [your-email@example.com]
- Documentation: [link to docs]
- Issues: [link to issue tracker]

## License

This project is proprietary software developed for Safwa Tourism.
All rights reserved.

---

**Safwa Tourism** - Your trusted partner for spiritual and cultural journeys.
*Experience the journey of a lifetime with our professional tour services.*