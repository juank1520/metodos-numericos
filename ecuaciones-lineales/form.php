<?php
    include_once 'jacobi.php';

     if (isset($_POST['name'])) {
         if ($_POST['name'] == 'jacobi' ) {
             if(isset($_POST['matrix']) && isset($_POST['results']))
                $matrix = json_decode($_POST['matrix']);
                $result = json_decode($_POST['results']);
                echo Jacobi::explainJacobi($matrix, $result, 0.05);
         }
     }


class form{ }
