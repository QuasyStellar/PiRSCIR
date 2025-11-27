<?php

// Define constants for shapes
define('SHAPE_CIRCLE', 0b00);
define('SHAPE_RECTANGLE', 0b01);

/**
 * Creates an encoded integer from shape, color, and size components.
 *
 * @param int $shape The shape constant (SHAPE_CIRCLE or SHAPE_RECTANGLE).
 * @param int $red The red color component (0-255).
 * @param int $green The green color component (0-255).
 * @param int $blue The blue color component (0-255).
 * @param int $size The size component (radius for circle, or side for rectangle).
 * @return int The encoded integer.
 */
function createEncodedValue(int $shape, int $red, int $green, int $blue, int $size): int
{
    return ($size << 26) | ($blue << 18) | ($green << 10) | ($red << 2) | $shape;
}

/**
 * Decodes a simple integer ID into a complex encoded value for SVG generation.
 * This function provides user-friendly presets.
 *
 * @param int $id The simple ID (1, 2, 3, etc.).
 * @return int The complex encoded value, or a default if the ID is unknown.
 */
function decodeSimpleId(int $id): int
{
    switch ($id) {
        case 1: // Red Circle
            return createEncodedValue(SHAPE_CIRCLE, 255, 0, 0, 30);
        case 2: // Blue Rectangle
            return createEncodedValue(SHAPE_RECTANGLE, 0, 0, 255, 30);
        case 3: // Green Circle
            return createEncodedValue(SHAPE_CIRCLE, 0, 255, 0, 40);
        case 4: // Yellow Rectangle
            return createEncodedValue(SHAPE_RECTANGLE, 255, 255, 0, 25);
        case 5: // Purple Circle (larger)
            return createEncodedValue(SHAPE_CIRCLE, 128, 0, 128, 50);
        default: // Default to Red Circle
            return createEncodedValue(SHAPE_CIRCLE, 255, 0, 0, 30);
    }
}

/**
 * Generates an SVG string based on the encoded integer.
 *
 * The integer is encoded as follows:
 * - Last 2 bits: Shape (00: circle, 01: rectangle)
 * - Next 8 bits: Red color component
 * - Next 8 bits: Green color component
 * - Next 8 bits: Blue color component
 * - Next 6 bits: Size (radius for circle, side for square/rectangle)
 *
 * @param int $encodedValue The integer containing encoded shape, color, and size.
 * @return string The SVG string.
 */
function generateSvg(int $encodedValue): string
{
    // Extract components using bitwise operations
    $shape = ($encodedValue >> 0) & 0b11; // Last 2 bits for shape
    $red = ($encodedValue >> 2) & 0xFF; // Next 8 bits for Red
    $green = ($encodedValue >> 10) & 0xFF; // Next 8 bits for Green
    $blue = ($encodedValue >> 18) & 0xFF; // Next 8 bits for Blue
    $size = ($encodedValue >> 26) & 0x3F; // Next 6 bits for Size (max 63)

    // Ensure size is at least 10 to be visible
    $size = max(10, $size);

    $svgContent = '';
    $color = "rgb($red, $green, $blue)";

    switch ($shape) {
        case SHAPE_CIRCLE:
            $radius = $size;
            $cx = $radius + 5; // Add some padding
            $cy = $radius + 5; // Add some padding
            $viewBoxSize = ($radius * 2) + 10;
            $svgContent = "<circle cx=\"$cx\" cy=\"$cy\" r=\"$radius\" fill=\"$color\" />";
            break;
        case SHAPE_RECTANGLE:
            $width = $size * 2;
            $height = $size;
            $x = 5; // Add some padding
            $y = 5; // Add some padding
            $viewBoxWidth = $width + 10;
            $viewBoxHeight = $height + 10;
            $svgContent = "<rect x=\"$x\" y=\"$y\" width=\"$width\" height=\"$height\" fill=\"$color\" />";
            break;
        default:
            // Fallback for unknown shape or no shape
            return "<!-- Invalid shape encoded -->";
    }

    // Wrap in full SVG tag
    // For rectangles, viewBox needs to adapt to width/height
    if ($shape === SHAPE_RECTANGLE) {
        return "<svg width=\"{$viewBoxWidth}\" height=\"{$viewBoxHeight}\" viewBox=\"0 0 {$viewBoxWidth} {$viewBoxHeight}\" xmlns=\"http://www.w3.org/2000/svg\">{$svgContent}</svg>";
    } else {
        return "<svg width=\"{$viewBoxSize}\" height=\"{$viewBoxSize}\" viewBox=\"0 0 {$viewBoxSize} {$viewBoxSize}\" xmlns=\"http://www.w3.org/2000/svg\">{$svgContent}</svg>";
    }
}

?>
