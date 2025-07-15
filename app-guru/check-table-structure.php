<?php
/**
 * Check table structure for debugging
 */

// Database configuration
$db_config = [
    'hostname' => 'srv1412.hstgr.io',
    'username' => 'u809035070_simaklah',
    'password' => 'Simaklah88#',
    'database' => 'u809035070_simaklah',
    'port'     => 3306,
];

try {
    $dsn = "mysql:host={$db_config['hostname']};port={$db_config['port']};dbname={$db_config['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== Checking kelas table structure ===\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'kelas'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Table 'kelas' exists\n\n";
        
        // Show structure
        $stmt = $pdo->query('DESCRIBE kelas');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "Columns in 'kelas' table:\n";
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']}) {$column['Null']} {$column['Key']}\n";
        }
        
        // Check for wali_kelas related columns
        echo "\n=== Checking for wali_kelas related columns ===\n";
        $waliKelasColumns = array_filter($columns, function($col) {
            return strpos(strtolower($col['Field']), 'wali') !== false || 
                   strpos(strtolower($col['Field']), 'guru') !== false;
        });
        
        if (empty($waliKelasColumns)) {
            echo "❌ No wali_kelas or guru related columns found\n";
        } else {
            echo "✅ Found related columns:\n";
            foreach ($waliKelasColumns as $col) {
                echo "- {$col['Field']}\n";
            }
        }
        
    } else {
        echo "❌ Table 'kelas' does not exist\n";
    }

    echo "\n=== Checking teacher_assignments table ===\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'teacher_assignments'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query('DESCRIBE teacher_assignments');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "❌ Table 'teacher_assignments' does not exist\n";
    }

    echo "\n=== Checking guru_mata_pelajaran table ===\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'guru_mata_pelajaran'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query('DESCRIBE guru_mata_pelajaran');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "❌ Table 'guru_mata_pelajaran' does not exist\n";
    }

    echo "\n=== Checking users table for guru data ===\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query('DESCRIBE users');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "❌ Table 'users' does not exist\n";
    }

    echo "\n=== Checking mata_pelajaran table ===\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'mata_pelajaran'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query('DESCRIBE mata_pelajaran');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "❌ Table 'mata_pelajaran' does not exist\n";
    }

    echo "\n=== Checking subjects table ===\n";
    $stmt = $pdo->query("SHOW TABLES LIKE 'subjects'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query('DESCRIBE subjects');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
    } else {
        echo "❌ Table 'subjects' does not exist\n";
    }

    echo "\n=== Checking all tables ===\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Available tables:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
