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
    /* Makes both the input and the textarea match in width */
    input[type="text"], 
    textarea {
        width: 100%;             /* Fills the container */
        box-sizing: border-box;  /* Includes padding in the width calculation */
        padding: 10px;           /* Adds space inside the boxes */
        border: 1px solid #ccc;
        border-radius: 4px;      /* Matches the rounded look in the screenshot */
        margin-top: 5px;
        margin-bottom: 15px;     /* Adds spacing between elements */
    }

    /* Styles the labels to sit above the boxes */
    label {
        font-weight: normal;
        font-family: sans-serif;
    }
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
    
    <form method="post" action="index.php">
         <div id="message">
        <?php echo $output; ?>
        <div>
        <label for="folderName">Folder Name</label><br>
        <input type="text" name="folderName" id="folderName" cols="100"></textarea><br><br>

        <label for="fileContent">File Content</label><br>
        <textarea name="fileContent" id="fileContent" rows="7" cols="100"></textarea><br><br>

        <input type="submit" name="Submit" value="Submit">
    </form>
</body>


