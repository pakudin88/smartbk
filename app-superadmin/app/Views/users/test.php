<!DOCTYPE html>
<html>
<head>
    <title>Test Users Page</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .user-item { padding: 10px; border: 1px solid #ddd; margin: 5px 0; }
    </style>
</head>
<body>
    <h1>TEST USERS PAGE</h1>
    <p>Total users: <?= count($users) ?></p>
    
    <?php if (!empty($users)): ?>
        <div>
            <?php foreach ($users as $user): ?>
                <div class="user-item">
                    <strong><?= $user['name'] ?></strong> - <?= $user['email'] ?> 
                    (<?= $user['role_name'] ?? 'No Role' ?>)
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</body>
</html>
