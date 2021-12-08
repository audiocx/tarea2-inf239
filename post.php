<?php
    session_start();

    if(!isset($_SESSION['Rol'])){
        header("location: index.php?error=noLoggeado");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar producto</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <li><a href="index.php">Página principal</a></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="profile.php?rol=<?php echo $_SESSION['Rol']?>">Mi perfil: <?php echo $_SESSION['Nombre']?></a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <br>
    <br>
    <b>Formulario de publicación:</b>
    <form action="includes/post.inc.php" method="POST">
        Nombre Producto:<br>
        <input type="text" name="nombreProducto" placeholder="Nombre"><br>
        Descripción:<br>
        <input type="text" name="descripcionProducto" placeholder="Descripción"><br>
        Categorías (separadas por comas):<br>
        <input type="text" name="categoriasProducto" placeholder="Categorías"><br>
        Precio:<br>
        <input type="text" name="precioProducto" placeholder="Precio"><br>
        Cantidad disponible:<br>
        <input type="text" name="cantidadDisponible" placeholder="Cantidad"><br>
        <button type="submit" name="submit-post">Publicar anuncio</button>
    </form>
</body>
</html>