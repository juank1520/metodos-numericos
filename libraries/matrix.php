<?php
class Matrix {

    #es matriz cuadrada?
    public static function isSquare($matrix){
        $square = true;
        for($i=0; $i < count($matrix) ; $i++){
            if( ( count($matrix) != count($matrix[$i]) ) or ($square === false))
                $square = false;
        }
        return $square;
    }


    #estrictamente diagonal dominante?
    public static function isSdd($matrix){
        for($i=0 ; $i<count($matrix) ; $i++){
            $a = abs($matrix[$i][$i]);
            $b = 0;
            for($j=0 ; $j < count($matrix) ; $j++){
                if($j != $i)
                    $b = $b + abs($matrix[$i][$j]);
            }
            if($a <= $b)
                return false;
        }
        return true;
    }


    #devuelve una matriz diagonal
    public static function diagonal($matrix){
        $matrixResult = self::duplicateMatrix($matrix, 0);
        for ($i=0  ; $i < count($matrix) ; $i++ ) {
            $matrixResult[$i][$i] = $matrix[$i][$i];
        }
        return $matrixResult;
    }

    #devuelve una matriz diagonal
    public static function diagonalInverse($matrix){

        $matrixResult = self::duplicateMatrix($matrix, 0);
        for ($i=0  ; $i < count($matrix) ; $i++ ) {
            $matrixResult[$i][$i] = 1/$matrix[$i][$i];
        }
        return $matrixResult;
    }


    #devuelve una matriz triangular superior
    public static function upperTriangular($matrix, $negative = false){
        $factor = $negative ? -1 : 1;

        $matrixResult = self::duplicateMatrix($matrix, 0);
        for ($i=0  ; $i < count($matrix) ; $i++ ) {
            for ($j=0  ; $j < count($matrix[$i]) ; $j++ ) {
                if ($j > $i)
                    $matrixResult[$i][$j] = ($matrix[$i][$j] * $factor);
            }
        }
        return $matrixResult;
    }


    #devuelve una matriz triangular inferior
    public static function lowerTriangular($matrix, $negative = false){
        $factor = $negative ? -1 : 1;
        $matrixResult = self::duplicateMatrix($matrix, 0);
        for ($i=0  ; $i < count($matrix) ; $i++ ) {
            for ($j=0  ; $j < count($matrix[$i]) ; $j++ ) {
                if ($j < $i)
                    $matrixResult[$i][$j] = ($matrix[$i][$j] * $factor);
            }
        }
        return $matrixResult;
    }


    #multiplica dos matrices
    public static function multiply($matrix, $secondMatrix ){
        $matrixResult = [];
        if ( count($secondMatrix) != count($matrix[0]) )
            return 0;

        for ($i = 0 ; $i < count($matrix); $i++ ) {
            $element = 0;
            if (!is_array($secondMatrix[$i])) {
                for ($j = 0 ; $j < count($secondMatrix); $j++) {
                    $element += $matrix[$i][$j] * $secondMatrix[$j];
                }
                $matrixResult[$i] = $element;
            }else{
                array_push($matrixResult, []);
                for ($j = 0 ; $j < count($secondMatrix); $j++) {
                    $element = 0;
                    for ($k = 0 ; $k < count($secondMatrix); $k++) {
                        $element += $matrix[$i][$k] * $secondMatrix[$k][$j];
                    }
                    $matrixResult[$i][$j] = $element;
                }
            }
        }

        return $matrixResult;
    }


    #suma dos matrices
    public static function sum($matrix, $secondMatrix){
        if (count($matrix) != count($secondMatrix)) {
            return false;
        }
        if (is_array($matrix[0])) {
            if ((count($matrix[0]) != count($secondMatrix[0]))) {
                return false;
            }
        }

        $matrixResult = [];

        if(!is_array($matrix[0])){
            for ($i =0 ; $i < count($matrix) ; $i++) {
                $matrixResult[$i] = $matrix[$i] + $secondMatrix[$i];
            }
            return $matrixResult;
        }

        for ($i = 0; $i<count($matrix) ; $i++) {
            array_push($matrixResult, []);
            for ($j = 0; $j < count($matrix[$i]); $j++ ) {
                $matrixResult[$i][$j] = $matrix[$i][$j] + $secondMatrix[$i][$j];
            }
        }

        return $matrixResult;
    }


    #determinante de una matriz
    public static function det($matrix){
        if (count($matrix) !== count($matrix[0])) {
            return false;
        }

        $a = 0;
        for ($i = 0; $i < count($matrix) ; $i++ ) {
            $val = 1;
            for ($o = $i, $j = 0 ; $j < count($matrix[$i]); $o++ , $j++ ) {
                $mod = $o % 3;
                $val = $val * $matrix[$j][$mod];
            }
            $a += $val;
        }

        $b = 0;
        for ($i = 0; $i < count($matrix) ; $i++ ) {
            $val = 1;
            for ($o = $i, $j = count($matrix[$i])-1 ; $j >= 0 ; $o++ , $j-- ) {
                $mod = $o % 3;
                $val = $val * $matrix[$j][$mod];
            }
            $b += $val;
        }

        return $a - $b;
    }


    #matriz transpuesta
    public static function transpose($matrix){
        $newMatrix = [];
        for ( $i=0 ; $i < count($matrix) ; $i++ ) {
            for ($j = 0 ; $j < count($matrix[$i]); $j++ ) {
                $newMatrix[$i][$j] = $matrix[$j][$i];
            }
        }
        return $newMatrix;
    }


    #multiplica un escalar por una matriz
    public static function scalarMultiply($scalar, $matrix){
        $newMatrix = [];

        for ( $i=0; $i < count($matrix); $i++) {
            for ( $j=0; $j < count($matrix[$i]); $j++) {
                $newMatrix[$i][$j] = $scalar * $matrix[$i][$j];
            }
        }
        return $newMatrix;
    }


    #crea una tabla HTML de la matriz
    public static function table($matrix, $ecuation = true ){
        $table = '<table class="table table-bordered table-hover"><tbody>';
        for ($i = 0; $i < count($matrix); $i++ ) {
            $table .= '<tr>';
            $variable = '';
            if(count($matrix[$i]) == 1){
                if ($ecuation) {
                    $variable = '(x'. $i . ') * ';
                }
                $table .= '<td>' . $variable . $matrix[$i] . '</td>';
            }else{
                for( $o=0; $o < count($matrix[$i]) ; $o++ ) {
                    if ($ecuation) {
                        $variable = '(x'. $o . ') * ';
                    }
                    $table .= '<td>' . $variable . $matrix[$i][$o] . '</td>';
                }
            }
            $table .= '</tr>';
        }
        $table .= '</tbody></table>';

        return $table;
    }


    public static function arrayToHtml($array, $tag){
        $html = '';
        for ( $i = 0; $i < count($array) ; $i++  ) {
            $html .= "<$tag>$array[$i]</$tag>";
        }
        return $html;
    }


    #Calcula el error aproximado porcentual devuelve arreglo con los errores
    public static function errorAprox($newResult, $resultAnt){
        $result = [];
        for($i=0 ; $i < count($newResult) ; $i++ ){
            if($newResult[$i] == 0){
                $result[$i] = 0;
            }else{
                $result[$i] = abs(100*($newResult[$i] - $resultAnt[$i])/$newResult[$i]);
            }
        }
        return $result;
    }


    #Calcula el error aproximado porcentual devuelve arreglo con los errores
    public static function errorPercent($result_nuevo, $resultAnt, $error){
        $result = true;
        for($i=0 ; $i < count($result_nuevo) ; $i++ ){
            if($result_nuevo[$i] != 0){
                if( abs(100*($result_nuevo[$i] - $resultAnt[$i])/$result_nuevo[$i]) <= $error )
                    $result = false;
            }
        }
        return $result;
    }


    public static function duplicateMatrix ($matrix, $replaceValor = null ){
        $newMatrix = [];
        for ($i=0 ; $i < count($matrix); $i++ ) {
            if (is_array($matrix[$i])) {
                for( $o=0 ; $o < count($matrix[$i]) ; $o++ ){
                    is_null($replaceValor) ? $newMatrix[$i][$o] = $matrix[$i][$o] : $newMatrix[$i][$o] = $replaceValor;
                }
            }else{
                is_null($replaceValor) ? $newMatrix[$i] = $matrix[$i] : $newMatrix[$i] = $replaceValor;
            }
        }
        return $newMatrix;
    }

}





/*

#Crea las x iniciales
function xinit($matriz , $vInit){
    $mInit = [];
    for($i=0 ; $i<count($matriz) ; $i++ ){
        $mInit[$i] = $vInit;
    }
    return $mInit;
}


#Calcula el error aproximado porcentual devuelve arreglo con los errores
function erraprox($result_nuevo, $result_ant){
    $result = [];
    for($i=0 ; $i < count($result_nuevo) ; $i++ ){
        if($result_nuevo[$i] == 0){
            $result[$i] = 0;
        }else{
            $result[$i] = abs(100*($result_nuevo[$i] - $result_ant[$i])/$result_nuevo[$i]);
        }
    }
    return $result;
}


#Calcula si el error aproximado porcentual es aceptable devuelve boolean
function iferraprox($result_nuevo, $result_ant, $error){
    $result = true;
    for($i=0 ; $i < count($result_nuevo) ; $i++ ){
        if($result_nuevo[$i] != 0){
            if( abs(100*($result_nuevo[$i] - $result_ant[$i])/$result_nuevo[$i]) <= $error )
                $result = false;
        }
    }
    return $result;
}

function echoMatriz($matriz){
    foreach ($matriz as $key => $value) {
        echo "<td>".$value."</td>" ;
    }
}

function echoecua($matriz , $resltados){
    $html = '<table class="col-md-4 table"><tbody>';
    foreach ($matriz as $key => $value) {
        $html .= '<tr>';
        foreach ($matriz[$key] as $key2 => $value2) {
            $html .= '<td>x'.($key2 + 1).' * ('.$value2.')</td>';
        }
        $html .= '<td> = '.$resltados[$key].'</td>';
        $html .= '</tr>';
    }
    $html .='</tbody></table>';
    return $html;
}


function headTabla($matriz){
    $html='<thead style="text-align: center"><tr><th>Iteracion</th>';
    foreach ($matriz as $key => $value) {
        $html .= '<th>X '.($key+1).'</th>';
    }
    foreach ($matriz as $key => $value) {
        $html .= '<th>Error X'.($key+1).'</th>';
    }
    $html .= '</tr></thead>';
    return $html;
}

*/
