<?php

require_once 'quick_sort.php';

// Get the 'arr' parameter from the GET request
$arrString = filter_input(INPUT_GET, 'arr', FILTER_SANITIZE_STRING);

$originalArray = [];
if (!empty($arrString)) {
    // Convert the comma-separated string to an array of integers
    $originalArray = array_map('intval', explode(',', $arrString));
}

// Perform Quick Sort
$sortedArray = quickSort($originalArray);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Sort Result</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        p { margin-bottom: 10px; }
        .array-display { background: #e0e0e0; padding: 10px; border-radius: 4px; margin-top: 5px; word-wrap: break-word; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quick Sort Result</h1>

        <p><span class="label">Original Array:</span></p>
        <div class="array-display">
            <?php echo implode(', ', $originalArray); ?>
        </div>

        <p><span class="label">Sorted Array:</span></p>
        <div class="array-display">
            <?php echo implode(', ', $sortedArray); ?>
        </div>

        <p>Try with parameter: <code>?arr=5,2,9,1,5,6,3</code></p>
    </div>
</body>
</html>