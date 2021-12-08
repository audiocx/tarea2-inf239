<?php

session_start();

if(!isset($_GET['busqueda']) or !isset($_GET['tipo'])){
    header("location: index.php?error=faltanCamposBusqueda");
    exit();
} else{
    require_once 'conexion.php';

    $busqueda = $_GET['busqueda'];
    $tipo = $_GET['tipo'];
    $fullTipo = "";
    switch($tipo){
        case 'p': 
            $queryProd = 'SELECT * FROM public."Producto" WHERE "Nombre" LIKE ?';
            $buff = $conn->prepare($queryProd);
            $buff->execute(array('%'.$busqueda.'%'));
            $productos = $buff->fetchAll();

            $fullTipo = "producto";
            break;
        case 'u':
            $queryUsu = 'SELECT * FROM public."Usuario" WHERE "Rol" = ?';
            $buff = $conn->prepare($queryUsu);
            $buff->execute(array($busqueda));
            $usuario = $buff->fetch();

            $fullTipo = 'usuario';
            break;
        case 'c':
            $queryCat = 'SELECT * FROM public."Categoria" WHERE "Categoria" LIKE ?';
            $buff = $conn->prepare($queryCat);
            $buff->execute(array('%'.$busqueda.'%'));
            $productosCat = $buff->fetchAll();

            $fullTipo = 'categoría';
            break;
        default:
            header("location: index.php?error=entradaInvalida");
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
    <title>Búsqueda: <?php echo $busqueda?></title>
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
    <li><a href="profile.php?Rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>

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

    <?php if($_GET['tipo'] == 'p'){
        if($productos){
            foreach($productos as $prod){
                $nombreProducto = $prod['Nombre'];
                $precioProducto = $prod['Precio'];
                $idProducto = $prod['IDProducto'];
    
                $queryAn = 'SELECT * FROM public."Anuncio" WHERE "IDProducto" = ?';
                $buff = $conn->prepare($queryAn);
                $buff->execute(array($idProducto));

                $anuncio = $buff->fetch();

                $idAnuncio = $anuncio['IDAnuncio'];
                $cantidadDisponible = $anuncio['CantidadDisponible'];
    
                echo '<li><a href="product.php?IDAnuncio='.$idAnuncio.'">'.$nombreProducto.'</a> | Cantidad disponible: '.$cantidadDisponible.' | Precio: '.$precioProducto.'</li>';
            }
        }
        else echo '<b>¡0 resultados de producto encontrados!</b>';
    } else if($_GET['tipo'] == 'u'){
        if($usuario){
            $nombreUsuario = $usuario['Nombre'];
            $rol = $usuario['Rol'];
            echo '<li><a href="profile.php?Rol='.$rol.'">'.$nombreUsuario.'</a></li>';
        }
        else echo '<b>¡0 resultados de usuario encontrados!</b>';
    } else if($_GET['tipo'] == 'c'){
        if($productosCat){
            foreach($productosCat as $prod){
                $idProducto = $prod['IDProducto'];

                $queryNombreProductos = 'SELECT * FROM public."Producto" WHERE "IDProducto" = ?';
                $buff = $conn->prepare($queryNombreProductos);
                $buff->execute(array($idProducto));

                $producto = $buff->fetch();
                $nombreProducto = $producto['Nombre'];
                $precioProducto = $producto['Precio'];

                $queryAn = 'SELECT * FROM public."Anuncio" WHERE "IDProducto" = ?';
                $buff = $conn->prepare($queryAn);
                $buff->execute(array($idProducto));
                
                $anuncio = $buff->fetch();

                $idAnuncio = $anuncio['IDAnuncio'];
                $cantidadDisponible = $anuncio['CantidadDisponible'];
                
                echo '<li><a href="product.php?IDAnuncio='.$idAnuncio.'">'.$nombreProducto.'</a> | Cantidad disponible: '.$cantidadDisponible.' | Precio: '.$precioProducto.'</li>';
            }
        }
        else echo '<b>¡0 resultados de categoria encontrados!</b>';
    }
    ?>
    

</body>
</html>