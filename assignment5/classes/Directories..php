<?php
class Directories {
    public function createDirectory($dirName, $textContent) {
        if (empty($dirName) || !ctype_alnum($dirName)) {
            return "Folder name should contain alpha numeric characters only.";
        }

        $targetPath = "directories/" . $dirName;

        if (is_dir($targetPath)) {
            return "A directory already exists with that name.";
        }

        // Use the permissions required by the rubric
        if (!mkdir($targetPath, 0777, true)) {
            return "Error: Could not create the directory.";
        }
        chmod($targetPath, 0777); 

        $filePath = $targetPath . "/readme.txt";
        
        if (file_put_contents($filePath, $textContent) !== false) {
            chmod($filePath, 0666); 
            return "File and directory were created<br><a href='{$filePath}' target='_blank'>Path where the file is located</a>";
        } else {
            return "Error: Could not create the file.";
        }
    }
}
?>
