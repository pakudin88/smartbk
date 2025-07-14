<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Login Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .demo-info {
            background: #e2e3e5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .demo-info h4 {
            margin: 0 0 10px 0;
            color: #495057;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Simple Login Test</h1>
        
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            try {
                $connection = new mysqli('localhost', 'root', '', 'sekolah_multiapp');
                
                if ($connection->connect_error) {
                    $message = "Database connection failed: " . $connection->connect_error;
                    $messageType = 'error';
                } else {
                    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
                    $stmt->bind_param("ss", $username, $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $user = $result->fetch_assoc();
                        
                        if (password_verify($password, $user['password'])) {
                            // Login berhasil, redirect ke dashboard simple
                            header('Location: dashboard-simple.php?user=' . urlencode($user['full_name']));
                            exit;
                        } else {
                            $message = "Password salah!";
                            $messageType = 'error';
                        }
                    } else {
                        $message = "Username tidak ditemukan!";
                        $messageType = 'error';
                    }
                    
                    $stmt->close();
                    $connection->close();
                }
            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = 'error';
            }
        }
        ?>
        
        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <div class="demo-info">
            <h4>Demo Credentials:</h4>
            <p><strong>Username:</strong> superadmin</p>
            <p><strong>Password:</strong> 123456</p>
        </div>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username/Email</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <div class="links">
            <a href="debug.php">Debug Info</a> |
            <a href="setup-db.php">Setup Database</a> |
            <a href="index.php">CodeIgniter App</a>
        </div>
    </div>
</body>
</html>
