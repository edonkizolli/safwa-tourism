# Safwa Tourism WordPress Theme

A professional WordPress theme for tourism and travel agencies, featuring dynamic content management for tours, blog posts, banners, and reservations.

## Features

- **Custom Post Types:**
  - Tours (with custom taxonomies, meta fields, gallery)
  - Banners/Slides (for homepage hero section)
  
- **Tour Management:**
  - Pricing (regular & sale prices)
  - Duration, location, difficulty level
  - Maximum people, minimum age
  - Tour type (Umre, Kudüs, Turkey, International)
  - Day-by-day itinerary builder
  - Includes/Excludes lists
  - Image gallery
  - Tour categories and filtering
  
- **Dynamic Features:**
  - Banner/Slider with custom fields
  - Tour listing with advanced filters
  - Blog with categories, tags, and comments
  - Reservation system with database storage
  - Contact form with email notifications
  - AJAX form submissions
  
- **Responsive Design:**
  - Mobile-first approach
  - Custom select dropdowns
  - Optimized for all devices
  
## Installation

### 1. WordPress Setup

1. Install WordPress on your server or local environment
2. Access WordPress admin panel (wp-admin)

### 2. Theme Installation

**Option A: Upload via WordPress Admin**
1. Go to `Appearance > Themes > Add New`
2. Click `Upload Theme`
3. Upload the `wordpress-theme` folder as a zip file
4. Activate the theme

**Option B: FTP Upload**
1. Connect to your server via FTP
2. Navigate to `/wp-content/themes/`
3. Upload the entire `wordpress-theme` folder
4. Rename it to `safwa-tourism` (optional)
5. Go to WordPress admin: `Appearance > Themes`
6. Activate "Safwa Tourism" theme

### 3. Initial Configuration

After activating the theme, the following will be automatically created:
- Custom post types (Tours, Banners)
- Database tables for reservations and contact forms
- Tour categories taxonomy

### 4. Setup Steps

1. **Create Menus:**
   - Go to `Appearance > Menus`
   - Create a menu for "Primary Menu"
   - Add pages: Home, Tours, Blog, Contact
   - Assign to "Primary Menu" location
   - Create another menu for "Footer Menu"

2. **Set Homepage:**
   - Go to `Settings > Reading`
   - Select "A static page"
   - Choose your homepage or let it use Front Page template

3. **Add Banners (Homepage Slider):**
   - Go to `Banner Slaytları > Yeni Banner Ekle`
   - Add title, content, featured image
   - Fill in banner details:
     - Subtitle
     - Button text and link
     - Features (format: `fas fa-check Feature Name` - one per line)
   - Publish

4. **Add Tours:**
   - Go to `Turlar > Yeni Tur Ekle`
   - Add tour title and description
   - Set featured image (main tour image)
   - Fill in tour details:
     - Duration (days)
     - Max people, min age
     - Location
     - Tour type (Umre, Kudüs, Turkey, International)
     - Difficulty level
   - Set pricing:
     - Regular price
     - Sale price (optional)
     - Discount percentage
     - Badge (New, Popular, VIP, Special, Family)
   - Add itinerary (day-by-day program)
   - Add includes/excludes lists (one per line)
   - Add gallery images
   - Assign tour category
   - Publish

5. **Add Blog Posts:**
   - Go to `Posts > Add New`
   - Write your blog post
   - Set featured image
   - Assign categories and tags
   - Publish

### 5. Permalinks

For clean URLs, configure permalinks:
1. Go to `Settings > Permalinks`
2. Select "Post name" structure
3. Save changes

## Theme Customization

### Logo Upload
1. Go to `Appearance > Customize > Site Identity`
2. Upload your logo
3. If no logo is uploaded, site name will be displayed

### Colors & Styling
- Edit `wordpress-theme/css/style.css` for global styles
- Edit `wordpress-theme/css/pages.css` for tours and blog pages
- Edit `wordpress-theme/css/tour-detail.css` for tour detail pages
- Edit `wordpress-theme/css/blog-detail.css` for blog detail pages

### Contact Information
Update header and footer contact info by editing:
- `wordpress-theme/header.php`
- `wordpress-theme/footer.php`

### Social Media Links
Update social links in header and footer files with your actual URLs.

## Managing Content

### View Reservations
- Go to `Rezervasyonlar` in admin menu
- View all tour reservations with customer details
- Check tour name, date, number of people, status

### View Contact Messages
- Go to `İletişim` in admin menu
- View all contact form submissions
- See name, email, phone, subject, and message

## Database Tables

The theme creates two custom tables:
- `wp_safwa_contacts` - Contact form submissions
- `wp_safwa_reservations` - Tour reservations

## Template Files

- `front-page.php` - Homepage with banners and featured tours
- `archive-tour.php` - Tours listing with filters
- `single-tour.php` - Individual tour detail page
- `archive.php` - Blog listing
- `single.php` - Individual blog post
- `page.php` - Static pages
- `header.php` - Site header
- `footer.php` - Site footer
- `comments.php` - Comments template
- `functions.php` - Theme functions and features

## AJAX Features

### Contact Form
- AJAX submission without page reload
- Email notification to admin
- Success/error messages

### Reservation Form
- AJAX submission
- Email to admin and customer
- Stored in database
- Real-time price calculation

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Support

For issues or questions:
- Check WordPress debug log
- Ensure PHP 7.4+ is installed
- Check file permissions
- Verify database tables were created

## Credits

- Font Awesome 6.4.0 for icons
- Google Fonts (Poppins)
- Custom CSS and JavaScript

## Version

Version: 1.0.0
Last Updated: January 2025

---

**Note:** This theme is designed for the Safwa Tourism website. All features including tours, reservations, and contact forms are fully functional and ready to use.
