<?php
ob_start();
header('Content-Type: application/json');
require_once '../classes/Pdo_methods.php';

$response = array(
    'masterstatus' => 'error',
    'msg' => 'An error occurred'
);

try {
    // Get the JSON data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    
    // The JS sends the input value under the property 'name'
    if (empty($data['name'])) {
        $response['msg'] = 'Name cannot be empty';
        echo json_encode($response);
        exit;
    }
    
    $fullName = trim($data['name']);
    
    // Split the name into an array: [0] => Firstname, [1] => Lastname
    $nameParts = explode(" ", $fullName, 2);
    
    // Rearrange to "Lastname, Firstname" if two names were provided
    if (count($nameParts) === 2) {
        $formattedName = $nameParts[1] . ", " . $nameParts[0];
    } else {
        // Fallback if they only type one word
        $formattedName = $fullName; 
    }
    
    // Connect to DB
    $pdo = new PdoMethods();
    
    // Ensure table exists
    $createTableSql = "CREATE TABLE IF NOT EXISTS names (
      id INT(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    
    $pdo->otherNotBinded($createTableSql);
    
    // Insert the name into the database
    $sql = "INSERT INTO names (name) VALUES (:name)";
    $bindings = array(
        array(':name', $formattedName, 'str')
    );
    
    $result = $pdo->otherBinded($sql, $bindings);
    
    if ($result === 'noerror') {
        $response['masterstatus'] = 'success';
        $response['msg'] = 'Name has been added';
    } else {
        $response['msg'] = 'Failed to add name';
    }
    
} catch (Exception $e) {
    $response['msg'] = 'Error: ' . $e->getMessage();
}

ob_end_clean();
echo json_encode($response);
?>

