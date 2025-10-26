# WordPress Theme Installation Guide

## Quick Installation Steps

### 1. Prepare Theme Package
You need to create a ZIP file of the wordpress-theme folder:

**On Windows:**
1. Open the folder: `c:\Users\kizol\OneDrive\Desktop\safwa\`
2. Right-click on `wordpress-theme` folder
3. Select "Send to" > "Compressed (zipped) folder"
4. Rename the zip to `safwa-tourism.zip`

**Alternative (using PowerShell):**
```powershell
cd c:\Users\kizol\OneDrive\Desktop\safwa
Compress-Archive -Path wordpress-theme -DestinationPath safwa-tourism.zip
```

### 2. Install WordPress
If you don't have WordPress installed yet:

**Local Development:**
- Use XAMPP, WAMP, or Local by Flywheel
- Download WordPress from wordpress.org
- Extract to your web server directory
- Create database
- Run WordPress installation at http://localhost/your-site

**Live Server:**
- Upload WordPress files via FTP
- Create MySQL database
- Run installation wizard
- Complete the 5-minute installation

### 3. Upload Theme

**Via WordPress Admin (Recommended):**
1. Login to WordPress admin (wp-admin)
2. Go to `Appearance` > `Themes`
3. Click `Add New`
4. Click `Upload Theme`
5. Choose `safwa-tourism.zip`
6. Click `Install Now`
7. Click `Activate`

**Via FTP:**
1. Connect to your server via FTP (FileZilla, WinSCP)
2. Navigate to `/wp-content/themes/`
3. Upload the entire `wordpress-theme` folder
4. Rename it to `safwa-tourism`
5. In WordPress admin, go to `Appearance` > `Themes`
6. Find "Safwa Tourism" and click `Activate`

### 4. Initial Setup After Activation

The theme will automatically:
- Create custom post types (Tours, Banners)
- Create database tables for reservations and contacts
- Register tour categories taxonomy

### 5. Configure Permalinks
**IMPORTANT:** Must be done first!
1. Go to `Settings` > `Permalinks`
2. Select "Post name" (recommended) or "Custom Structure": `/%postname%/`
3. Click `Save Changes`

### 6. Create Your First Banner (Homepage Slider)
1. Go to `Banner Slaytları` > `Yeni Banner Ekle`
2. Enter title: "Muhteşem Umre Deneyimi"
3. Add description in content area
4. Set Featured Image (main banner image)
5. Scroll down to "Banner Detayları":
   - Alt Başlık: "5 Yıldızlı Otellerde Konaklama"
   - Buton Metni: "Turları Keşfet"
   - Buton Linki: Enter tour archive URL
   - Özellikler (one per line):
     ```
     fas fa-check 5 Yıldızlı Oteller
     fas fa-user-tie Profesyonel Rehber
     fas fa-utensils Lezzetli Yemekler
     fas fa-plane Tam Bakım
     ```
6. Click `Publish`

### 7. Create Your First Tour
1. Go to `Turlar` > `Yeni Tur Ekle`
2. Enter tour title: "8 Günlük Lüks Umre Programı"
3. Add detailed description in content area
4. Set Featured Image

**Tour Details (Meta Box):**
- Süre: 8
- Maksimum Kişi: 50
- Minimum Yaş: 18
- Lokasyon: Mekke, Medine
- Tur Tipi: umre
- Zorluk Seviyesi: easy

**Pricing (Sidebar):**
- Normal Fiyat: 2500
- İndirimli Fiyat: 1999
- İndirim Oranı: 20
- Rozet: popular

**Itinerary (Add days one by one):**
- Day 1:
  - Başlık: İstanbul'dan Hareket
  - Açıklama: Havalimanında buluşma ve Cidde'ye hareket
  - Aktiviteler:
    ```
    Havalimanında check-in
    Uçuş
    Cidde'ye varış
    Otele transfer
    ```

**Includes:**
```
Gidiş-dönüş uçak bileti
5 yıldızlı otel konaklaması
3 öğün yemek
Rehberlik hizmeti
Vize işlemleri
Havalimanı transferleri
```

**Excludes:**
```
Kişisel harcamalar
Ek turlar
Sigortalar
Bahşişler
```

**Gallery:**
- Click "Resim Ekle"
- Select/upload multiple images
- Save

5. Assign "Umre" category (create if needed)
6. Click `Publish`

### 8. Create Menu
1. Go to `Appearance` > `Menus`
2. Create new menu: "Main Menu"
3. Add items:
   - Home (Custom Link: your homepage URL)
   - Tours (Select from Tours archive)
   - Blog (Select your blog page)
   - Create "Contact" page and add it
4. Save menu
5. Go to `Manage Locations`
6. Assign "Main Menu" to "Primary Menu"

### 9. Create Footer Menu
1. Create another menu: "Footer Menu"
2. Add pages and links
3. Assign to "Footer Menu" location

### 10. Create Pages

**Contact Page:**
1. `Pages` > `Add New`
2. Title: "İletişim"
3. Add contact form shortcode or contact info
4. Publish

**About Page:**
1. `Pages` > `Add New`
2. Title: "Hakkımızda"
3. Add your company info
4. Publish

### 11. Test Reservations
1. Visit a tour detail page
2. Fill out reservation form
3. Submit
4. Check `Rezervasyonlar` in admin menu
5. Check your email for notification

### 12. Customization

**Logo:**
- `Appearance` > `Customize` > `Site Identity`
- Upload logo

**Site Title:**
- `Settings` > `General`
- Update site title and tagline

**Contact Info:**
- Edit `header.php` and `footer.php`
- Update phone, email, address, social links

## Troubleshooting

### Theme Not Showing Up
- Check folder name in `/wp-content/themes/`
- Ensure `style.css` has theme header comments
- Check file permissions

### Database Tables Not Created
- Deactivate and reactivate theme
- Or manually run table creation from functions.php

### Forms Not Working
- Check AJAX URL in browser console
- Ensure nonce is being generated
- Check email settings in WordPress

### Images Not Displaying
- Regenerate thumbnails: Install "Regenerate Thumbnails" plugin
- Check image paths in templates

### Permalinks Showing 404
- Go to `Settings` > `Permalinks`
- Click `Save Changes` (don't change anything)
- This flushes rewrite rules

## File Structure

```
wordpress-theme/
├── style.css              (Theme header & main styles)
├── functions.php          (Theme functions, custom post types, AJAX)
├── header.php            (Site header, navigation)
├── footer.php            (Site footer)
├── index.php             (Default template)
├── front-page.php        (Homepage with banners, featured tours)
├── page.php              (Static pages)
├── archive.php           (Blog listing)
├── single.php            (Blog post detail)
├── archive-tour.php      (Tours listing with filters)
├── single-tour.php       (Tour detail with booking)
├── comments.php          (Comments template)
├── README.md             (Documentation)
├── css/
│   ├── style.css         (Main styles)
│   ├── pages.css         (Tours, blog styles)
│   ├── tour-detail.css   (Tour detail styles)
│   └── blog-detail.css   (Blog detail styles)
├── js/
│   ├── script.js         (Main JavaScript)
│   ├── tours.js          (Tour filters)
│   ├── tour-detail.js    (Tour detail interactions)
│   ├── blog.js           (Blog page)
│   └── blog-detail.js    (Blog detail)
└── assets/
    ├── images/           (Theme images)
    └── logo.png          (Default logo)
```

## Next Steps After Installation

1. Add more tours (at least 6-10 for a good showcase)
2. Add blog posts (travel tips, destination guides)
3. Create additional pages (About, Contact, Terms, Privacy)
4. Configure email settings for form notifications
5. Install recommended plugins:
   - Contact Form 7 or WPForms (alternative contact forms)
   - Yoast SEO (search engine optimization)
   - Wordfence (security)
   - UpdraftPlus (backups)
6. Test on mobile devices
7. Optimize images (use compression plugins)
8. Set up Google Analytics
9. Configure caching (WP Super Cache or W3 Total Cache)
10. Go live!

## Support & Updates

Remember to:
- Keep WordPress updated
- Keep theme files backed up
- Test changes on staging environment first
- Monitor reservation and contact submissions regularly

---

Your WordPress theme is now ready to use! 🎉
