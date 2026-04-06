<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$notes = $dt->checkSubmit();
?>


<!DOCTYPE html>
<html lang ="en">
<head>
    <title>Assignment 8 - Add Note</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-3">Add Note</h1>
        <a href="display.php" class="d-block mb-3 text-decoration-none">Display Notes</a>        
        <?php echo $notes; ?>

        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="dateTime">Date and Time</label>
                <input type="datetime-local" class="form-control" id="dateTime" name="dateTime">
            </div>  
            <div class="form-group mb-3">
                <label for="note">Note</label>
                <textarea class="form-control" id="note" name="note" rows="5"></textarea>
            </div>
            <button type="submit" name="addNote" class="btn btn-primary">Add Note</button>
        </form>
    </div>
</body>
</html>
