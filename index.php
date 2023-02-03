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
		if(existeLogin($login)) {
			if(comprobarInicioSesion($login, $password)) {
				session_start();
                $_SESSION['usuario']=$login;
                $_SESSION['hora']=date("H:i",time());
                //Nos redirige a la pagina usuario
                header("Location:gestion.php");
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
	<title>Contabilidad Personal</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body id="pagina-login">
	<header>
		<h1>Gastos Personales</h1>
	</header>
	<nav>Contabilidad personal</nav>
	<main>
		<fieldset class="mini-formulario">
			<legend>Iniciar Sesión</legend>
			<?php
			if (isset($error)) {
				echo "<div class='error'>$error</div>";
			}
			?>
			<form method="post">
				<div class="input-labeled">
					<label>Usuario:</label>
					<input type="text" name="usuario" required maxlength="10">
				</div>
				<div class="input-labeled">
					<label>Contraseña:</label>
					<input type="password" name="password" required maxlength="20">
				</div>
				<input type="submit" name="inicioSesion" value="Iniciar sesion">
				<hr>
				<a href='registro.php'>Registrarse</a>
				<a href='invitado.php'>Entrar como invitado</a>
				<input type="hidden" name="sesion">
			</form>
		</fieldset>
	</main>
</body>
</html>