<?php
include "config/funciones.php";

if (isset($_POST['inicioSesion'])) {
	//almacenamos el usuario y clave
	$login = $_POST['usuario'];
	$password = $_POST['password'];

	//si estan vacios
	if (empty($login) || empty($password)) {
		$error = "Debes introducir un nombre de usuario y una contraseña";
		//si no estan vacios
	} else {
		if (existeLogin($login)) {
			if (comprobarInicioSesion($login, $password)) {
				session_start();
				$_SESSION['usuario'] = $login;
				$_SESSION['hora'] = date("H:i", time());
				//Nos redirige a la pagina usuario
				header("Location:inicio.php");
			} else {
				$error = "Datos incorrectos";
			}
		} else {
			$error = "No existe el usuario indicado";
		}
	}
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
		<div class="login-wrap">
			<div class="login-html">
				<label for="tab-1" class="tab"><a href="index.php">Inicio Sesion</a></label>
				<label for="tab-2" class="tab"><a href="registro.php">Registro</a></label>
				<div class="login-form">
					<div class="sign-in-htm">
						<div class="group">
							<label for="user" class="label">Usuario</label>
							<input id="user" name="usuario" required maxlength="20" type="text" class="input">
						</div>
						<div class="group">
							<label for="pass" class="label">Contraseña</label>
							<input id="pass" type="password" name="password" required maxlength="20" class="input">
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
							<a href="cliente/insertar.php">Entrar como invitado</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
		document.getElementById("check").addEventListener("click", mostrarContrasena);
		function mostrarContrasena(){
			var tipo = document.getElementById("pass");
			if(document.getElementById('check').checked) {
				tipo.type = "text";
			} else{
				tipo.type = "password";
			}
 		}
	</script>
</body>

</html>