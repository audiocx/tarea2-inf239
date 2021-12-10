<?php
session_start();
require_once 'conexion.php';

if(isset($_POST['submit-actualizar'])){

    $rolActual = $_SESSION['Rol'];
    $nombreUp = $_POST['NombreUp'];
    $_SESSION['Nombre'] = $nombreUp;

    $correoUp = $_POST['CorreoUp'];
    $fecNacUp = $_POST['FecNacUp'];

    $passUp = $_POST['PassUp'];
    $hashedPassUp = hash("sha256", $passUp);

    $queryUpdate = 'UPDATE public."Usuario" SET "Nombre" = ?, "Correo" = ?, "FechaNacimiento" = ?, "Contrasena" = ?
    WHERE "Rol" = ?';
    $buff = $conn->prepare($queryUpdate);
    $buff->execute(array($nombreUp, $correoUp, $fecNacUp, $hashedPassUp, $rolActual));

    header("location: profile.php?success=actualizado&Rol=".$rolActual);
    exit();
} else if(isset($_POST['submit-eliminar'])){

    $rolActual = $_SESSION['Rol'];

    $queryEliminar = 'DELETE FROM public."Usuario" WHERE "Rol" = ?';
    $buff = $conn->prepare($queryEliminar);
    $buff->execute(array($rolActual));

    header("location: includes/logout.inc.php");
    exit();
}

if(isset($_SESSION['Rol']) and isset($_GET['Rol'])){
    if($_SESSION['Rol'] == $_GET['Rol']){

        $rolUsuario = $_SESSION['Rol'];
        $queryUsuario = 'SELECT * FROM public."Usuario" WHERE "Rol" = ?';
        $buff = $conn->prepare($queryUsuario);
        $buff->execute(array($rolUsuario));

        $infoUsuario = $buff->fetch();

        $nombreUsuario = $infoUsuario['Nombre'];
        $correoUsuario = $infoUsuario['Correo'];
        $fechaNacUsuario = $infoUsuario['FechaNacimiento'];
    }
} else{
    header("location: index.php?error=editarSinCampos");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <li><a href="index.php">Página principal</a></li>
    <?php if(isset($_SESSION['Rol'])):?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="profile.php?Rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>
    <br>
    <b>Editar perfil:</b>
    <form action="editprofile.php" method="POST">
        Nombre:<br>
        <input type="text" name="NombreUp" value="<?php echo $nombreUsuario?>"><br>
        Correo:<br>
        <input type="text" name="CorreoUp" value="<?php echo $correoUsuario?>"><br>
        Fecha nacimiento:<br>
        <input type="text" name="FecNacUp" value="<?php echo $fechaNacUsuario?>"><br>
        Nueva contraseña:<br>
        <input type="password" name="PassUp" placeholder="**********"><br>
        <button type="submit" name="submit-actualizar">Actualizar datos</button>
        <button type="submit" name="submit-eliminar">Eliminar cuenta</button>
    </form>
</body>
</html>