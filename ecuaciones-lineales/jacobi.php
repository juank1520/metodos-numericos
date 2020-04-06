<?php
    include_once '../libraries/matrix.php';


    class Jacobi {
        public static function resolveJacobi($matrix, $coefficient, $error = 2) {

            if ( !Matrix::isSquare($matrix) || !Matrix::isSdd($matrix) ) {
                return false;
            }


            $oldResult = Matrix::duplicateMatrix($coefficient, 0);
            $diagonalInv = Matrix::diagonalInverse($matrix);
            $lower = Matrix::lowerTriangular($matrix, true);
            $upper = Matrix::upperTriangular($matrix, true);
            $lowUpper = Matrix::sum($lower, $upper);
            $firstTerm = Matrix::multiply($diagonalInv, $coefficient);
            $secondTerm = Matrix::multiply($diagonalInv, $lowUpper);



            $result = Matrix::multiply($secondTerm, $oldResult);
            $result = Matrix::sum($firstTerm, $result);
            $iteration = 0;

            while (Matrix::errorPercent($result, $oldResult, $error)) {
                $oldResult = $result;
                $result = Matrix::multiply($secondTerm, $result);
                $result = Matrix::sum($firstTerm, $result);

                if($iteration > 100) return false;
                $iteration ++;
           }

            return $result;
        }

        public static function explainJacobi($matrix, $coefficient, $error = 2) {

            if ( !Matrix::isSquare($matrix) || !Matrix::isSdd($matrix) ) {
                return false;
            }

            $oldResult = Matrix::duplicateMatrix($coefficient, 0);
            $diagonalInv = Matrix::diagonalInverse($matrix);
            $lower = Matrix::lowerTriangular($matrix, true);
            $upper = Matrix::upperTriangular($matrix, true);
            $lowUpper = Matrix::sum($lower, $upper);
            $firstTerm = Matrix::multiply($diagonalInv, $coefficient);
            $secondTerm = Matrix::multiply($diagonalInv, $lowUpper);

            $result = Matrix::multiply($secondTerm, $oldResult);
            $result = Matrix::sum($firstTerm, $result);


            $table = '<table class="table table-bordered table-hover"><theader><tr><th>Iteracion</th>';

            for ( $i= 0; $i < count($matrix[0]) ; $i++)
                $table .= '<th> X ' . ($i + 1) . '</th>';

            for ( $i= 0; $i < count($matrix[0]) ; $i++)
                $table .= '<th> Error X' . ($i + 1) . '</th>';

            $table .= '</tr></theader><tbody>';

            $iteration = 0;
            while (Matrix::errorPercent($result, $oldResult, $error)) {
                $iteration++;
                $oldResult = $result;
                $result = Matrix::multiply($secondTerm, $result);
                $result = Matrix::sum($firstTerm, $result);


                $errors = Matrix::errorAprox($result, $oldResult);
                $table .= '<tr>';
                $table .= '<td>' . $iteration . '</td>';
                $table .= Matrix::arrayToHtml($result, 'td');
                $table .= Matrix::arrayToHtml($errors, 'td');
                $table .= '</tr>';

                if($iteration > 100) return false;
            }

            $table .= '</tbody></table>';

            return $table;
        }
    }
