<?php
ob_start();
header('Content-Type: application/json');
require_once '../classes/Pdo_methods.php';

$response = array(
    'masterstatus' => 'error',
    'names' => '',
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
    
    // Retrieve all names from the database
    $sql = "SELECT id, name FROM names ORDER BY id DESC";
    
    $result = $pdo->selectNotBinded($sql);
    
    if ($result === 'error') {
        $response['msg'] = 'Failed to retrieve names';
        echo json_encode($response);
        exit;
    }
    
    // Build the HTML table
    if (count($result) > 0) {
        $html = '<div>';
        
        foreach ($result as $row) {
            $html .= '<p>' . htmlspecialchars($row['name']) . '</p>';
        }
        
        $html .= '</div>';
        
        $response['masterstatus'] = 'success';
        $response['names'] = $html;
        $response['msg'] = count($result) . ' name(s) found';
    } else {
        $response['masterstatus'] = 'success';
        $response['names'] = '<p>No names to display</p>';
        $response['msg'] = 'Database is empty';
    }
    
} catch (Exception $e) {
    $response['msg'] = 'Error: ' . $e->getMessage();
}

ob_end_clean();
echo json_encode($response);
?>
