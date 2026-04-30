<?php
// controllers/deleteContactProc.php
require_once(__DIR__ . '/../classes/Pdo_methods.php');

$pdo = new PdoMethods();
$msg = "";

// Handle Deletion
if (isset($_POST['deleteSubmit'])) {
    if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
        $error = false;
        
        // Loop through each checked ID and delete
        foreach ($_POST['delete_ids'] as $id) {
            $sql = "DELETE FROM contacts WHERE id = :id";
            $bindings = [[':id', $id, 'int']];
            $result = $pdo->otherBinded($sql, $bindings);
            
            if ($result === 'error') {
                $error = true;
                break;
            }
        }
        
        if ($error) {
            $msg = "Could not delete the contacts.";
        } else {
            $msg = "";
        }
    } else {
        // Page reloads without deleting if nothing is checked (per instructions)
    }
}

// Fetch Records to Display in the Table View
$sql = "SELECT * FROM contacts";
$contacts = $pdo->selectNotBinded($sql);

if ($contacts == 'error') {
    $msg = "There was an error fetching the contacts.";
    $contacts = [];
}
?>
