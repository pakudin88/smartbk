#!/bin/bash

# Fix Script for CodeIgniter App Murid
# Script untuk memperbaiki masalah umum pada aplikasi

echo "==============================================="
echo "    SIMAKLAH - App Murid Fix Script"
echo "==============================================="
echo

# Navigate to app directory
APP_DIR="c:/xampp/htdocs/simaklah-main/app-murid"
cd "$APP_DIR"

echo "Current directory: $(pwd)"
echo

# 1. Fix permissions
echo "1. Fixing directory permissions..."
chmod -R 755 .
chmod -R 777 writable/
echo "✓ Permissions fixed"

# 2. Create .env if missing
echo "2. Checking .env file..."
if [ ! -f ".env" ]; then
    echo "Creating .env file..."
    cp env .env
    echo "✓ .env file created"
else
    echo "✓ .env file exists"
fi

# 3. Install/update dependencies
echo "3. Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-dev
    echo "✓ Composer dependencies installed"
else
    echo "⚠ Composer not found, skipping dependency installation"
fi

# 4. Clear cache
echo "4. Clearing cache..."
rm -rf writable/cache/*
rm -rf writable/logs/*
echo "✓ Cache cleared"

# 5. Test CodeIgniter CLI
echo "5. Testing CodeIgniter CLI..."
if php spark --version; then
    echo "✓ CodeIgniter CLI working"
else
    echo "⚠ CodeIgniter CLI issues detected"
fi

# 6. Create simple launcher
echo "6. Creating simple launcher..."
cat > run-simple.sh << 'EOF'
#!/bin/bash
cd "$(dirname "$0")"
echo "Starting SIMAKLAH App Murid..."
echo "URL: http://localhost:9000"
echo "Press Ctrl+C to stop"
echo
php -S localhost:9000 -t public
EOF
chmod +x run-simple.sh
echo "✓ Simple launcher created: run-simple.sh"

echo
echo "==============================================="
echo "Fix completed! Try running the app with:"
echo "1. ./run-simple.sh"
echo "2. php spark serve --port=9000"
echo "3. php -S localhost:9000 -t public"
echo "==============================================="
