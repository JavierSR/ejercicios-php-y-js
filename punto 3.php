<?php

function isSquareMatrix(array $matrix) : bool {
    $rows = count($matrix);
    $isSquare = true;

    foreach($matrix as $row) {
        if(!is_array($row) || count($row) !== $rows) {
            $isSquare = false;
            break;
        }
    }

    return $isSquare;
}

function getAbsoluteValueFromDiagonals(array $matrix) : int {
    if(!isSquareMatrix($matrix)) {
        throw new Exception('La matríz debe ser cuadrada');
    }

    $indexLeft = 0;
    $indexRight = count($matrix) - 1;
    $leftDiagonalSumatory = 0;
    $rightDiagonalSumatory = 0;

    foreach($matrix as $row) {
        $leftDiagonalSumatory += $row[$indexLeft];
        $rightDiagonalSumatory += $row[$indexRight];
        $indexLeft++;
        $indexRight--;    
    }
    
    return abs($leftDiagonalSumatory - $rightDiagonalSumatory);
}

print getAbsoluteValueFromDiagonals([
  [1, 2, 3],
  [4, 5, 6],
  [9, 8, 9],
]);