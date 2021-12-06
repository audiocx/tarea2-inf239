<?php

include 'conexion.php';

if(!isset($_GET['submit-search'])){
    header("location: index.php");
    exit();
} else{
    echo $_GET['busqueda'];
}