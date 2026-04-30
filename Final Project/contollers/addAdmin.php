<?php
// controllers/addAdminProc.php
require_once(__DIR__ . '/../classes/Validation.php');
require_once(__DIR__ . '/../classes/Pdo_methods.php');

$msg = "";

if (isset($_POST['submitAdmin'])) {
    if (!isset($_POST['name']) || trim((string)$_POST['name']) === '') {
        $firstName = isset($_POST['fname']) ? trim((string)$_POST['fname']) : '';
        $lastName = isset($_POST['lname']) ? trim((string)$_POST['lname']) : '';
        $_POST['name'] = trim($firstName . ' ' . $lastName);
    }

    $val = new Validation();
    
    $val->checkFormat($_POST['name'], 'name');
    $val->checkFormat($_POST['email'], 'email');
    $val->checkFormat($_POST['password'], 'password');

    if ($val->hasErrors()) {
        $msg = "Please fix the formatting errors below.";
        $errors = $val->getErrors();
    } else {
        $pdo = new PdoMethods();
        
        // 1. Check for Duplicate Email
        $checkSql = "SELECT id FROM admins WHERE email = :email";
        $checkBindings = [[':email', $_POST['email'], 'str']];
        $existing = $pdo->selectBinded($checkSql, $checkBindings);
        
        if ($existing === 'error') {
            $msg = "Database error verifying email.";
        } else if (count($existing) > 0) {
            $msg = "Someone with that email already exists";
        } else {
            // 2. Hash the password and Insert
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO admins (name, email, password, status) VALUES (:name, :email, :password, :status)";
            $bindings = [
                [':name', $_POST['name'], 'str'],
                [':email', $_POST['email'], 'str'],
                [':password', $hashedPassword, 'str'],
                [':status', $_POST['status'], 'str'] // 'admin' or 'staff'
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $msg = "There was an error adding the record.";
            } else {
                $msg = "Administrator Added.";
                $_POST = []; // Clear form data
            }
        }
    }
}
?>
