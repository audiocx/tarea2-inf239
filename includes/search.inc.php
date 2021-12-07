<?php

if(!isset($_POST['busqueda'])){
    header("location: ../index.php?error=sinBusqueda");
    exit();
} else{
    $busqueda = $_POST['busqueda'];
    $tipo = $_POST['tipo'];
    header("location: ../search.php?tipo=".$tipo."&busqueda=".$busqueda);
}