<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <b><a href="index.php">Página principal</a></b>
    <br>
    <br>
    <form action="includes/signup.inc.php" method="POST">
        <b>Crear cuenta</b><br>
        ROL Usuario (sin puntos con guión)<br>
        <input type="text" name="rolUsuario" placeholder="ej: 201873060-2"><br>
        Nombre<br>
        <input type="text" name="nombreUsuario" placeholder="ej: El bromas"><br>
        Correo<br>
        <input type="text" name="correoUsuario" placeholder="ej: qwerty@hotmail.com"><br>
        Fecha de Nacimiento<br>
        <input type="text" name="fechaNacimiento" placeholder="DD/MM/AA"><br>
        Contraseña<br>
        <input type="password" name="passUsuario" placeholder="**********"><br>
        Repita contraseña<br>
        <input type="password" name="passUsuarioRep" placeholder="**********"><br>

        <button type="submit" name="submit-signup">Registrarse</button>
    </form>
    ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
</body>
</html>