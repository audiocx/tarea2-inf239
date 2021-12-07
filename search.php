<?php

include 'conexion.php';

if(!isset($_GET['busqueda']) or !isset($_GET['tipo'])){
    header("location: index.php?error=faltanCamposBusqueda");
    exit();
} else{
    $busqueda = $_GET['busqueda'];
    $tipo = $_GET['tipo'];
    $fullTipo = null;
    switch($tipo){
        case 'p': 
            $fullTipo = "producto";
            break;
        case 'u':
            $fullTipo = 'usuario';
            break;
        case 'c':
            $fullTipo = 'categoría';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda: <?php echo $busqueda?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <b><a href="index.php">Página principal</a></b>
    <br>
    <br>
    <b>Búsquedas de <?php echo $fullTipo?> relacionadas a: <?php echo $busqueda?></b><br>
    <form action="includes/search.inc.php" method="POST">
        <input type="text" name="busqueda" placeholder="Búsqueda...">
        <select name="tipo">
            <option value="p">Producto</option>
            <option value="u">Usuario</option>
            <option value="c">Categoría</option>
        </select>
        <button type="submit" name="submit-busqueda">Buscar</button>
    </form>
</body>
</html>