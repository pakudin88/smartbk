# 🚀 CARA START SERVERS - SmartBK Folder-Based URLs

## ⚡ Quick Start (Recommended)

### 1. Buka 2 Terminal/Command Prompt:

**Terminal 1 - App-Guru (Port 8081):**
```bash
cd c:\xampp\htdocs\smartbk\app-guru
php spark serve --port=8081
```

**Terminal 2 - App-Ortu (Port 8080):**
```bash
cd c:\xampp\htdocs\smartbk\app-ortu
php spark serve --port=8080
```

### 2. Tunggu hingga muncul pesan:
```
CodeIgniter development server started: http://localhost:8081
CodeIgniter development server started: http://localhost:8080
```

### 3. Test URLs:
- **App-Guru:** http://localhost/smartbk/app-guru/public
- **App-Ortu:** http://localhost/smartbk/app-ortu/public

## 🔧 Alternative - Using Batch Files

**Double-click these files:**
- `start-app-guru-8081.bat`
- `start-app-ortu-8080.bat`

## ✅ Verification

### Check if servers are running:
```bash
netstat -an | findstr "8080"
netstat -an | findstr "8081"
```

### Expected output:
```
TCP    [::1]:8080    [::]:0    LISTENING
TCP    [::1]:8081    [::]:0    LISTENING
```

## 🎯 URL Structure

| URL Path | Target Server | Purpose |
|----------|---------------|---------|
| `/smartbk/app-guru/public` | localhost:8081 | Portal Guru |
| `/smartbk/app-ortu/public` | localhost:8080 | Portal Orang Tua |
| `/smartbk/app-superadmin/public` | localhost:8082 | Portal Super Admin |

## 🔍 Troubleshooting

### Problem: "Server not responding"
**Solution:** 
1. Check if server is running: `netstat -an | findstr "8081"`
2. Start server manually: `cd app-guru && php spark serve --port=8081`

### Problem: "Port already in use"
**Solution:**
1. Kill existing process: `taskkill /f /im php.exe`
2. Or use different port in .env file

### Problem: "Redirect to port visible"
**Check:**
1. URL should stay as `/smartbk/app-guru/public`
2. No browser redirect to localhost:8081
3. Content loads from proxy system

## 🎉 Success Indicators

✅ URL stays as `/smartbk/app-guru/public`
✅ No port numbers visible to user
✅ Content loads correctly
✅ Login system works
✅ Dashboard accessible

## 📝 Development Notes

- **app-guru/.env:** `app.baseURL = 'http://localhost:8081/'`
- **app-ortu/.env:** `app.baseURL = 'http://localhost:8080/'`
- **System uses:** cURL proxy to forward requests
- **No browser redirects:** Content served directly
