<?php

if(!isset($_POST['submit-login'])){
    header("location: ../login.php?error=errores");
    exit();
} else{
    require_once '../conexion.php';

    $rolUsuario = $_POST['rolUsuario'];

    $passUsuario = $_POST['passUsuario'];
    $hashPassUsuario = hash("sha256", $passUsuario);

    $query = 'SELECT "Rol", "Nombre", "Contrasena" 
            FROM public."Usuario" WHERE "Rol" = ?';
    $buff = $conn->prepare($query);
    $buff->execute(array($rolUsuario));

    $res = $buff->fetch();

    if($res){
        if($hashPassUsuario == $res['Contrasena']){
            session_start();

            $_SESSION['Rol'] = $rolUsuario;
            $_SESSION['Nombre'] = $res['Nombre'];

            header("location: ../index.php?login=success");
            
        } else{
            header("location: ../login.php?error=contrasenaIncorrecta");
            exit();
        }
    } else{
        header("location: ../login.php?error=cuentaNoExistente");
        exit();
    }

}