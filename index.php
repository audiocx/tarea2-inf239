<?php
    include_once 'conexion.php';
    /*
    $query = 'INSERT INTO public.test (nombre, apellido) VALUES (?, ?)';
    $res = $conn->prepare($query);

    $nombre = 'asdasdsd';
    $apellido = 'como estas';

    $res->execute(array($nombre, $apellido));
    */
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenid@ a SansApp</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <b>BIENVENID@ A SANSAPP</b>
    <li><a href="index.php.php">Página principal</a></li>
    <li><a href="login.php">Iniciar Sesion</a></li>
    <li><a href="signup.php">Registrarse</a></li>
    <br>
    <br>
    <b>Encuentra los productos</b>
    <form action="search.php" method="GET">
        <input type="text" name="busqueda" placeholder="Búsqueda...">
        <button type="submit" name="submit-busqueda">Buscar</button>
    </form>
</body>
</html>