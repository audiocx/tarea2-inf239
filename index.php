<?php
/*
    include_once 'conexion.php';
    
    $query = 'SELECT * FROM public.test';
    $res = $conn->prepare($query);

    //$nombre = 'asdasdsd';
    //$apellido = 'como estas';
    $res->execute();

    $arrayRes = $res->fetchAll();

    foreach($arrayRes as $dato){
        $nombre = $dato['nombre'];
        $apellido = $dato['apellido'];
        echo 'dato: '.$nombre.' - '.$apellido.'<br>';
    }
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
    <li><a href="index.php">Página principal</a></li>
    <li><a href="login.php">Iniciar Sesion</a></li>
    <li><a href="signup.php">Registrarse</a></li>
    <br>
    <?php if(isset($_GET['login']) and $_GET['login'] == 'success'){
            echo '¡Cuenta creada, inicia sesión para continuar!';
    }?>
    <br>
    <b>Encuentra lo que necesitas:</b>
    <form action="includes/search.inc.php" method="POST">
        <input type="text" name="busqueda" placeholder="Búsqueda...">
        <select name="tipo">
            <option value="p">Producto</option>
            <option value="u">Usuario</option>
            <option value="c">Categoría</option>
        </select>
        <button type="submit" name="submit-busqueda">Buscar</button>
    </form>
    <?php if(isset($_GET['error']) and $_GET['error'] == 'faltanCamposBusqueda'){
            echo '¡Error en la búsqueda!';
    }?>
</body>
</html>