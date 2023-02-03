<?php
include("config/funciones.php");
//Comprobamos si ya se enviado el formulario
if (isset($_POST['enviar'])) {
    //guardamos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $login = $_POST['usuario'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];

    $error = "";
    //Comprobamos si algun campo vacio
    if (empty($nombre) || empty($apellidos) || empty($login) || empty($password) || empty($password2) || empty($email)) {
        $error = $error . "Debe de completar todos los campos.<br>";
    //si no hay ningun campo vacio
    } else {
        //si no existe el login
        if(!existeLogin($login)) {
            //si la validacion de la contraseña es valido
            if(validacionContraseya($password, $password) == "") {
                //si la validaicion del email es valido
                if(validar_email($email) == "") {
                    anyadirTecnicoJson($nombre, $apellidos, $login, $password, $email);
                    $anuncio = "Usuario registrado correctamente";
                    echo("<meta http-equiv='refresh' content='1;url=index.php'>");
                //si la validacion del email es incorrecta
                } else {
                    $error = validar_email($email);
                }
            //si la validacion de la contraseña es incorrecta
            } else {
                $error = validacionContraseya($password, $password2);
            }
        //si existe el usuario
        } else {
            $error = "Ya existe el nombre de usuario";
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Desarrollo Web en Entorno Servidor -->
<!-- Tema 3 : Desarrollo de aplicaciones web con PHP -->
<!-- Tarea 3, Foro: registro.php -->
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Foro DWES</title>
    <link href="css/registro.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id='registro'>
        <form action='registro.php' method='post'>
            <fieldset>
                <legend>Registro de nuevo usuario</legend>
                <div>
                    <?php
                    if (isset($error)) {
                        echo "<span class='error'>" . $error . "</span>";
                    }
                    if (isset($anuncio)) {
                        echo "<span class='anuncio'>" . $anuncio . "</span>";
                    }
                    ?>
                </div>
                <div class='campo'>
                    <label for='usuario'>Nombre:</label><br />
                    <input type='text' name='nombre' id='nombre' maxlength="50" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" /><br />
                </div>
                <div class='campo'>
                    <label for='usuario'>Apellidos:</label><br />
                    <input type='text' name='apellidos' id='apellidos' maxlength="50" value="<?php if (isset($_POST['apellidos'])) echo $_POST['apellidos']; ?>" /><br />
                </div>
                <div class='campo'>
                    <label for='usuario'>Nombre de usuario:</label><br />
                    <input type='text' name='usuario' id='usuario' maxlength="50" value="<?php if (isset($_POST['usuario']) && !existeLogin($login)) echo $_POST['usuario']; ?>"/><br />
                </div>
                <div class='campo'>
                    <label for='password'>Contraseña:</label><br />
                    <input type='password' name='password' id='password' maxlength="50" /><br />
                </div>
                <div class='campo'>
                    <label for='password'>Escriba de nuevo la Contraseña:</label><br />
                    <input type='password' name='password2' id='password2' maxlength="50" /><br />
                </div>
                <div class='campo'>
                    <label for='email'>Email:</label><br />
                    <input type='text' name='email' id='email' maxlength="50" value="<?php if (isset($_POST['email']) && (validar_email($email) == "")) echo $_POST['email']; ?>" /><br />
                </div>
                <div class='campo'>
                    <input type='submit' name='enviar' value='Enviar' />
                </div>
                <div class='campo'>
                    <input type='button' name='volver' value='Volver' onClick="location.href='index.php'" />
                </div>
        </form>
        </fieldset>
    </div>
</body>
</html>