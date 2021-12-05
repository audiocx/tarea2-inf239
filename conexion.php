<?php

class Conexion{
    function Conectar(){
        define('SERVER', 'localhost');
        define('DBNAME', 'SansApp');
        define('USER', 'postgres');
        define('PASS', '123');
        try{
            $conexion = new PDO("pgsql:host=".SERVER.";dbname=".DBNAME, USER, PASS);
            echo 'Conectado';
            return $conexion;
        } catch(Exception $error){
            die("Error: ".$error->getMessage());
        }
    }
}