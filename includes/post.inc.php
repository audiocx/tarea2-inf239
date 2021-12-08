<?php

if(!isset($_POST['submit-post'])){
    header("location: ../post.php?error=faltanCampos");
    exit();
} else{
    require_once '../conexion.php';
    session_start();

    $nombreProducto = $_POST['nombreProducto'];
    $descripcionProducto = $_POST['descripcionProducto'];
    $categoriasProducto = $_POST['categoriasProducto'];
    $precioProducto = $_POST['precioProducto'];
    $cantidadDisponible = $_POST['cantidadDisponible'];

    $queryProd = 'INSERT INTO public."Producto" ("Nombre", "Precio") VALUES (?, ?) RETURNING "IDProducto"';

    $queryCat = 'INSERT INTO public."Categoria" ("IDProducto", "Categoria") VALUES (?, ?)';
    $queryAn = 'INSERT INTO public."Anuncio" ("Descripcion", "CantidadDisponible", "FechaPublicacion", "IDVendedor", "IDProducto")
                VALUES (?, ?, ?, ?, ?) RETURNING "IDAnuncio"';

    //Script para insertar los detalles del producto, buff devuelve el id autoincremental creado por pg
    $buff = $conn->prepare($queryProd);
    $buff->execute(array($nombreProducto, $precioProducto));
    $IDProducto = $buff->fetch()['IDProducto'];

    //Script para insertar las categorias a la tabla de categorias, separa por comas las categorias
    //entregadas y recorre cada una insertando el valor correspondiente
    $buff = $conn->prepare($queryCat);
    $cats = explode(',', $categoriasProducto);
    foreach($cats as $cat){
        $buff->execute(array($IDProducto, $cat));
    }
    
    //Script para insertar los detalles del anuncio
    $buff = $conn->prepare($queryAn);
    $buff->execute(array($descripcionProducto, $cantidadDisponible, date('Y-m-d'), $_SESSION['Rol'], $IDProducto));
    $IDAnuncio = $buff->fetch()['IDAnuncio'];

    header("location: ../product.php?post=success&IDAnuncio=".$IDAnuncio);
    exit();
}