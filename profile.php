<?php

session_start();

if(!isset($_GET['Rol'])){
    header("location: index.php?error=perfilInvalido");
    exit();
} else{
    require_once 'conexion.php';

    $rolUsuario = $_GET['Rol'];

    $queryUsuario = 'SELECT "Nombre", "Correo", "FechaNacimiento" 
    FROM public."Usuario" WHERE "Rol" = ?';
    $buff = $conn->prepare($queryUsuario);
    $buff->execute(array($rolUsuario));

    $infoUsuario = $buff->fetch();

    $queryCompras = 'SELECT "IDAnuncio", "IDProducto", "FechaTransaccion", "Cantidad", "Total"
    FROM public."Transaccion" WHERE "IDComprador" = ? ORDER BY "FechaTransaccion" DESC';

    $queryVentas = 'SELECT "IDAnuncio", "IDProducto", "FechaTransaccion", "Cantidad", "Total"
    FROM public."Transaccion" WHERE "IDVendedor" = ? ORDER BY "FechaTransaccion" DESC';

    if($infoUsuario){
        $nombreUsuario = $infoUsuario['Nombre'];
        $correoUsuario = $infoUsuario['Correo'];
        $fechaNacUsuario = $infoUsuario['FechaNacimiento'];

        $buff = $conn->prepare($queryCompras);
        $buff->execute(array($rolUsuario));
        $comprasUsuario = $buff->fetchAll();

        $buff = $conn->prepare($queryVentas);
        $buff->execute(array($rolUsuario));
        $ventasUsuario = $buff->fetchAll();

    } else{
        header("location: index.php?error=usuarioNoEncontrado");
        exit();
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <li><a href="index.php">Página principal</a></li>
    <?php if(!isset($_SESSION['Rol'])):?>
    <li><a href="login.php">Iniciar Sesion</a></li>
    <li><a href="signup.php">Registrarse</a></li>
    <?php elseif($_SESSION['Rol'] == $_GET['Rol']):?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php else:?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="profile.php?Rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>
    <br>
    <br>
    <b>Perfil:</b>
    <li>Nombre: <?php echo $nombreUsuario ?></li>
    <li>Rol: <?php echo $rolUsuario ?></li>
    <li>Correo: <?php echo $correoUsuario ?></li>
    <li>Fecha de Nacimiento: <?php echo $fechaNacUsuario ?></li>
    <br>
    <?php
        if(isset($_GET['success'])){
            if($_GET['success'] == 'actualizado') echo '<b>¡Perfil actualizado correctamente!</b>';
        }
    ?>
    <br>
    <a href="profile.php?Rol=<?php echo $_GET['Rol']?>&historial=c">Compras</a>
    <a href="profile.php?Rol=<?php echo $_GET['Rol']?>&historial=v">Ventas</a>

    <?php
        if(isset($_SESSION['Rol'])){
            if($_SESSION['Rol'] == $_GET['Rol']){
                echo '<a href="editprofile.php?Rol='.$_SESSION['Rol'].'">Editar Perfil</a>';
            }
        }
    ?>

    <br>
    <br>
    <?php if(isset($_GET['historial'])){
        if($_GET['historial'] == 'c'){
            $productosComprados = 0;

            echo '<b>Historial de compra:</b><br>';
            foreach($comprasUsuario as $compra){
                if($compra){
                    $idAnuncio = $compra['IDAnuncio'];
                    $idProducto = $compra['IDProducto'];
                    $fechaTransaccion = $compra['FechaTransaccion'];
                    $cantidadComprado = $compra['Cantidad'];
                    $total = $compra['Total'];

                    $productosComprados += $cantidadComprado;

                    $queryNombreProducto = 'SELECT "Nombre" FROM public."Producto" WHERE "IDProducto" = ?';
                    $buff = $conn->prepare($queryNombreProducto);
                    $buff->execute(array($idProducto));
                    $nombreProducto = $buff->fetch()['Nombre'];

                    echo '<li><a href="product.php?IDAnuncio='.$idAnuncio.'">'.$nombreProducto.'</a> | Fecha transaccion: '.$fechaTransaccion.' | Cantidad comprada: '.$cantidadComprado.' | Total: '.$total.'</li>';
                }
            }

            echo '<b>Este usuario ha comprado un total de '.$productosComprados.' productos</b><br>';
        } elseif($_GET['historial'] == 'v'){
            $productosVendidos = 0;

            echo '<b>Historial de venta:</b><br>';
            foreach($ventasUsuario as $venta){
                if($venta){
                    $idAnuncio = $venta['IDAnuncio'];
                    $idProducto = $venta['IDProducto'];
                    $fechaTransaccion = $venta['FechaTransaccion'];
                    $cantidadVendido = $venta['Cantidad'];
                    $total = $venta['Total'];

                    $productosVendidos += $cantidadVendido;
                    
                    $queryNombreProducto = 'SELECT "Nombre" FROM public."Producto" WHERE "IDProducto" = ?';
                    $buff = $conn->prepare($queryNombreProducto);
                    $buff->execute(array($idProducto));
                    $nombreProducto = $buff->fetch()['Nombre'];

                    echo '<li><a href="product.php?IDAnuncio='.$idAnuncio.'">'.$nombreProducto.'</a> | Fecha transaccion: '.$fechaTransaccion.' | Cantidad vendida: '.$cantidadVendido.' | Total: '.$total.'</li>';
                }
            }

            echo '<b>Este usuario ha vendido un total de '.$productosVendidos.' productos</b><br>';
        }
    }
    ?>
</body>
</html>