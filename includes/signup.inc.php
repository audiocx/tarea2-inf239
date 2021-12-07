<?php
include_once '../conexion.php';


if(!isset($_POST['submit-signup'])){
    header("location: ../signup.php");
    exit();
} else{
    $rolUsuario = $_POST['rolUsuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $correoUsuario = $_POST['correoUsuario'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $passUsuario = $_POST['passUsuario'];
    $passUsuarioRep = $_POST['passUsuarioRep'];

    $hashedPass = hash("sha256", $passUsuario);

    if(!true){
        header("location: ../signup.php?error=errores");
        exit();
    } else{
        $query = 
            'INSERT INTO public."Usuario"(
            "Rol", "Nombre", "Correo", "FechaNacimiento", "Contrasena")
            VALUES (?, ?, ?, ?, ?)';
        $res = $conn->prepare($query);
        $res->execute(array($rolUsuario, $nombreUsuario, $correoUsuario, $fechaNacimiento, $hashedPass));
        
        header("location: ../index.php?login=success");
    }
}