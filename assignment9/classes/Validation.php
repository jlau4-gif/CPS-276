<?php
/**
 * Validation Class
 * Provides validation functionality for form inputs using regex patterns
 */
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        // Updated regex patterns per Assignment 9 specs
        $patterns = [
            // Name Validation: Allows letters only (upper and lower case)
            'name'     => '/^[a-zA-Z]+$/', 
            
            // Email Validation: Matches standard email format example@example.com
            'email'    => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 
            
            // Password Validation: At least 8 characters with 1 uppercase, 1 symbol, and 1 number
            'password' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
            
            'none'     => '/.*/'
        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>
