<?php

include 'conexion.php';
if(!isset($_GET['busqueda'])){
    header("location: index.php?error=sinBusqueda");
    exit();
} else{
    $busqueda = $_GET['busqueda'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda: <?php echo $busqueda?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <b>Búsquedas relacionadas a: <?php echo $busqueda?></b>
</body>
</html>