<?php
class Calculator {
    public function calc($operator = null, $num1 = null, $num2 = null) {
     
        if (is_null($operator) || !is_numeric($num1) || !is_numeric($num2)) {
            return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        switch ($operator) {
            case '+':
                $answer = $num1 + $num2;
                break;
            case '-':
                $answer = $num1 - $num2;
                break;
            case '*':
                $answer = $num1 * $num2;
                break;
            case '/':
                // Check for division by zero
                if ($num2 == 0) {
                    $answer = "cannot divide a number by zero";
                } else {
                    $answer = $num1 / $num2;
                }
                break;
            default:
                // Invalid operator
                return "<p>Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>";
        }

        return "<p>The calculation is $num1 $operator $num2. The answer is $answer.</p>";
    }
}
?> 
