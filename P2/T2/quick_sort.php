<?php

/**
 * Implements the Quick Sort algorithm.
 *
 * @param array $arr The array to be sorted.
 * @return array The sorted array.
 */
function quickSort(array $arr): array
{
    if (count($arr) < 2) {
        return $arr;
    }

    $pivot = $arr[0];
    $less = [];
    $greater = [];

    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] <= $pivot) {
            $less[] = $arr[$i];
        } else {
            $greater[] = $arr[$i];
        }
    }

    return array_merge(quickSort($less), [$pivot], quickSort($greater));
}

?>