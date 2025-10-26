# Quick Reference Guide

## 🚀 Fast Installation (3 Steps)

### 1. Create Theme Package
```powershell
cd c:\Users\kizol\OneDrive\Desktop\safwa
Compress-Archive -Path wordpress-theme -DestinationPath safwa-tourism.zip
```

### 2. Install in WordPress
- Login to WordPress admin
- Appearance → Themes → Add New → Upload Theme
- Upload `safwa-tourism.zip`
- Activate theme

### 3. Configure Permalinks
- Settings → Permalinks
- Select "Post name"
- Save Changes

**Done!** Your theme is now active.

---

## 📌 Quick Tasks

### Add a Banner (Homepage Slider)
```
Banner Slaytları → Yeni Banner Ekle
- Title: Your banner title
- Content: Description text
- Featured Image: Upload banner image
- Subtitle: Optional subtitle
- Button Text: e.g., "Explore Tours"
- Button Link: Link URL
- Features: One per line, format:
  fas fa-check Feature Name
  fas fa-star Another Feature
```

### Add a Tour
```
Turlar → Yeni Tur Ekle

Required:
- Title
- Description
- Featured Image
- Duration (days)
- Regular Price
- Category

Optional but Recommended:
- Sale Price & Discount
- Max People, Min Age
- Location
- Tour Type (umre/kudus/turkey/international)
- Difficulty (easy/moderate/difficult)
- Badge (new/popular/vip/special/family)
- Itinerary (day-by-day)
- Includes/Excludes lists
- Gallery images
```

### Add Blog Post
```
Posts → Add New
- Title
- Content
- Featured Image
- Category
- Tags
- Publish
```

### View Reservations
```
Rezervasyonlar → View all bookings
Check: Tour name, customer details, dates
```

### View Contact Messages
```
İletişim → View all messages
Check: Name, email, subject, message
```

---

## 🔑 Important URLs

After installation, your site structure:

```
Homepage:           https://yoursite.com/
Tours Archive:      https://yoursite.com/turlar/
Single Tour:        https://yoursite.com/turlar/tour-name/
Blog Archive:       https://yoursite.com/blog/
Single Post:        https://yoursite.com/blog/post-name/
Tour Category:      https://yoursite.com/tur-kategorisi/category-name/
```

---

## 📧 Email Setup (Important!)

For reliable email delivery, install SMTP plugin:

1. Install "WP Mail SMTP" plugin
2. Configure with your email provider:
   - Gmail
   - SendGrid
   - Mailgun
   - Your hosting SMTP

This ensures reservation and contact form emails are delivered properly.

---

## 🎨 Customize Contact Info

### Header Contact (header.php - Line ~29-30)
```php
<span><i class="fas fa-phone"></i> +90 555 123 45 67</span>
<span><i class="fas fa-envelope"></i> info@safwaturizm.com</span>
```

### Social Links (header.php - Line ~33-37)
```php
<a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
<a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
<a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
<a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
```

Replace `#` with your actual URLs.

### Footer Contact (footer.php - Line ~43-46)
```php
<li><i class="fas fa-map-marker-alt"></i> İstanbul, Türkiye</li>
<li><i class="fas fa-phone"></i> +90 555 123 45 67</li>
<li><i class="fas fa-envelope"></i> info@safwaturizm.com</li>
<li><i class="fas fa-clock"></i> Pzt-Cum: 09:00 - 18:00</li>
```

---

## 🐛 Quick Troubleshooting

### Tours not showing?
- Check if tours are published
- Go to Settings → Permalinks → Save Changes

### 404 errors on tour pages?
- Settings → Permalinks → Save Changes
- This flushes rewrite rules

### Forms not working?
- Check if emails are being sent (check spam)
- Install SMTP plugin for reliable email
- Check browser console for JavaScript errors

### Database tables not created?
- Deactivate theme
- Reactivate theme
- Tables will be created automatically

### Theme not appearing in list?
- Check folder is in /wp-content/themes/
- Ensure style.css has proper header
- Check file permissions

---

## 📱 Test Checklist

Before going live, test:

- [ ] Homepage loads with banners
- [ ] Tours page shows all tours
- [ ] Filters work on tours page
- [ ] Single tour page displays correctly
- [ ] Reservation form submits successfully
- [ ] Email notifications received
- [ ] Blog posts display properly
- [ ] Comments work
- [ ] Mobile responsive (test on phone)
- [ ] All menus navigate correctly
- [ ] Contact form works
- [ ] Social links go to correct pages

---

## 🎯 Essential Plugins

Recommended plugins to install:

1. **Yoast SEO** - Search engine optimization
2. **Wordfence Security** - Security protection
3. **UpdraftPlus** - Automatic backups
4. **WP Mail SMTP** - Reliable email delivery
5. **Smush** - Image optimization
6. **Contact Form 7** - Additional forms (optional)

---

## 💾 Backup Your Site

### Manual Backup:
1. Download entire WordPress directory via FTP
2. Export database from phpMyAdmin
3. Store both safely

### Plugin Backup:
1. Install UpdraftPlus
2. Configure backup schedule
3. Connect to cloud storage (Dropbox, Google Drive)

---

## 🎓 Common Tasks

### Change Site Title/Tagline:
Settings → General

### Upload Logo:
Appearance → Customize → Site Identity → Logo

### Create Menu:
Appearance → Menus → Create Menu → Assign Location

### Add Widget to Footer:
Appearance → Widgets (if you add widget areas)

### Change Theme Colors:
Edit `wordpress-theme/css/style.css`

### Modify Tour Card Layout:
Edit `wordpress-theme/css/pages.css`

---

## 📞 Admin Access

### To Access Admin:
```
https://yoursite.com/wp-admin
or
https://yoursite.com/wp-login.php
```

### Admin Menu Structure:
```
Dashboard
├── Posts (Blog)
├── Turlar (Tours)
├── Banner Slaytları (Banners)
├── Pages
├── Comments
├── Rezervasyonlar (Reservations)
├── İletişim (Contact Messages)
├── Appearance
│   ├── Themes
│   ├── Customize
│   └── Menus
├── Plugins
├── Users
└── Settings
```

---

## 🔐 Security Best Practices

1. Use strong passwords
2. Keep WordPress updated
3. Install Wordfence security plugin
4. Enable two-factor authentication
5. Regular backups
6. Limit login attempts
7. Use HTTPS (SSL certificate)
8. Hide WordPress version
9. Disable file editing in wp-config.php:
   ```php
   define('DISALLOW_FILE_EDIT', true);
   ```

---

## 🚀 Performance Optimization

1. Install caching plugin (WP Super Cache)
2. Optimize images before upload
3. Use CDN for assets
4. Enable Gzip compression
5. Minify CSS/JS
6. Use lazy loading for images
7. Optimize database
8. Use PHP 7.4 or higher

---

## 📊 Analytics Setup

### Google Analytics:
1. Create Google Analytics account
2. Get tracking code
3. Add to theme (header.php before </head>) or use plugin:
   - Install "Site Kit by Google"
   - Connect to Google Analytics

---

## ✅ Launch Checklist

Pre-launch tasks:

- [ ] All pages created and published
- [ ] At least 6-10 tours added
- [ ] Several blog posts published
- [ ] Menus configured
- [ ] Contact info updated
- [ ] Social media links updated
- [ ] Logo uploaded
- [ ] Favicon set
- [ ] SEO plugin configured
- [ ] Google Analytics installed
- [ ] Forms tested (reservation & contact)
- [ ] Mobile tested
- [ ] SSL certificate installed
- [ ] Backup system configured
- [ ] Email notifications working
- [ ] 404 page customized (optional)

---

## 📝 Content Tips

### Tour Descriptions:
- Highlight unique features
- Include all activities
- Mention accommodation quality
- List included meals
- Note any special requirements
- Add pricing transparency

### Blog Posts:
- Write helpful travel tips
- Share destination guides
- Post customer testimonials
- Publish travel news
- Share tour experiences

### Images:
- Use high-quality photos
- Optimize before upload (max 200KB)
- Add descriptive alt text
- Use landscape orientation for banners
- Consistent image sizes

---

## 🆘 Support Resources

- **WordPress Codex:** https://codex.wordpress.org/
- **WordPress Support:** https://wordpress.org/support/
- **Theme Documentation:** See README.md
- **Installation Guide:** See INSTALLATION.md

---

**Your theme is ready to deploy! Good luck! 🎉**
