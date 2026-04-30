<?php
class Validation {
    private $errors = [];

    // Check format based on regex type and set custom error message if provided
    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            // Alpha characters (upper and lower case), hyphens, apostrophes, spaces only
            'name' => '/^[a-zA-Z\s\'-]+$/',
            
            // Start with a number, then alpha characters, and spaces
            'address' => '/^[0-9]+[a-zA-Z\s]+$/',
            
            // Must be alpha characters only
            'city' => '/^[a-zA-Z]+$/',
            
            // Must be in the format 999.999.9999
            'phone' => '/^\d{3}\.\d{3}\.\d{4}$/',
            
            // Valid email address
            'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            
            // Must have this format mm/dd/yyyy
            'dob' => '/^\d{2}\/\d{2}\/\d{4}$/',
            
            // Letters, numbers, and special characters
            'password' => '/^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]+$/',
            
            'none' => '/.*/'
        ];

        // Use a generic default pattern if the type is not defined
        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }
        return true;
    }

    // Get all validation errors
    public function getErrors() {
        return $this->errors;
    }

    // Check if there are any errors
    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>
