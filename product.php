<?php
session_start();

if(!isset($_GET['IDAnuncio'])){
    header("location: index.php");
    exit();
} else{
    require_once 'conexion.php';

    $IDAnuncio = $_GET['IDAnuncio'];
    $queryAn = 'SELECT * FROM public."Anuncio" WHERE "IDAnuncio" = ?';
    $buff = $conn->prepare($queryAn);
    $buff->execute(array($IDAnuncio));

    $infoAn = $buff->fetch();

    if(!$infoAn){
        header("location: index.php?error=AnuncioNoExiste");
        exit();
    }
    
    $IDVendedor = $infoAn['IDVendedor'];
    $FechaPublicacion = $infoAn['FechaPublicacion'];
    $Descripcion = $infoAn['Descripcion'];
    $CantidadDisponible = $infoAn['CantidadDisponible'];
    $IDProducto = $infoAn['IDProducto'];

    $queryProd = 'SELECT * FROM public."Producto" WHERE "IDProducto" = ?';

    $buff = $conn->prepare($queryProd);
    $buff->execute(array($IDProducto));

    $infoProd = $buff->fetch();

    $NombreProducto = $infoProd['Nombre'];
    $PrecioProducto = $infoProd['Precio'];
    $PromCalificacionProducto = $infoProd['Promedio'];

    $queryCat = 'SELECT "Categoria" FROM public."Categoria" WHERE "IDProducto" = ?';
    $buff = $conn->prepare($queryCat);
    $buff->execute(array($IDProducto));

    $CategoriasProducto = $buff->fetchAll();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncio</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <li><a href="index.php">Página principal</a></li>
    <?php if(!isset($_SESSION['Rol'])):?>
    <li><a href="login.php">Iniciar Sesion</a></li>
    <li><a href="signup.php">Registrarse</a></li>
    <?php else:?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="profile.php?rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>
    <br>
    <?php
        if(isset($_GET['post']) and $_GET['post'] == 'success') echo '<b>¡Anuncio creado!</b>';
    ?>
    <br>
    <br>
    <b>Nombre Producto:</b><br>
    <?php echo $NombreProducto?><br>
    <b>Descripcion:</b><br>
    <?php echo $Descripcion?><br>
    <b>Cantidad disponible:</b><br>
    <?php echo $CantidadDisponible?><br>
    <b>Precio:</b><br>
    <?php echo $PrecioProducto?><br>
    <br>
    <?php if(isset($_SESSION['Rol']) and $CantidadDisponible > 0 and $_SESSION['Rol'] != $IDVendedor):?>
    <form action="product.php?IDAnuncio=<?php echo$_GET['IDAnuncio']?>" method="POST">
        <input type="text" name="cantidadComprada" value="0">
        <button type="submit" name="submit-compra">Agregar al carrito</button>
    </form>
    <?php elseif(isset($_SESSION['Rol'])):?>
        <?php if($_SESSION['Rol'] == $IDVendedor) echo '<b>¡No puedes comprarte a ti mismo!</b>'?>
    <?php elseif(!isset($_SESSION['Rol'])):?>
        <b>¡Inicia sesión para comprar!</b>
    <?php else:?>
        <b>¡Sin stock disponible!</b>
    <?php endif ?>

    <?php
    if(isset($_SESSION['Rol']) and isset($_POST['submit-compra']) and $_POST['cantidadComprada'] > 0){
        $cantidadComprada = $_POST['cantidadComprada'];
        
        if($CantidadDisponible >= $cantidadComprada){
            $queryCarrito = 'INSERT INTO public."Carrito" ("ROLUsuario", "IDAnuncio", "CantidadCompra", "Total")
            VALUES (?, ?, ?, ?)';
            $buff = $conn->prepare($queryCarrito);
            $buff->execute(array($_SESSION['Rol'], $IDAnuncio, $cantidadComprada, $cantidadComprada * $PrecioProducto));
            
            $queryUpdate = 'UPDATE public."Anuncio" SET "CantidadDisponible" = ? WHERE "IDAnuncio" = ?';
            $buff2 = $conn->prepare($queryUpdate);
            $buff2->execute(array($CantidadDisponible - $cantidadComprada, $IDAnuncio));

            if($buff and $buff2) echo '<b>¡Agregado al carrito!</b>';
            else echo '<b>¡Hubo un problema al agregar al carrito!</b>';

        } else echo '<b>¡Cantidad disponible insuficiente!</b>';
    }
    ?>
    <br>
    <br>
    <b>Calificación:</b><br>
    <?php if($PromCalificacionProducto == null){
            echo 'Sin calificaciones';
        } else{
            echo $PromCalificacionProducto;
        }
    ?><br>
    <b>Vendedor:</b><br>
    <a href="profile.php?Rol=<?php echo $IDVendedor?>"><?php echo $IDVendedor?></a><br>
    <b>Fecha de publicación:</b><br>
    <?php echo $FechaPublicacion?><br>
    <b>Categorías:</b><br>
    <?php
    foreach($CategoriasProducto as $cat){
        echo '<li><a href="search.php?tipo=c&busqueda='.$cat['Categoria'].'">'.$cat['Categoria'].'</a></li>';
    }
    ?>

</body>
</html>