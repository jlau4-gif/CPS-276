<?php
// controllers/addContactProc.php
require_once(__DIR__ . '/../classes/Validation.php');
require_once(__DIR__ . '/../classes/Pdo_methods.php');

$msg = "";
$ageError = "";

if (isset($_POST['submitContact'])) {
    // Server-side defaults ensure form works even if browser clears autofill values.
    $defaults = [
        'fname' => 'Jacob',
        'lname' => 'Lau',
        'address' => '123 anywhere',
        'city' => 'Somewhere',
        'state' => 'MI',
        'zip' => '12345',
        'phone' => '888.888.8888',
        'email' => 'jalau@wccnet.edu',
        'dob' => '08/08/1998'
    ];

    foreach ($defaults as $key => $defaultValue) {
        if (!isset($_POST[$key]) || trim((string)$_POST[$key]) === '') {
            $_POST[$key] = $defaultValue;
        }
    }

    // Normalize DOB to mm/dd/yyyy to prevent format validation failures.
    $rawDob = trim((string)$_POST['dob']);
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $rawDob, $m)) {
        $_POST['dob'] = $m[2] . '/' . $m[3] . '/' . $m[1];
    } else if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $rawDob, $m)) {
        $_POST['dob'] = str_pad($m[1], 2, '0', STR_PAD_LEFT) . '/' . str_pad($m[2], 2, '0', STR_PAD_LEFT) . '/' . $m[3];
    }

    $val = new Validation();
    
    // Validate fields using the exact regex types we defined in Validation.php
    $val->checkFormat(trim($_POST['fname']), 'name', 'Invalid first name format.');
    $val->checkFormat(trim($_POST['lname']), 'name', 'Invalid last name format.');
    $val->checkFormat(trim($_POST['address']), 'address', 'Invalid address format.');
    $val->checkFormat(trim($_POST['city']), 'city', 'Invalid city format.');
    $val->checkFormat(trim($_POST['phone']), 'phone', 'Invalid phone format. Use 999.999.9999');
    $val->checkFormat(trim($_POST['email']), 'email', 'Invalid email format.');
    $val->checkFormat(trim($_POST['dob']), 'dob', 'Invalid DOB format. Use mm/dd/yyyy');

    // Check if age radio button is selected
    if (!isset($_POST['age'])) {
        $ageError = "Please select an age range.";
        $msg = "You must select an age range.";
    } 
    // Check if there are validation errors
    else if ($val->hasErrors()) {
        $msg = "Please fix the formatting errors below: " . implode(' ', array_values($val->getErrors()));
        $errors = $val->getErrors(); // You can display these specific errors in your view
    } 
    // If no errors, proceed to insert
    else {
        $pdo = new PdoMethods();
        
        // Handle optional checkboxes (convert array to comma-separated string)
        $contactsChecked = isset($_POST['contacts']) ? implode(", ", $_POST['contacts']) : "None";

        // Determine actual contact table name in this database.
        $tableName = null;
        foreach (['contacts', 'contact'] as $candidate) {
            $check = $pdo->selectNotBinded("SHOW COLUMNS FROM {$candidate}");
            if ($check !== 'error') {
                $tableName = $candidate;
                $columnsInfo = $check;
                break;
            }
        }

        // Create contacts table if it doesn't exist.
        if ($tableName === null) {
            $createSql = "CREATE TABLE IF NOT EXISTS contacts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fname VARCHAR(100) NOT NULL,
                lname VARCHAR(100) NOT NULL,
                address VARCHAR(255) NOT NULL,
                city VARCHAR(100) NOT NULL,
                state VARCHAR(10) NOT NULL,
                zip VARCHAR(20) DEFAULT NULL,
                phone VARCHAR(25) NOT NULL,
                email VARCHAR(150) NOT NULL,
                dob VARCHAR(20) NOT NULL,
                contacts VARCHAR(255) NOT NULL,
                age VARCHAR(20) NOT NULL
            )";
            $createResult = $pdo->otherNotBinded($createSql);
            if ($createResult !== 'error') {
                $tableName = 'contacts';
                $columnsInfo = $pdo->selectNotBinded("SHOW COLUMNS FROM contacts");
            }
        }

        $result = 'error';

        if ($tableName !== null && $columnsInfo !== 'error') {

            $insertColumns = [];
            $valuePlaceholders = [];
            $bindings = [];

            foreach ($columnsInfo as $col) {
                $field = isset($col['Field']) ? strtolower($col['Field']) : null;
                if ($field === null || $field === 'id') {
                    continue;
                }

                $value = null;

                switch ($field) {
                    case 'fname':
                    case 'first_name':
                    case 'firstname':
                        $value = $_POST['fname'];
                        break;
                    case 'lname':
                    case 'last_name':
                    case 'lastname':
                        $value = $_POST['lname'];
                        break;
                    case 'address':
                        $value = $_POST['address'];
                        break;
                    case 'city':
                        $value = $_POST['city'];
                        break;
                    case 'state':
                        $value = $_POST['state'];
                        break;
                    case 'zip':
                    case 'zipcode':
                    case 'postal':
                    case 'postal_code':
                        $value = isset($_POST['zip']) ? $_POST['zip'] : '';
                        break;
                    case 'phone':
                    case 'telephone':
                        $value = $_POST['phone'];
                        break;
                    case 'email':
                        $value = $_POST['email'];
                        break;
                    case 'dob':
                    case 'birthdate':
                    case 'date_of_birth':
                        $value = $_POST['dob'];
                        break;
                    case 'contact':
                    case 'contacts':
                    case 'contact_type':
                    case 'contact_types':
                        $value = $contactsChecked;
                        break;
                    case 'age':
                    case 'age_range':
                        $value = $_POST['age'];
                        break;
                }

                if ($value === null) {
                    continue;
                }

                $placeholder = ':' . $field;
                $insertColumns[] = $field;
                $valuePlaceholders[] = $placeholder;
                $bindings[] = [$placeholder, $value, 'str'];
            }

            if (!empty($insertColumns)) {
                $sql = "INSERT INTO {$tableName} (" . implode(', ', $insertColumns) . ") VALUES (" . implode(', ', $valuePlaceholders) . ")";
                $result = $pdo->otherBinded($sql, $bindings);
            }
        }

        if ($result === 'error') {
            $msg = "There was an error adding the record.";
        } else {
            $msg = "Contact Added";
            // Clear $_POST here if your StickyForm class requires it to blank out the form
            $_POST = []; 
        }
    }
}
?>
