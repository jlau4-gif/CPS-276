<?php
$output = "";
if (isset($_POST['Submit'])) {
    require_once 'classes/Directories.php';
    $directoryManager = new Directories();
    $output = $directoryManager->createDirectory($_POST['folderName'], $_POST['fileContent']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File and Directory Assignment</title>
   <style>
    /* This targets the submit button specifically */
    input[type="submit"] {
        background-color: #007bff; /* A standard blue color */
        color: white;              /* White text */
        padding: 10px 20px;       /* Adds some space inside the button */
        border: none;              /* Removes the default gray border */
        border-radius: 4px;       /* Rounds the corners slightly */
        cursor: pointer;           /* Changes the mouse to a hand icon */
        font-size: 16px;
    }

    /* This changes the color slightly when you hover over it */
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <h1>File and Directory Assignment</h1>
    <p>Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.</p>
    
    <div id="message">
        <?php echo $output; ?>
    </div>

    <form method="post" a<?php
$output = "";
if (isset($_POST['Submit'])) {
    // This tells PHP to go look inside the 'classes' folder
    require_once 'classes/Directories.php';
    $directoryManager = new Directories();
    $output = $directoryManager->createDirectory($_POST['folderName'], $_POST['fileContent']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File and Directory Assignment</title>
    <style>
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>File and Directory Assignment</h1>
    <p>Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.</p>
    
    <div id="message"><?php echo $output; ?></div>

    <form method="post" action="index.php">
        <label for="folderName">Folder Name</label><br>
        <input type="text" name="folderName" id="folderName"><br><br>

        <label for="fileContent">File Content</label><br>
        <textarea name="fileContent" id="fileContent" rows="7" cols="100"></textarea><br><br>

        <input type="submit" name="Submit" value="Submit">
    </form>
</body>
</html>ction="index.php">
        <div class="form-wrapper">
            <label for="folderName">Folder Name</label><br>
            <textarea type="text" name="folderName" id="folderName" rows="1" cols="100"></textarea><br><br>


            <label for="fileContent">File Content</label><br>
            <textarea name="fileContent" id="fileContent" rows="7" cols="100"></textarea><br><br>

            <div class="form-actions">
                <input type="submit" name="Submit" value="Submit">
            </div>
        </div>
    </form>
</body>
</html>
