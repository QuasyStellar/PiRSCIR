<?php

require_once 'svg_generator.php';

// Set content type to SVG
header('Content-Type: image/svg+xml');

// Get the 'id' parameter from the GET request
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// If 'id' is not a valid integer or not provided, use a default value (e.g., ID 1: Red Circle)
if ($id === false || $id === null) {
    $id = 1; // Default to ID 1 (Red Circle)
}

// Decode the simple ID to get the complex encoded value
$encodedValue = decodeSimpleId($id);

// Generate and output the SVG
echo generateSvg($encodedValue);

?>
