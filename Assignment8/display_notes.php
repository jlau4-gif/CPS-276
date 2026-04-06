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
        <h1 class=" mb-4">Display Notes</h1>
        <a href="index.php" class="mb-5 text-decoration-none">Add Note</a>        
        <form method="POST" action="display.php" class="mb-4">
            <div class="form-group mb-4">
                <label for="begDate">Beginning Date</label>
                <input type="date" class="form-control" id="begDate" name="begDate">
            </div>
            <div class="form-group mb-4">
                <label for="endDate">Ending Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate">
            </div>
            <button type="submit" name="getNotes" class="btn btn-primary">Get Notes</button>
        </form>

        <div>
            <?php echo $notes; ?>
        </div>
    </div>
</body>
</html>
