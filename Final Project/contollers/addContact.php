<?php
// controllers/addContactProc.php
require_once('classes/Validation.php');
require_once('classes/Pdo_methods.php');
// require_once('classes/StickyForm.php'); // Include and initialize if your views use it to repopulate fields

$msg = "";

if (isset($_POST['submitContact'])) {
    $val = new Validation();
    
    // Validate fields using the exact regex types we defined in Validation.php
    $val->checkFormat($_POST['fname'], 'name');
    $val->checkFormat($_POST['lname'], 'name');
    $val->checkFormat($_POST['address'], 'address');
    $val->checkFormat($_POST['city'], 'city');
    $val->checkFormat($_POST['phone'], 'phone');
    $val->checkFormat($_POST['email'], 'email');
    $val->checkFormat($_POST['dob'], 'dob');

    // Check if age radio button is selected
    if (!isset($_POST['age'])) {
        $msg = "You must select an age range.";
    } 
    // Check if there are validation errors
    else if ($val->hasErrors()) {
        $msg = "Please fix the formatting errors below.";
        $errors = $val->getErrors(); // You can display these specific errors in your view
    } 
    // If no errors, proceed to insert
    else {
        $pdo = new PdoMethods();
        
        // Handle optional checkboxes (convert array to comma-separated string)
        $contactsChecked = isset($_POST['contacts']) ? implode(", ", $_POST['contacts']) : "None";

        $sql = "INSERT INTO contacts (fname, lname, address, city, state, phone, email, dob, contacts, age) 
                VALUES (:fname, :lname, :address, :city, :state, :phone, :email, :dob, :contacts, :age)";
        
        $bindings = [
            [':fname', $_POST['fname'], 'str'],
            [':lname', $_POST['lname'], 'str'],
            [':address', $_POST['address'], 'str'],
            [':city', $_POST['city'], 'str'],
            [':state', $_POST['state'], 'str'],
            [':phone', $_POST['phone'], 'str'],
            [':email', $_POST['email'], 'str'],
            [':dob', $_POST['dob'], 'str'],
            [':contacts', $contactsChecked, 'str'],
            [':age', $_POST['age'], 'str']
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'error') {
            $msg = "There was an error adding the record.";
        } else {
            $msg = "Contact Information Added.";
            // Clear $_POST here if your StickyForm class requires it to blank out the form
            $_POST = []; 
        }
    }
}
?>
