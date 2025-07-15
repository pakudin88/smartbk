<?php
/**
 * Setup Session Table for SmartBK System
 * Run this script once to create session table
 */

// Database configuration (same as in app/Config/Database.php)
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

    echo "Membuat tabel session...\n";

    // Drop table if exists
    $pdo->exec("DROP TABLE IF EXISTS `ci_sessions`");

    // Create sessions table
    $sql = "
    CREATE TABLE `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` timestamp DEFAULT CURRENT_TIMESTAMP,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";

    $pdo->exec($sql);
    echo "✅ Tabel ci_sessions berhasil dibuat!\n";

    // Add primary key
    $pdo->exec("ALTER TABLE `ci_sessions` ADD PRIMARY KEY (`id`)");
    echo "✅ Primary key berhasil ditambahkan!\n";

    // Add index for IP address
    $pdo->exec("ALTER TABLE `ci_sessions` ADD KEY `ci_sessions_ip_address` (`ip_address`)");
    echo "✅ Index IP address berhasil ditambahkan!\n";

    echo "\n🎉 Setup session table selesai!\n";
    echo "Session sekarang menggunakan database storage.\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
