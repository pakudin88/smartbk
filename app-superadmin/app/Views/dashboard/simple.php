<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f5f5f5;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header { 
            background: #007bff; 
            color: white; 
            padding: 20px; 
            border-radius: 5px; 
            margin-bottom: 20px;
        }
        .stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-bottom: 20px;
        }
        .stat-card { 
            background: #fff; 
            border: 1px solid #ddd; 
            padding: 20px; 
            border-radius: 5px; 
            text-align: center;
        }
        .stat-card h3 { 
            margin: 0 0 10px 0; 
            color: #333;
        }
        .stat-card p { 
            margin: 0; 
            color: #666;
        }
        .recent { 
            background: #fff; 
            border: 1px solid #ddd; 
            padding: 20px; 
            border-radius: 5px;
        }
        .recent h3 { 
            margin-top: 0; 
            color: #333;
        }
        .activity { 
            border-bottom: 1px solid #eee; 
            padding: 10px 0;
        }
        .activity:last-child { 
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎯 <?= $title ?? 'Dashboard Super Admin' ?></h1>
            <p>Selamat datang, <strong><?= $user['full_name'] ?? $user['username'] ?? 'User' ?></strong>!</p>
            <p>Role: <?= $user['role_name'] ?? 'Unknown' ?> | Email: <?= $user['email'] ?? 'No email' ?></p>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <h3><?= $stats['total_users'] ?? 0 ?></h3>
                <p>Total Users</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['total_guru'] ?? 0 ?></h3>
                <p>Total Guru</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['total_siswa'] ?? 0 ?></h3>
                <p>Total Siswa</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['total_admin'] ?? 0 ?></h3>
                <p>Total Admin</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['total_superadmin'] ?? 0 ?></h3>
                <p>Super Admin</p>
            </div>
            <div class="stat-card">
                <h3><?= $stats['active_users'] ?? 0 ?></h3>
                <p>Active Users</p>
            </div>
        </div>
        
        <div class="recent">
            <h3>📊 System Info</h3>
            <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
            <p><strong>Current Time:</strong> <?= date('d F Y, H:i:s') ?></p>
            <p><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></p>
            <p><strong>User ID:</strong> <?= session()->get('user_id') ?? 'Not set' ?></p>
            <p><strong>Session Role:</strong> <?= session()->get('role_name') ?? 'Not set' ?></p>
        </div>
        
        <?php if (!empty($stats['recent_activities'])): ?>
        <div class="recent">
            <h3>👥 Recent Activities</h3>
            <?php foreach ($stats['recent_activities'] as $activity): ?>
            <div class="activity">
                <strong><?= $activity['full_name'] ?? $activity['username'] ?? 'Unknown' ?></strong>
                <span>(<?= $activity['role_name'] ?? 'Unknown role' ?>)</span>
                <?php if (isset($activity['created_at'])): ?>
                    <br><small>Created: <?= date('d M Y H:i', strtotime($activity['created_at'])) ?></small>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div class="recent">
            <h3>🔧 Quick Actions</h3>
            <p>
                <a href="/users" style="text-decoration: none; background: #007bff; color: white; padding: 10px 15px; border-radius: 5px; margin-right: 10px;">Manage Users</a>
                <a href="/settings" style="text-decoration: none; background: #28a745; color: white; padding: 10px 15px; border-radius: 5px; margin-right: 10px;">Settings</a>
                <a href="/reports" style="text-decoration: none; background: #ffc107; color: black; padding: 10px 15px; border-radius: 5px; margin-right: 10px;">Reports</a>
                <a href="/auth/logout" style="text-decoration: none; background: #dc3545; color: white; padding: 10px 15px; border-radius: 5px;">Logout</a>
            </p>
        </div>
    </div>
</body>
</html>
