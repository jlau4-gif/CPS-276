<?php
$output = "";

// Check if the form was submitted via POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'processNames.php';
    //  Assign the result to $output so it matches your textarea echo
    $output = addClearNames();
}
?>

<body class="container"> 
    <h1>Add Names</h1>
    <form method="post" action="index.php">
        <div>
            <button type="submit" name="action" value="add" class="btn btn-primary">Add Name</button>
            <button type="submit" name="action" value="clear" class="btn btn-primary">Clear Names</button>
        <div>

        </div>
            <label for="name" class="form-label">Enter Name</label>
            <input type="text" class="form-control" id="name" name="name">

        </div>

        <div class= "mt-3">
            <label for="namelist" class="form-label">List of Names</label>
            <textarea style="height: 500px;" class="form-control" id="namelist" name="namelist">
<?php echo $output; ?></textarea>

        </div>
    </form>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <title>Assignment 3 - Name List</title>
</head>
