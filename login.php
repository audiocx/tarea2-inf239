<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <b><a href="index.php">Página principal</a></b>
    <br>
    <br>
    <form action="includes/login.inc.php" method="POST">
        <b>Iniciar Sesión</b><br>
        ROL Usuario (sin puntos con guión)<br>
        <input type="text" name="rolUsuario" placeholder="ej: 201873060-2"><br>
        Contraseña<br>
        <input type="password" name="passUsuario" placeholder="**********"><br>
        <button type="submit" name="submit-login">Iniciar Sesión</button>
    </form>
    ¿No tienes cuenta? <a href="signup.php">Regístrate</a><br>
    <?php if(isset($_GET['error'])){
            if($_GET['error'] == 'cuentaNoExistente') echo '<b>¡Cuenta no existente!</b>';
            else if($_GET['error'] == 'contrasenaIncorrecta') echo "<b>¡Contraseña incorrecta!</b>";
    }?>
</body>
</html>