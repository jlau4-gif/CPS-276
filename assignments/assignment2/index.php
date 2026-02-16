<?php

// used to auto generate an array containing every integer from 1 -50 //
$evenNumbers = "Even Numbers: ";
$numbers = range(1, 50);

//foreach loop looks at the array of numbers and uses the module from the if statement to pick only and showcase only the even numbers//
foreach($numbers as $even){
    if ($even % 2 == 0){
        $evenNumbers .= $even .  " - ";

    }
}

// Removes the " - " at the end by using rtrim you remove the last dash that would be at then end "r" removes character from the right " -"
$evenNumbers = rtrim($evenNumbers, " - ");

// $form variable using HeroDoc Syntax <<<EOD to store a large block of HTML ...class = "form-control" 
//mb and mt used to creat margin bottom and margin top
$form = <<<EOD
<form class="mb-3 mt-3">
<div class="mb-3 mt-3">
    <label for="emailinput" class="form-label">Email address</label>
    <input type="email" class="form-control" id="emailinput" placeholder="name@example.com">
</div>
<div class ="mb-3">
    <label for="exampletextarea" class="form-label">Example textarea</label>
    <textarea class="form-control" id="exampletextarea" rows="3"></textarea>
</div>

</form>
EOD;


function createTable($rows, $cols){
    $table = '<table class="table table-bordered">';
    
    // Fixed: changed $$rows to $rows
    for($row = 1; $row <= $rows; $row++){
        $table .= "<tr>"; // Fixed: changed : to ;

        // Fixed: changed : to ; after $col = 1
        for ($col = 1; $col <= $cols; $col++){
            // Fixed: added "col" after the $ sign
            $table .= "<td>Row $row, Col $col</td>";
        }    
        $table .= "</tr>";
    }

    $table .= "</table>";
    return $table;
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--don't forget bootstrap cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="container">
    <?php
    
        echo $evenNumbers;
        
        echo $form; 
        echo createTable(8, 6);
?>
</body>
</html>
