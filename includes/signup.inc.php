<?php

if(!isset($_POST['submit-signup'])){
    header("location: ../signup.php");
    exit();
} else{

    $rolUsuario = $_POST['rolUsuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $correoUsuario = $_POST['correoUsuario'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $rolUsuario = $_POST['passUsuario'];
    $rolUsuario = $_POST['passUsuarioRep'];
    
}