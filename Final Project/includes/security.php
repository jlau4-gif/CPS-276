<?php

// If no session status is set, they aren't logged in. Boot them to login.
if (!isset($_SESSION['status'])) {
    header('Location: index.php?page=login');
    exit;
}

// Function to use on admin-only routes in the router
function checkAdminAccess() {
    if ($_SESSION['status'] !== 'admin') {
        header('Location: index.php?page=welcome');
        exit;
    }
}
?>
