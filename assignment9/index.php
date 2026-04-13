<?php

require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php'; // Fixed to match assignment specs
require_once 'classes/Validation.php';
require_once 'classes/StickyForm.php';  // Fixed to singular

$stickyForm = new StickyForm(); // Fixed to singular
$pdo = new PdoMethods();
$msg = "";

// Added 'error' => false so we know WHEN to show the errorMsg
$formConfig = [
    'first_name'       => ['type' => 'name', 'value' => '', 'errorMsg' => 'You must enter a first name and it must be alpha characters only.', 'error' => false],
    'last_name'        => ['type' => 'name', 'value' => '', 'errorMsg' => 'You must enter a last name and it must be alpha characters only.', 'error' => false],
    'email'            => ['type' => 'email', 'value' => '', 'errorMsg' => 'You must enter a email address and it must be in the format of example@example.com.', 'error' => false],
    'password'         => ['type' => 'password', 'value' => '', 'errorMsg' => '(Must have at least 8 characters, 1 uppercase, 1 symbol, 1 number)', 'error' => false],
    'confirm_password' => ['type' => 'password', 'value' => '', 'errorMsg' => '(Must have at least 8 characters, 1 uppercase, 1 symbol, 1 number)', 'error' => false]
];

$masterStatus = ['error' => false];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    
    // 1. Basic format validation loop utilizing the textbook's checkFormat method
    foreach ($formConfig as $field => $config) {
        // Save the POST value to make the form sticky
        $formConfig[$field]['value'] = $_POST[$field] ?? '';
        
        // Check format against the Validation class rules
        if (!$stickyForm->checkFormat($_POST[$field], $config['type'])) {
            $formConfig[$field]['error'] = true;
            $masterStatus['error'] = true;
        }
    }

    // 2. Custom Validation: Password Match
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $formConfig['confirm_password']['error'] = true;
        $formConfig['confirm_password']['errorMsg'] = "Passwords do not match.";
        $masterStatus['error'] = true;
    }

    // 3. Custom Validation: Duplicate Email Check
    if (!$formConfig['email']['error']) { // Only check DB if email format is valid
        $email = $_POST['email'];
        $sql = "SELECT id FROM users WHERE email = :email";
        $bindings = [[':email', $email, 'str']];
        $records = $pdo->selectBinded($sql, $bindings);

        if ($records && count($records) > 0) {
            $formConfig['email']['error'] = true;
            $formConfig['email']['errorMsg'] = "This email address is already in the database.";
            $masterStatus['error'] = true;
        }
    }

    // 4. Success: Insert into DB
    if (!$masterStatus['error']) {
        // Hash the password securely
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $bindings = [
            [':first_name', $_POST['first_name'], 'str'],
            [':last_name', $_POST['last_name'], 'str'],
            [':email', $_POST['email'], 'str'],
            [':password', $hashedPassword, 'str']
        ];
        
        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'noerror') {
            $msg = "<p class='text-dark fw-bold'>You have been added to the database</p>";
            // Clear form fields on success
            foreach ($formConfig as $key => $field) {
                $formConfig[$key]['value'] = '';
            }
        } else {
            $msg = "<p class='text-danger fw-bold'>There was an error inserting the record.</p>";
        }
    }
}

// 5. Fetch Records for the Table
$sql = "SELECT first_name, last_name, email, password FROM users";
$users = $pdo->selectNotBinded($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 9 Sticky Form</title>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">    <style>
        .error-text { color: red; font-size: 0.875em; display: block; margin-top: 5px; }
    </style>
</head>
<body class="container mt-5">


    <?= $msg ?>
    <p class="text-dark">All fields are required.</p>

    <form method="POST" action="index.php">
        <div class="row mb-3">
            <div class="col-md-6">
                <label>*First Name</label>
                <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($formConfig['first_name']['value']) ?>">
                <?php if($formConfig['first_name']['error']): ?>
                    <span class="error-text"><?= $formConfig['first_name']['errorMsg'] ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label>*Last Name</label>
                <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($formConfig['last_name']['value']) ?>">
                <?php if($formConfig['last_name']['error']): ?>
                    <span class="error-text"><?= $formConfig['last_name']['errorMsg'] ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label>*Email</label>
                <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($formConfig['email']['value']) ?>">
                <?php if($formConfig['email']['error']): ?>
                    <span class="error-text"><?= $formConfig['email']['errorMsg'] ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label>*Password</label>
                <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($formConfig['password']['value']) ?>">
                <?php if($formConfig['password']['error']): ?>
                    <span class="error-text"><?= $formConfig['password']['errorMsg'] ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label>*Confirm Password</label>
                <input type="text" name="confirm_password" class="form-control" value="<?= htmlspecialchars($formConfig['confirm_password']['value']) ?>">
                <?php if($formConfig['confirm_password']['error']): ?>
                    <span class="error-text"><?= $formConfig['confirm_password']['errorMsg'] ?></span>
                <?php endif; ?>
            </div>
        </div>

        <button type="submit" name="register" class="btn btn-primary">Register</button>
    </form>

    <hr class="my-5">

    <?php if ($users && count($users) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td style="word-break: break-all;"><?= htmlspecialchars($user['password']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No records to display.</p>
    <?php endif; ?>

</body>
</html>
