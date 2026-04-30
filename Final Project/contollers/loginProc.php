<?php
// controllers/loginProc.php

require_once(__DIR__ . '/../classes/Pdo_methods.php');

// Keep required test accounts in an existing file so project tree matches assignment.
$pdoSeed = new PdoMethods();

// Ensure required login table exists before seeding/querying.
$createAdminsTableSql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL
)";
$pdoSeed->otherNotBinded($createAdminsTableSql);

$presetPassword = 'password';
$presetHashedPassword = password_hash($presetPassword, PASSWORD_DEFAULT);
$accounts = [
    ['name' => 'Jacob Lau Admin', 'email' => 'jalau@admin.com', 'status' => 'admin'],
    ['name' => 'Jacob Lau Staff', 'email' => 'jalau@staff.com', 'status' => 'staff']
];

foreach ($accounts as $account) {
    $checkSql = "SELECT id FROM admins WHERE email = :email";
    $checkBindings = [[':email', $account['email'], 'str']];
    $existing = $pdoSeed->selectBinded($checkSql, $checkBindings);

    if ($existing === 'error') {
        continue;
    }

    if (count($existing) > 0) {
        $updateSql = "UPDATE admins SET name = :name, password = :password, status = :status WHERE id = :id";
        $updateBindings = [
            [':name', $account['name'], 'str'],
            [':password', $presetHashedPassword, 'str'],
            [':status', $account['status'], 'str'],
            [':id', $existing[0]['id'], 'int']
        ];
        $pdoSeed->otherBinded($updateSql, $updateBindings);
    } else {
        $insertSql = "INSERT INTO admins (name, email, password, status) VALUES (:name, :email, :password, :status)";
        $insertBindings = [
            [':name', $account['name'], 'str'],
            [':email', $account['email'], 'str'],
            [':password', $presetHashedPassword, 'str'],
            [':status', $account['status'], 'str']
        ];
        $pdoSeed->otherBinded($insertSql, $insertBindings);
    }
}

if (isset($_POST['login'])) {
    $pdo = new PdoMethods();

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Try common table names to avoid hard failure if schema name differs.
    $records = 'error';
    $bindings = [[ ':email', $email, 'str' ]];
    $loginTables = ['admins', 'admin'];

    foreach ($loginTables as $table) {
        $sql = "SELECT * FROM {$table} WHERE email = :email";
        $records = $pdo->selectBinded($sql, $bindings);
        if ($records !== 'error') {
            break;
        }
    }

    if ($records == 'error') {
        $loginError = "There was an error logging in. Please verify the admins table exists and has email/password columns.";
    } else if (count($records) != 0) {
        $row = $records[0];
        $storedPassword = isset($row['password']) ? $row['password'] : (isset($row['pass']) ? $row['pass'] : '');

        // Verify hashed passwords, with a plain-text fallback for legacy rows.
        if ($storedPassword !== '' && (password_verify($password, $storedPassword) || hash_equals($storedPassword, $password))) {
            // Password is correct, set sessions
            $_SESSION['status'] = isset($row['status']) ? $row['status'] : 'admin';
            $_SESSION['name'] = isset($row['name']) ? $row['name'] : 'User';
            
            // Redirect to welcome page
            header('Location: index.php?page=welcome');
            exit;
        } else {
            $loginError = "Invalid email or password.";
        }
    } else {
        $loginError = "Invalid email or password.";
    }
}
?>
