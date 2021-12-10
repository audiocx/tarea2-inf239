<?php
session_start();

require_once 'conexion.php';

if(isset($_POST['submit-actualizar']) and isset($_SESSION['Rol']) and isset($_GET['IDAnuncio']) and isset($_GET['IDProducto'])){
    
    $nombreUp = $_POST['nombreUp'];
    $descripcionUp = $_POST['descripcionUp'];
    $precioUp = $_POST['precioUp'];
    $cantidadUp = $_POST['cantidadUp'];

    $IDAnuncio = $_GET['IDAnuncio'];
    $IDProducto = $_GET['IDProducto'];
    
    $queryUpdateProducto = 'UPDATE public."Producto"
	SET "Nombre" = ?, "Precio" = ? WHERE "IDProducto" = ?';
    $queryUpdateAnuncio = 'UPDATE public."Anuncio"
	SET "Descripcion" = ?, "CantidadDisponible" = ? WHERE "IDAnuncio" = ?';

    $buff = $conn->prepare($queryUpdateProducto);
    $buff->execute(array($nombreUp, $precioUp, $IDAnuncio));

    $buff = $conn->prepare($queryUpdateAnuncio);
    $buff->execute(array($descripcionUp, $cantidadUp, $IDAnuncio));

    header("location: product.php?IDAnuncio=".$IDAnuncio."&success=anuncioActualizado");
    exit();
}

if(isset($_SESSION['Rol']) and isset($_GET['IDAnuncio'])){

    $IDAnuncio = $_GET['IDAnuncio'];
    $queryAnuncio = 'SELECT * FROM public."Anuncio" WHERE "IDAnuncio" = ?';
    $buff = $conn->prepare($queryAnuncio);
    $buff->execute(array($IDAnuncio));
    $infoAnuncio = $buff->fetch();

    $queryProducto = 'SELECT * FROM public."Producto" WHERE "IDProducto" = ?';

    if($infoAnuncio){
        $descripcion = $infoAnuncio['Descripcion'];
        $cantidadDisponible = $infoAnuncio['CantidadDisponible'];
        $idProducto = $infoAnuncio['IDProducto'];

        $buff = $conn->prepare($queryProducto);
        $buff->execute(array($idProducto));
        $infoProducto = $buff->fetch();

        $nombreProducto = $infoProducto['Nombre'];
        $precioProducto = $infoProducto['Precio'];
    } else{
        header("location: index.php?error=anuncioNoExiste");
        exit();
    }
} else{
    header("location: product.php?".$_GET['IDAnuncio']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar anuncio ID: <?php echo $IDAnuncio?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<li><a href="index.php">Página principal</a></li>
    <?php if(isset($_SESSION['Rol'])):?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="profile.php?rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>
    <br>
    <br>
    <b>Editar producto:</b><br><br>
    <form action="editproduct.php?IDAnuncio=<?php echo $IDAnuncio?>&IDProducto=<?php echo $idProducto?>" method="POST">
        Nombre producto:<br>
        <input type="text" name="nombreUp" value="<?php echo $nombreProducto?>"><br>
        Descripción:<br>
        <input type="text" name="descripcionUp" value="<?php echo $descripcion?>"><br>
        Precio:<br>
        <input type="text" name="precioUp" value="<?php echo $precioProducto?>"><br>
        Cantidad disponible:<br>
        <input type="text" name="cantidadUp" value="<?php echo $cantidadDisponible?>"><br>
        <button type="submit" name="submit-actualizar">Actualizar anuncio</button>
    </form>
</body>
</html>