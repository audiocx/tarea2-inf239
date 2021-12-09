<?php
session_start();

if(!isset($_SESSION['Rol'])){
    header("location: index.php?error=noLoggeado");
    exit();
} else{
    require_once 'conexion.php';

    $queryCarrito = 'SELECT * FROM public."Carrito" WHERE "ROLUsuario" = ?';
    $buff = $conn->prepare($queryCarrito);
    $buff->execute(array($_SESSION['Rol']));

    $carrito = $buff->fetchAll();
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
    <?php
    if(isset($_GET['success'])){
        if($_GET['success'] == 'pagado') echo '<b>¡Pagado con exito!</b>';
    }
    ?>
    <br>
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
                Cantidad: 
                <form action="cart.php?update='.$idAnuncio.'" method="POST">
                    <input type="text" name="cantidadActualizar" value="'.$cantidad.'" style="width: 30px">
                    <button type="submit" name="submit-actualizar'.$idAnuncio.'">Actualizar</button>
                </form> | 
                Total: '.$total.'
                </li><br>';
            }

            echo '<b>SUBTOTAL: '.$subtotal.'</b>';
            echo '<form action="includes/checkout.inc.php" method="POST"><button type="submit" name="submit-pagar">Pagar</button></form>';
        } else echo '<b>¡No tienes productos agregados al carrito!</b>';
    ?>
    <br>

</body>
</html>