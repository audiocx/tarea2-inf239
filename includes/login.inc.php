<?php

if(!isset($_POST['submit-login'])){
    header("location: ../login.php");
    exit();
} else{
    $rolUsuario = $_POST['rolUsuario'];
    $passUsuario = $_POST['passUsuario'];
    echo 'funca';
}