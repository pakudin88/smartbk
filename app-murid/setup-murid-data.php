<?php
/**
 * Setup Sample Murid Data for Database Testing
 */

echo "=== SETUP SAMPLE MURID DATA ===\n";

try {
    // Connect to database
    $mysqli = new mysqli('localhost', 'root', '', 'sekolah_multiapp', 3306);
    
    if ($mysqli->connect_error) {
        die("❌ Connection failed: " . $mysqli->connect_error . "\n");
    }
    
    echo "✅ Connected to database\n";
    
    // Check if murid table exists
    $result = $mysqli->query("SHOW TABLES LIKE 'murid'");
    if ($result->num_rows == 0) {
        echo "Creating murid table...\n";
        
        $createTable = "
        CREATE TABLE murid (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            nama_lengkap VARCHAR(100) NOT NULL,
            email VARCHAR(100),
            nisn VARCHAR(20) UNIQUE,
            kelas_id INT,
            is_active TINYINT DEFAULT 1,
            last_login DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
        ";
        
        if ($mysqli->query($createTable)) {
            echo "✅ Murid table created\n";
        } else {
            echo "❌ Error creating table: " . $mysqli->error . "\n";
        }
    } else {
        echo "✅ Murid table exists\n";
    }
    
    // Insert sample data
    $sampleUsers = [
        [
            'username' => 'ahmad.budi',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Ahmad Budi Santoso',
            'email' => 'ahmad.budi@student.school.id',
            'nisn' => '1234567890'
        ],
        [
            'username' => 'siti.aisyah',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Siti Aisyah Putri',
            'email' => 'siti.aisyah@student.school.id',
            'nisn' => '1234567891'
        ],
        [
            'username' => 'deni.pratama',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Deni Pratama',
            'email' => 'deni.pratama@student.school.id',
            'nisn' => '1234567892'
        ]
    ];
    
    foreach ($sampleUsers as $user) {
        // Check if user already exists
        $stmt = $mysqli->prepare("SELECT id FROM murid WHERE username = ?");
        $stmt->bind_param("s", $user['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Insert new user
            $stmt = $mysqli->prepare("
                INSERT INTO murid (username, password, nama_lengkap, email, nisn, is_active) 
                VALUES (?, ?, ?, ?, ?, 1)
            ");
            $stmt->bind_param("sssss", 
                $user['username'], 
                $user['password'], 
                $user['nama_lengkap'], 
                $user['email'], 
                $user['nisn']
            );
            
            if ($stmt->execute()) {
                echo "✅ Created user: " . $user['username'] . " (" . $user['nama_lengkap'] . ")\n";
            } else {
                echo "❌ Error creating user " . $user['username'] . ": " . $mysqli->error . "\n";
            }
        } else {
            echo "⚠️ User " . $user['username'] . " already exists\n";
        }
        $stmt->close();
    }
    
    // Display sample credentials
    echo "\n=== SAMPLE LOGIN CREDENTIALS ===\n";
    echo "Username: ahmad.budi | Password: 123456\n";
    echo "Username: siti.aisyah | Password: 123456\n";
    echo "Username: deni.pratama | Password: 123456\n";
    
    // Count total murid
    $result = $mysqli->query("SELECT COUNT(*) as count FROM murid WHERE is_active = 1");
    $row = $result->fetch_assoc();
    echo "\nTotal active students: " . $row['count'] . "\n";
    
    $mysqli->close();
    
    echo "\n✅ SETUP COMPLETE!\n";
    echo "You can now test login at: http://localhost:8080/login\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
