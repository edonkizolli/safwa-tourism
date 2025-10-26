# WordPress Local Installation Guide - Fix Database Error

## Quick Fix for Database Connection Error

### Step 1: Install Local Development Environment

**Option A: XAMPP (Recommended)**
1. Download XAMPP from: https://www.apachefriends.org/
2. Install XAMPP (default settings are fine)
3. Start XAMPP Control Panel
4. Start "Apache" and "MySQL" services

**Option B: Local by Flywheel (Easier)**
1. Download from: https://localwp.com/
2. Install and create new site
3. It handles everything automatically!

---

## Step 2: Create Database (XAMPP Method)

### Using phpMyAdmin:

1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click "New" in the left sidebar
3. Database name: `safwa_tourism`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

**Database credentials for XAMPP default:**
- Database Name: `safwa_tourism`
- Username: `root`
- Password: (leave empty)
- Database Host: `localhost`

---

## Step 3: Install WordPress

### Download WordPress:
1. Go to: https://wordpress.org/download/
2. Download latest version
3. Extract the ZIP file

### Place WordPress Files:

**For XAMPP:**
- Extract WordPress to: `C:\xampp\htdocs\safwa-tourism`

**For WAMP:**
- Extract WordPress to: `C:\wamp64\www\safwa-tourism`

---

## Step 4: Configure wp-config.php

### Method 1: During Installation
1. Open browser: `http://localhost/safwa-tourism`
2. Click "Let's go!"
3. Enter database details:
   - Database Name: `safwa_tourism`
   - Username: `root`
   - Password: (leave empty for XAMPP)
   - Database Host: `localhost`
   - Table Prefix: `wp_`
4. Click "Submit"

### Method 2: Manual Configuration
If the installer doesn't work, create wp-config.php manually:

1. In WordPress folder, find `wp-config-sample.php`
2. Rename it to `wp-config.php`
3. Edit with notepad and update these lines:

```php
// ** Database settings ** //
define( 'DB_NAME', 'safwa_tourism' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );  // Empty for XAMPP default
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );
```

4. Save the file

---

## Step 5: Complete WordPress Installation

1. Open: `http://localhost/safwa-tourism`
2. You should see WordPress installation screen
3. Fill in:
   - Site Title: `Safwa Tourism`
   - Username: `admin` (or your choice)
   - Password: (create strong password)
   - Email: your email
4. Click "Install WordPress"

---

## Step 6: Install Theme

After WordPress is installed:

1. Login to admin: `http://localhost/safwa-tourism/wp-admin`
2. Go to: **Appearance → Themes → Add New → Upload Theme**
3. Upload the theme ZIP file
4. Activate it

---

## Troubleshooting Common Issues

### Error: "Can't connect to MySQL server"

**Solution 1: Start MySQL Service**
- Open XAMPP Control Panel
- Click "Start" next to MySQL
- Wait for it to turn green

**Solution 2: Check Port Conflicts**
- MySQL uses port 3306
- If occupied, change in XAMPP config or stop conflicting service

**Solution 3: Restart XAMPP**
- Stop all services
- Close XAMPP
- Reopen and start Apache + MySQL

---

### Error: "Access denied for user 'root'@'localhost'"

**Solution: Reset MySQL Password**

1. Stop MySQL in XAMPP
2. Open XAMPP Control Panel
3. Click "Config" → "my.ini"
4. Find `[mysqld]` section
5. Add below it: `skip-grant-tables`
6. Save and restart MySQL
7. Open phpMyAdmin
8. Go to SQL tab and run:
```sql
UPDATE mysql.user SET Password=PASSWORD('') WHERE User='root';
FLUSH PRIVILEGES;
```
9. Remove `skip-grant-tables` from my.ini
10. Restart MySQL

---

### Error: Database does not exist

**Solution: Create Database**

1. Open: `http://localhost/phpmyadmin`
2. Click "New" on left sidebar
3. Create database: `safwa_tourism`
4. Try WordPress installation again

---

## Alternative: Use Local by Flywheel (Easiest)

This is the simplest option - it handles everything:

1. Download: https://localwp.com/
2. Install Local
3. Click "+" to create new site
4. Site name: `safwa-tourism`
5. Choose environment (latest versions)
6. Set username/password
7. Click "Add Site"
8. Wait for it to provision
9. Click "WP Admin" to access admin panel
10. Upload and activate theme

**Benefits:**
- No manual database setup
- No Apache/MySQL configuration
- One-click site creation
- Easy to manage multiple sites

---

## Quick Command Reference

### Create Database via Command Line (Advanced):

```powershell
# Navigate to MySQL bin
cd C:\xampp\mysql\bin

# Login to MySQL
.\mysql.exe -u root

# Create database
CREATE DATABASE safwa_tourism CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Show databases
SHOW DATABASES;

# Exit
EXIT;
```

---

## WordPress Installation Checklist

- [ ] Local server installed (XAMPP/Local)
- [ ] Apache and MySQL services running
- [ ] Database created (`safwa_tourism`)
- [ ] WordPress files extracted to htdocs/www
- [ ] wp-config.php configured with correct credentials
- [ ] WordPress installation completed
- [ ] Logged into wp-admin
- [ ] Theme ZIP ready to upload

---

## After Installation

Once WordPress is running:

1. **Configure Permalinks:**
   - Settings → Permalinks → Post name → Save

2. **Upload Theme:**
   - Appearance → Themes → Add New → Upload
   - Choose `safwa-tourism.zip`
   - Activate

3. **Create Content:**
   - Add banners
   - Add tours
   - Add blog posts

---

## Need Help?

**Check MySQL is Running:**
```powershell
# In PowerShell
netstat -ano | findstr :3306
```
If you see output, MySQL is running.

**Check Apache is Running:**
```powershell
netstat -ano | findstr :80
```
If you see output, Apache is running.

---

## Recommended: Use Local by Flywheel

For the easiest setup with zero configuration:
1. Download: https://localwp.com/
2. Install and create site
3. Everything works automatically
4. Upload theme and start building!

This eliminates all database connection issues! 🎉
