<?php
ob_start();
header('Content-Type: application/json');
require_once '../classes/Pdo_methods.php';

$response = array(
    'masterstatus' => 'error',
    'msg' => 'An error occurred'
);

try {
    // Create PDO methods instance
    $pdo = new PdoMethods();
    
    // Ensure table exists
    $createTableSql = "CREATE TABLE IF NOT EXISTS names (
      id INT(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    
    $pdo->otherNotBinded($createTableSql);
    
    // Delete all names from the database
    $sql = "TRUNCATE TABLE names";
    
    $result = $pdo->otherNotBinded($sql);
    
    if ($result === 'noerror') {
        $response['masterstatus'] = 'success';
        $response['msg'] = 'All names were deleted';
    } else {
        $response['msg'] = 'Failed to clear names';
    }
    
} catch (Exception $e) {
    $response['msg'] = 'Error: ' . $e->getMessage();
}

ob_end_clean();
echo json_encode($response);
?>
