<?php

session_start();

if(!isset($_SESSION['Rol']) or !isset($_POST['submit-pagar'])){
    header("location: ../index.php?error=noLoggeado");
    exit();
} else{
    require_once '../conexion.php';

    $idComprador = $_SESSION['Rol'];

    $queryCarrito = 'SELECT * FROM public."Carrito" WHERE "ROLUsuario" = ?';
    $buff = $conn->prepare($queryCarrito);
    $buff->execute(array($idComprador));

    $carrito = $buff->fetchAll();

    $queryAnuncio = 'SELECT * FROM public."Anuncio" WHERE "IDAnuncio" = ?';

    $queryInsertTransaccion = 'INSERT INTO public."Transaccion" 
    ("IDComprador", "IDVendedor", "IDAnuncio", "IDProducto", "FechaTransaccion", "Cantidad", "Total") 
    VALUES (?, ?, ?, ?, ?, ?, ?)';

    foreach($carrito as $item){
        $idAnuncio = $item['IDAnuncio'];
        $cantidadCompra = $item['CantidadCompra'];
        $total = $item['Total'];

        $buff = $conn->prepare($queryAnuncio);
        $buff->execute(array($idAnuncio));
        $anuncio = $buff->fetch();

        $idVendedor = $anuncio['IDVendedor'];
        $idProducto = $anuncio['IDProducto'];
        
        $buff = $conn->prepare($queryInsertTransaccion);
        $buff->execute(array($idComprador, $idVendedor, $idAnuncio, $idProducto, date("Y-m-d H:m:s"), $cantidadCompra, $total));
    }

    $queryEliminarCarrito = 'DELETE FROM public."Carrito" WHERE "ROLUsuario" = ?';
    $buff = $conn->prepare($queryEliminarCarrito);
    $buff->execute(array($idComprador));

    header("location: ../cart.php?success=pagado");
    exit();
}