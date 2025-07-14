# 🚨 TROUBLESHOOTING: PHP Spark Serve Issues

## Masalah yang Sering Terjadi

### 1. **`php spark serve` tidak berfungsi di Windows**

#### **Penyebab:**
- PowerShell syntax berbeda dengan Command Prompt
- CodeIgniter CLI issues
- Port conflicts
- Permission issues

#### **Solusi A: Menggunakan Built-in PHP Server**
```bash
# Buka Command Prompt atau PowerShell
cd c:\xampp\htdocs\simaklah-main\app-murid
php -S localhost:9000 -t public
```

#### **Solusi B: Menggunakan Batch Launcher**
1. Double-click file `run-app-simple.bat`
2. Pilih metode launch
3. Masukkan port yang diinginkan

#### **Solusi C: PowerShell Script**
```powershell
# Buka PowerShell as Administrator
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
.\run-app-murid.ps1
```

---

## 🔧 Quick Fix Commands

### **Method 1: Automatic Fix**
```bash
# Jalankan diagnostic tool
php diagnostic-server.php

# Jalankan fix script
php fix-issues.php
```

### **Method 2: Manual Steps**

#### 1. **Navigate to Correct Directory**
```bash
cd c:\xampp\htdocs\simaklah-main\app-murid
dir  # Pastikan ada file 'spark' dan folder 'public'
```

#### 2. **Check PHP and CodeIgniter**
```bash
php --version
php spark --version
php spark list
```

#### 3. **Create .env File (if missing)**
```bash
copy env .env
```

#### 4. **Fix Permissions (Windows)**
```bash
# Buka Properties folder writable -> Security -> Edit -> Full Control
icacls writable /grant Everyone:F /T
```

#### 5. **Clear Cache**
```bash
rmdir /s writable\cache
rmdir /s writable\logs
mkdir writable\cache
mkdir writable\logs
```

---

## 🚀 Alternative Launch Methods

### **Method 1: Built-in PHP Server (Recommended)**
```bash
php -S localhost:9000 -t public
```
✅ **Pros:** Always works, simple
❌ **Cons:** Basic features only

### **Method 2: CodeIgniter Spark Serve**
```bash
php spark serve --port=9000 --host=localhost
```
✅ **Pros:** Full CodeIgniter features
❌ **Cons:** Sometimes fails on Windows

### **Method 3: XAMPP Virtual Host**
1. Edit `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Add:
```apache
<VirtualHost *:80>
    DocumentRoot "c:/xampp/htdocs/simaklah-main/app-murid/public"
    ServerName app-murid.local
    <Directory "c:/xampp/htdocs/simaklah-main/app-murid/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
3. Edit `C:\Windows\System32\drivers\etc\hosts`
4. Add: `127.0.0.1 app-murid.local`
5. Restart Apache
6. Access: `http://app-murid.local`

---

## 📊 Port Conflict Solutions

### **Check Port Usage**
```bash
netstat -ano | findstr :9000
netstat -ano | findstr :8080
```

### **Kill Process Using Port**
```bash
# Find PID from netstat output
taskkill /PID <PID_NUMBER> /F
```

### **Use Alternative Ports**
```bash
php -S localhost:9001 -t public
php -S localhost:9002 -t public
php -S localhost:3000 -t public
```

---

## 🛠 Environment Issues

### **Fix Database Connection**
Edit `.env` file:
```ini
database.default.hostname = localhost
database.default.database = simaklah_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### **Fix Base URL**
Edit `app/Config/App.php`:
```php
public string $baseURL = '';  // Auto-detect
```

### **Fix Session Issues**
Edit `.env` file:
```ini
session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
session.savePath = 'writable/session'
```

---

## 📱 Testing URLs

Once server is running, test these URLs:

| Feature | URL | Expected |
|---------|-----|----------|
| **Login** | `http://localhost:9000/` | Login form |
| **Dashboard** | `http://localhost:9000/dashboard` | Redirect to login |
| **Safe Space** | `http://localhost:9000/safe-space/dashboard` | Safe Space page |

---

## 🔍 Debug Tools

### **1. Run Diagnostic**
```bash
php diagnostic-server.php
```
Opens browser with complete system check

### **2. Check Logs**
```bash
type writable\logs\log-*.php
```

### **3. Test Routes**
```bash
php spark routes
```

### **4. Test Database**
```bash
php setup-murid-data.php
```

---

## 🆘 Emergency Solutions

### **If Nothing Works:**

#### **Solution 1: Copy to XAMPP htdocs**
```bash
# Copy app to XAMPP htdocs root
copy /s app-murid c:\xampp\htdocs\app-murid-direct
# Access: http://localhost/app-murid-direct/public
```

#### **Solution 2: Use XAMPP Control Panel**
1. Start Apache from XAMPP Control Panel
2. Create virtual directory in Apache config
3. Access via `http://localhost/simaklah-murid`

#### **Solution 3: Docker (Advanced)**
```dockerfile
FROM php:8.1-apache
COPY app-murid/ /var/www/html/
RUN chmod -R 777 /var/www/html/writable
EXPOSE 80
```

---

## 📞 Need Help?

### **Files to Check:**
1. `diagnostic-server.php` - System diagnostic
2. `debug-app-murid.php` - Application debug
3. `testing-portal.html` - Testing interface
4. `writable/logs/` - Error logs

### **Common Error Solutions:**
- **"spark not found"** → Check if in app-murid directory
- **"Port in use"** → Use different port or kill process
- **"Permission denied"** → Run as Administrator
- **"Database error"** → Run setup-murid-data.php
- **"404 Not Found"** → Check Routes.php configuration

---

**🎯 Bottom Line:** If `php spark serve` doesn't work, use `php -S localhost:9000 -t public` as reliable alternative!
