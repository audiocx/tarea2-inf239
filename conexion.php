<?php

define('SERVER', 'localhost');
define('DBNAME', 'SansApp');
define('USER', 'postgres');
define('PASS', '123');


try{
    $conn = new PDO("pgsql:host=".SERVER.";dbname=".DBNAME, USER, PASS);
    echo "Conectado<br>";
} catch(Exception $e){
    die("Error: ".$e->getMessage());
}