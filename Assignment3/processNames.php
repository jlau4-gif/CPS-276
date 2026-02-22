<?php
function addClearNames() {
    // Determine action based on which button was clicked
    if ($_POST['action'] === 'clear') {
        return ""; 
    }

    $currentList = $_POST['namelist'];
    $newName = trim($_POST['name']);

    if (!empty($newName)) {
        // Formats names 'Explode"; shows first/last name using space, and makes sure each has a CAP //
        // I used the "strtolower as an extra step from help but it satisfies names are cleaned in case typed odd and part1 outputs right in textbox under list of names //
        $parts = explode(" ", $newName);
        if (count($parts) >= 2) {
            $firstName = ucfirst(strtolower($parts[0]));
            $lastName = ucfirst(strtolower($parts[1]));
            $formattedName = "$lastName, $firstName";

            //  Convert existing textarea string into an array using sort() fuctions to create the names
            $nameArray = !empty(trim($currentList)) ? explode("\n", trim($currentList)) : [];
            
            // Add new name and Sort
            array_push($nameArray, $formattedName);
            sort($nameArray);
            
            // Step 4: Turn array back into a string for the textarea
            return implode("\n", $nameArray);
        }
    }
    return $currentList;
}
?>
