<?php

include('conexion.php');

$obj = new Conexion();
$conex = $obj->Conectar();

$query = 'INSERT INTO public.test VALUES (?,?)';

$nombre = 'maldita';
$apellido = 'sea';

$res = $conex->prepare($query);

$res->execute(array($nombre, $apellido));