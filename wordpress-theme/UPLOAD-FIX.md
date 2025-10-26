# Fix WordPress Theme Upload Size Limit

## Error: "POST Content-Length exceeds the limit"

Your theme is too large for the current PHP upload limits. Here are multiple solutions:

---

## Solution 1: Increase PHP Limits (XAMPP/WAMP)

### For XAMPP:

1. **Locate php.ini file:**
   - Open XAMPP Control Panel
   - Click "Config" next to Apache
   - Select "PHP (php.ini)"

2. **Edit these values:**
   Find and change these lines:
   ```ini
   upload_max_filesize = 128M
   post_max_size = 128M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 256M
   ```

3. **Save the file**

4. **Restart Apache:**
   - In XAMPP Control Panel
   - Stop Apache
   - Start Apache again

5. **Try uploading theme again**

---

## Solution 2: Manual Theme Installation via FTP (Easiest!)

Skip the upload limit completely by copying files directly:

### Steps:

1. **Close the browser upload page**

2. **Navigate to your WordPress themes folder:**
   ```
   For XAMPP: C:\xampp\htdocs\safwa-tourism\wp-content\themes\
   For WAMP: C:\wamp64\www\safwa-tourism\wp-content\themes\
   For Local: Right-click site → "Go to site folder" → app\public\wp-content\themes\
   ```

3. **Copy the theme folder:**
   - Copy the entire `wordpress-theme` folder
   - Paste it into the themes directory
   - Rename it to `safwa-tourism` (optional, but cleaner)

4. **Activate theme:**
   - Go to WordPress admin: `http://localhost/safwa-tourism/wp-admin`
   - Go to: Appearance → Themes
   - You'll see "Safwa Tourism" theme
   - Click "Activate"

**Done! No upload needed!**

---

## Solution 3: Reduce Theme Size

The theme is large because of the assets folder. Let's create a lighter version:

### Remove unnecessary files:

```powershell
# Navigate to theme folder
cd c:\Users\kizol\OneDrive\Desktop\safwa\wordpress-theme

# Remove large images (you can re-upload them later)
Remove-Item -Path assets\images\* -Include *.jpg,*.png -Recurse

# Create new ZIP
cd ..
Compress-Archive -Path wordpress-theme -DestinationPath safwa-tourism-lite.zip -Force
```

Then try uploading `safwa-tourism-lite.zip`

---

## Solution 4: Create .htaccess in WordPress Root

Add this to your WordPress `.htaccess` file:

```apache
php_value upload_max_filesize 128M
php_value post_max_size 128M
php_value max_execution_time 300
php_value max_input_time 300
```

---

## Solution 5: Create .user.ini File

Create a file named `.user.ini` in your WordPress root directory with:

```ini
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

---

## Quick PowerShell Commands

### Check current PHP limits:
```powershell
# For XAMPP
Get-Content C:\xampp\php\php.ini | Select-String "upload_max_filesize"
Get-Content C:\xampp\php\php.ini | Select-String "post_max_size"
```

### Copy theme directly (bypasses upload):
```powershell
# For XAMPP
Copy-Item -Path "c:\Users\kizol\OneDrive\Desktop\safwa\wordpress-theme" -Destination "C:\xampp\htdocs\YOUR-SITE-NAME\wp-content\themes\safwa-tourism" -Recurse -Force

# For Local by Flywheel - find your site folder first
# Right-click site in Local → "Reveal in Explorer"
```

---

## Recommended Solution: Direct Copy

**This is the fastest and easiest method:**

1. Open File Explorer
2. Navigate to: `c:\Users\kizol\OneDrive\Desktop\safwa\`
3. Copy the `wordpress-theme` folder
4. Navigate to your WordPress installation:
   - XAMPP: `C:\xampp\htdocs\YOUR-SITE\wp-content\themes\`
   - Local: Find via Local app → Right-click site → "Go to site folder" → `app\public\wp-content\themes\`
5. Paste the folder
6. Rename to `safwa-tourism`
7. Go to WordPress admin → Appearance → Themes → Activate

**No upload limits, no waiting, instant!**

---

## Verify PHP Settings in WordPress

After changing php.ini, verify settings:

1. In WordPress admin, go to: Tools → Site Health → Info
2. Expand "Server" section
3. Check these values:
   - upload_max_filesize
   - post_max_size
   - max_execution_time

---

## For Local by Flywheel Users

Local uses its own PHP configuration:

1. Right-click your site in Local
2. Click "Open Site Shell"
3. Type: `php -i | grep upload`
4. To change limits, right-click site → Utilities → Edit PHP Settings

---

## Still Having Issues?

**Use the direct copy method - it never fails!**

Just copy the theme folder directly to:
`wp-content/themes/`

Then activate it in WordPress admin.
