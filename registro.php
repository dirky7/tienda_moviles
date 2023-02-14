<?php
include("config/funciones.php");
//Comprobamos si ya se enviado el formulario
if (isset($_POST['registro'])) {
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
        if (!existeLogin($login)) {
            //si la validacion de la contraseña es valido
            if (validacionContraseya($password, $password2) == "") {
                //si la validaicion del email es valido
                if (validar_email($email) == "") {
                    anyadirTecnicoJson($nombre, $apellidos, $login, $password, $email);
                    $anuncio = "Usuario registrado correctamente";
                    header("Location:index.php");
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
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Foro DWES</title>
    <link href="css/inicio.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>
<body>
    <form method="post">
        <div class="login-wrap">
            <div class="login-html">
                <label for="tab-1" class="tab"><a href="index.php">Inicio Sesion</a></label>
                <label for="tab-2" class="tab"><a href="registro.php">Registro</a></label>
                <!-- Formulario de registro -->
                <div class="login-form">
                    <div class="sign-up-htm">
                        <div class="group">
                            <label for="user" class="label">Nombre</label>
                            <input id="user" type="text" name="nombre" class="input" maxlength="50" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required>
                        </div>
                        <div class="group">
                            <label for="apell" class="label">Apellidos</label>
                            <input class="input" id="apell" type="text" name='apellidos' id='apellidos' maxlength="50" value="<?php if (isset($_POST['apellidos'])) echo $_POST['apellidos']; ?>" required>
                        </div>
                        <div class="group">
                            <label for="usu" class="label">Nombre de usuario</label>
                            <input class="input" type='text' name='usuario' id='usuario' maxlength="50" value="<?php if (isset($_POST['usuario']) && !existeLogin($login)) echo $_POST['usuario']; ?>" required>
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Contraseña</label>
                            <input id="pass" type="password" class="input" data-type="password" name="password" maxlength="50" required>
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Repite la contraseña</label>
                            <input id="pass" type="password" class="input" data-type="password" name="password2" maxlength="50" required>
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Email</label>
                            <input id="pass" type="text" class="input" name="email" maxlength="50" value="<?php if (isset($_POST['email']) && (validar_email($email) == "")) echo $_POST['email']; ?>" required>
                        </div>
                        <div class="group">
                            <input type="submit" class="button" name="registro" value="Crear cuenta">
                        </div>
                        <div class="error">
							<?php
							if (isset($error)) {
								echo "<div class='error'>$error</div>";
							}
							?>
						</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</body>
</html>