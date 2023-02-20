<?php
include "config/funciones.php";

//si hemos pulsado el boton incio sesion
if (isset($_POST['inicioSesion'])) {
	//almacenamos el usuario y clave
	$login = $_POST['usuario'];
	$password = $_POST['password'];

	//si los campos estan vacios
	if (empty($login) || empty($password)) {
		$error = "Debes introducir un nombre de usuario y una contraseña";
	//si no estan vacios
	} else {
		//si existe el login
		if (existeLogin($login)) {
			//comprobamos las credenciales de incio de sesion
			if (comprobarInicioSesion($login, $password)) {
				//Si son correctas las credenciales iniciamos la sesion
				if(comprobarUsuarioEstaAutorizado($login)) {
					session_start();
					//Guardamos el usuario y la hora en sesiones
					$_SESSION['usuario'] = $login;
					$_SESSION['hora'] = date("H:i", time());
					//Nos redirige a la pagina de incio
					header("Location:inicio.php");
				} else {
					$error = "Usuario no autorizado. Contacte con un administrador para ser autorizado";
				}
			//si las credenciales de incio de sesion son incorrectas
			} else {
				$error = "Datos incorrectos";
			}
		//si no existe el login
		} else {
			$error = "No existe el usuario indicado";
		}
	}
}

//si hemos pulsado el boton invitado
if(isset($_POST['invitado'])) {
	//Inicamos la sesion
	session_start();
	//Guardamos la sesion de usuario como Invitado y la sesion de hora
	$_SESSION['usuario'] = "Invitado";
	$_SESSION['hora'] = date("H:i", time());
	//Nos redirige a la pagina de insertar
	header("Location:cliente/insertar.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Tienda Moviles</title>
	<link rel="stylesheet" type="text/css" href="css/inicio.css">
	<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>
<body>
	<form method="post">
		<!-- Formulario inicio sesion -->
		<div class="login-wrap">
			<div class="login-html">
				<label for="tab-1" class="tab"><a href="index.php">Inicio Sesion</a></label>
				<label for="tab-2" class="tab"><a href="registro.php">Registro</a></label>
				<div class="login-form">
					<div class="sign-in-htm">
						<div class="group">
							<label for="user" class="label">Usuario</label>
							<input id="user" name="usuario" maxlength="20" type="text" class="input">
						</div>
						<div class="group">
							<label for="pass" class="label">Contraseña</label>
							<input id="pass" type="password" name="password" maxlength="20" class="input">
						</div>
						<div class="group">
							<input id="check" type="checkbox" class="check">
							<label for="check" id="mostrar"><span class="icon"></span> Mostrar contraseña</label>
						</div>
						<div class="group">
							<input type="submit" class="button" name="inicioSesion" value="Inicar Sesion">
						</div>
						<div class="error">
							<?php
							if (isset($error)) {
								echo "<div class='error'>$error</div>";
							}
							?>
						</div>
						<div class="hr">
						</div>
						<div class="foot-lnk">
							<input type="submit" value="Entrar como invitado" name='invitado' class="invitado">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
		//evento que hacer click en mostrar contraseña ejecutara la funcion mostrar contraseña
		document.getElementById("check").addEventListener("click", mostrarContrasena);
		function mostrarContrasena(){
            //cojemos el campo de la contraseña
			var tipo = document.getElementById("pass");
	        //si mostrar contraseña esta activa
			if(document.getElementById('check').checked) {
                //cambios el campo de tipo contraseña a tipo text
				tipo.type = "text";
            //si no esta activo
			} else {
                //cambios el campo de tipo text a tipo contraseña
				tipo.type = "password";
			}
 		}
	</script>
</body>
</html>