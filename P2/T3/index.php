<?php

require_once 'system_command_executor.php';

// Define a list of Unix commands to execute
$commands = [
    'ls -la /var/www/html', // List files in the web root
    'ps aux | head -n 5',   // Top 5 processes
    'whoami',               // Current user
    'id',                   // User identity
    'uname -a',             // System information
    'df -h /',              // Disk free space
    'free -h'               // Memory usage
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Information</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #0056b3; border-bottom: 2px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px; }
        h2 { color: #0056b3; margin-top: 30px; }
        pre { background-color: #eee; border: 1px solid #ddd; padding: 15px; border-radius: 5px; overflow-x: auto; white-space: pre-wrap; word-wrap: break-word; }
        .command-title { font-weight: bold; color: #555; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Server Information</h1>

        <?php foreach ($commands as $command): ?>
            <div class="command-section">
                <h2>Command: <span class="command-title"><?php echo htmlspecialchars($command); ?></span></h2>
                <pre><?php echo htmlspecialchars(executeCommand($command)); ?></pre>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>