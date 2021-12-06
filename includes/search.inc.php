<?php

if(!isset($_POST['busqueda'])){
    header("location: ../index.php?error=sinBusqueda");
    exit();
} else{
    $busqueda = $_POST['busqueda'];
    header("location: ../search.php?busqueda=".$busqueda);
}