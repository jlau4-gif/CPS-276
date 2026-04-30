<?php
// Default to login page if no parameter is set
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

$content = '';
$nav = '';

// If the user is logged in and not on login page, show the navigation
if (isset($_SESSION['status']) && $page !== 'login') {
    require_once(__DIR__ . '/../includes/navigation.php');
}

// Route the parameters exactly as specified
switch($page) {
    case 'login':
        require_once(__DIR__ . '/../controllers/loginProc.php');
        ob_start();
        require_once(__DIR__ . '/../views/loginForm.php');
        $content = ob_get_clean();
        break;

    case 'welcome':
        require_once(__DIR__ . '/../includes/security.php');
        ob_start();
        require_once(__DIR__ . '/../views/welcome.php');
        $content = ob_get_clean();
        break;

    case 'addContact':
        require_once(__DIR__ . '/../includes/security.php');
        require_once(__DIR__ . '/../controllers/addContactProc.php');
        ob_start();
        require_once(__DIR__ . '/../views/addContactForm.php');
        $content = ob_get_clean();
        break;

    case 'deleteContacts':
        require_once(__DIR__ . '/../includes/security.php');
        require_once(__DIR__ . '/../controllers/deleteContactProc.php');
        ob_start();
        require_once(__DIR__ . '/../views/deleteContactsTable.php');
        $content = ob_get_clean();
        break;

    case 'addAdmin':
        require_once(__DIR__ . '/../includes/security.php');
        checkAdminAccess(); // Custom function to bounce 'staff' status users
        require_once(__DIR__ . '/../controllers/addAdmin.php');
        ob_start();
        require_once(__DIR__ . '/../views/addAdminForm.php');
        $content = ob_get_clean();
        break;

    case 'deleteAdmins':
        require_once(__DIR__ . '/../includes/security.php');
        checkAdminAccess(); 
        require_once(__DIR__ . '/../controllers/deleteAdminProc.php');
        ob_start();
        require_once(__DIR__ . '/../views/deleteAdminsTable.php');
        $content = ob_get_clean();
        break;

    // Redirect unknown pages to login
    default:
        header('Location: index.php?page=login');
        exit;
}
?>
