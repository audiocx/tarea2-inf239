<?php
session_start();

require_once 'conexion.php';

if(!isset($_SESSION['Rol'])){
    header("location: index.php?error=noLoggeado");
    exit();
} else{

    $IDComprador = $_SESSION['Rol'];

    if(isset($_POST['submit-actualizar']) and isset($_GET['update'])){
        $idAnuncioActualizar = $_GET['update'];
        
        $cantidadActualizar = $_POST['cantidadActualizar'];

        $queryInfoAnuncio = 'SELECT * FROM public."Anuncio" WHERE "IDAnuncio" = ?';
        $buff = $conn->prepare($queryInfoAnuncio);
        $buff->execute(array($idAnuncioActualizar));
        $infoAnuncio = $buff->fetch();

        $cantidadDisponible = $infoAnuncio['CantidadDisponible'];

        $queryInfoCarrito = 'SELECT * FROM public."Carrito" WHERE "ROLUsuario" = ? and "IDAnuncio" = ?';
        $buff = $conn->prepare($queryInfoCarrito);
        $buff->execute(array($IDComprador, $idAnuncioActualizar));

        $infoCarrito = $buff->fetch();

        $precioTotal = $infoCarrito['Total'];
        $cantidadAnterior = $infoCarrito['CantidadCompra'];
        $precioUnidad = $precioTotal / $cantidadAnterior;

        if($cantidadDisponible >= $cantidadActualizar - $cantidadAnterior and $cantidadActualizar > 0){
            $queryActualizarCarrito = 'UPDATE public."Carrito"
            SET "CantidadCompra" = ?, "Total" = ?
            WHERE "ROLUsuario" = ? and "IDAnuncio" = ?';

            $buff = $conn->prepare($queryActualizarCarrito);
            $buff->execute(array($cantidadActualizar, $cantidadActualizar * $precioUnidad, $IDComprador, $idAnuncioActualizar));

            $queryActualizarAnuncio = 'UPDATE public."Anuncio"
            SET "CantidadDisponible"=?
            WHERE "IDAnuncio" = ?';

            $buff = $conn->prepare($queryActualizarAnuncio);
            $buff->execute(array($cantidadDisponible + $cantidadAnterior - $cantidadActualizar, $idAnuncioActualizar));
            header("location: cart.php?success=update");
            exit();
        } else{
            header("location: cart.php?error=falloActualizar");
            exit();
        }
    }

    $queryCarrito = 'SELECT * FROM public."Carrito" WHERE "ROLUsuario" = ?';
    $buff = $conn->prepare($queryCarrito);
    $buff->execute(array($IDComprador));

    $carrito = $buff->fetchAll();

    if(isset($_GET['vaciar'])){
        if($_GET['vaciar'] == 'true'){
            $queryUpdateAnuncio = 'UPDATE public."Anuncio"
            SET "CantidadDisponible" = "CantidadDisponible" + ?
            WHERE "IDAnuncio" = ?';
            foreach($carrito as $item){
                $cantidadComprada = $item['CantidadCompra'];
                $idAnuncio = $item['IDAnuncio'];

                $buff = $conn->prepare($queryUpdateAnuncio);
                $buff->execute(array($cantidadComprada, $idAnuncio));
            }
            $queryVaciarCarrito = 'DELETE FROM public."Carrito"
            WHERE "ROLUsuario" = ?';

            $buff = $conn->prepare($queryVaciarCarrito);
            $buff->execute(array($IDComprador));

            header("location: cart.php?success=vaciarCarrito");
            exit();
        }
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compra</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <li><a href="index.php">Página principal</a></li>
    <?php if(isset($_SESSION['Rol'])):?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><a href="profile.php?Rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>
    <br>
    <?php if(isset($_GET['success'])) if($_GET['success'] == 'pagado') echo '<b>¡Pagado con exito!</b>';?>
    <?php if(isset($_GET['success'])) if($_GET['success'] == 'vaciarCarrito') echo '<b>¡Carrito vaciado con exito!</b>';?>
    <?php if(isset($_GET['error'])) if($_GET['error'] == 'falloActualizar') echo '<b>¡Cantidad insuficiente o ingreso 0!</b>';?>
    <br>
    <b>Carrito de compras:</b><br>
    <?php
        $subtotal = 0;

        if($carrito){
            foreach($carrito as $item){
                $cantidad = $item['CantidadCompra'];
                $total = $item['Total'];
                $subtotal += $total;
                //
                $idAnuncio = $item['IDAnuncio'];
                $queryAn = 'SELECT * FROM public."Anuncio" WHERE "IDAnuncio" = ?';
                $buff = $conn->prepare($queryAn);
                $buff->execute(array($idAnuncio));

                $idProducto = $buff->fetch()['IDProducto'];
                $queryProd = 'SELECT * FROM public."Producto" WHERE "IDProducto" = ?';
                $buff = $conn->prepare($queryProd);
                $buff->execute(array($idProducto));
                //
                $nombreProducto = $buff->fetch()['Nombre'];

                echo '<li><a href="product.php?IDAnuncio='.$idAnuncio.'">'.$nombreProducto.'</a> | 
                <form action="cart.php?update='.$idAnuncio.'" method="POST">
                    Cantidad: 
                    <input type="text" name="cantidadActualizar" value="'.$cantidad.'" style="width: 30px">
                    <button type="submit" name="submit-actualizar">Actualizar</button>
                    | Total: '.$total.'
                </form></li>';
            }

            echo '<b>SUBTOTAL: '.$subtotal.'</b>';
            echo '<form action="includes/checkout.inc.php" method="POST"><button type="submit" name="submit-pagar">Pagar</button></form>';
        } else echo '<b>¡No tienes productos agregados al carrito!</b>';
    ?>
    <?php if($carrito):?>
    <a href="cart.php?vaciar=true">Vaciar Carrito</a>
    <?php endif?>

</body>
</html>