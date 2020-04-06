<!DOCTYPE html>
<html>
<head>
	<title >Index</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">

</head>
<body>

<div class="container center">
	<h1 class="text-center">Método iterativo para la solución de sistemas de ecuaciones lineales</h1>

	<br>
    <form id="form1" action="ecuaciones-lineales/form.php" method="POST" class="system">
        <input type="hidden" name="formName" value="jacobi">
        <div class="js-matrix">
            <div class="row js-row">
                <input type="number" class="mini">
                <input type="number" class="mini">
                <input type="number" class="mini">
            </div>
            <div class="row js-row">
                <input type="number" class="mini">
                <input type="number" class="mini">
                <input type="number" class="mini">
            </div>
        </div>

        <div class="js-result">
            <div class="row js-row">
                <input type="number" class="mini">
            </div>
            <div class="row js-row">
                <input type="number" class="mini">
            </div>
        </div>
    </form>


    <input type="button" value="Agregar fila" onclick="addRow()">
    <input type="button" value="Agregar fila" onclick="addColumn()">
    <input type="submit" value="Operar" onclick="result()">

    <h3> Matrix</h3>
    <div class="js-input-matrix"></div>

    <script src="js/index.js">



    </script>
</body>
</html>
