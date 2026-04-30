<?php
// controllers/deleteAdminProc.php
require_once(__DIR__ . '/../classes/Pdo_methods.php');

$pdo = new PdoMethods();
$msg = "";

// Handle Deletion
if (isset($_POST['deleteSubmit'])) {
    if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
        $error = false;
        
        foreach ($_POST['delete_ids'] as $id) {
            $sql = "DELETE FROM admins WHERE id = :id";
            $bindings = [[':id', $id, 'int']];
            $result = $pdo->otherBinded($sql, $bindings);
            
            if ($result === 'error') {
                $error = true;
                break;
            }
        }
        
        if ($error) {
            $msg = "Could not delete the admins.";
        } else {
            $msg = "Admin(s) deleted.";
        }
    }
}

// Fetch Records to Display
$sql = "SELECT * FROM admins";
$admins = $pdo->selectNotBinded($sql);

if ($admins == 'error') {
    $msg = "There was an error fetching the admins.";
    $admins = [];
}
?>
