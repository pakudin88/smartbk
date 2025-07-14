<?php
// Setup database with demo user
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Setup</h1>";

try {
    $connection = new mysqli('localhost', 'root', '', 'sekolah_multiapp');
    
    if ($connection->connect_error) {
        echo "<p style='color: red;'>Connection failed: " . $connection->connect_error . "</p>";
        exit;
    }
    
    echo "<p style='color: green;'>Database connected successfully!</p>";
    
    // Create roles table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($connection->query($sql)) {
        echo "<p>Roles table created/verified successfully</p>";
    } else {
        echo "<p style='color: red;'>Error creating roles table: " . $connection->error . "</p>";
    }
    
    // Insert Super Admin role if not exists
    $sql = "INSERT IGNORE INTO roles (id, name, description) VALUES (1, 'Super Admin', 'Administrator utama sistem')";
    if ($connection->query($sql)) {
        echo "<p>Super Admin role created/verified</p>";
    }
    
    // Create users table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        role_id INT DEFAULT 1,
        profile_picture VARCHAR(255),
        is_active TINYINT(1) DEFAULT 1,
        last_login TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (role_id) REFERENCES roles(id)
    )";
    
    if ($connection->query($sql)) {
        echo "<p>Users table created/verified successfully</p>";
    } else {
        echo "<p style='color: red;'>Error creating users table: " . $connection->error . "</p>";
    }
    
    // Insert demo super admin user
    $hashedPassword = password_hash('123456', PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, full_name, role_id, is_active) 
            VALUES ('superadmin', 'superadmin@example.com', '$hashedPassword', 'Super Administrator', 1, 1)
            ON DUPLICATE KEY UPDATE 
            password = '$hashedPassword',
            full_name = 'Super Administrator',
            is_active = 1";
    
    if ($connection->query($sql)) {
        echo "<p style='color: green;'>Demo super admin user created/updated successfully!</p>";
        echo "<p><strong>Username:</strong> superadmin</p>";
        echo "<p><strong>Password:</strong> 123456</p>";
    } else {
        echo "<p style='color: red;'>Error creating demo user: " . $connection->error . "</p>";
    }
    
    $connection->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='test-db.php'>Test Database Connection</a></p>";
echo "<p><a href='index.php'>Go to Login</a></p>";
?>
