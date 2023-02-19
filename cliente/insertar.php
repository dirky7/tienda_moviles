<?php
include "../config/funciones.php";
session_start();

comprobarSiEstaLogeado(true);

$mensaje = "";
if (isset($_POST['submit'])) {
	
	$name = $_POST['nombre'];
	$mail = $_POST['mail'];
	$problema = $_POST['problema'];
	$tecnico = $_POST['tecnico'];
	$fecha = date("d-m-Y h:i");

	$tecnico = $_POST['tecnico'];
	
	if (empty($name) || empty($mail) || empty($problema)) {
		$mensaje = '<div style="background-color:#ffb3b3;padding:10px;border-radius:3px; ">Por favor completa los campos</div>';
	} else {
		if (validar_email($mail) == "") {
			$fecha = date('d/m/Y');
			insertarIncidencia($name, $mail, $tecnico, $problema, $fecha);
			$mensaje = '<div style="text-align:center;padding:10px;border-radius:3px;margin-top:15px; ">La incidencia se ha guardado exitosamente</div>';
		}else{
			$mensaje=validar_email($mail);
		}
		
	}
}

if (isset($_POST['volver'])) {
	header('Location:../logoff.php');
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Tienda Moviles</title>
	
	<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/inicio.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/inicio.css">
	
		
</head>

<body>
	<?php
	if ($_SESSION['usuario'] == "Invitado") {
	?>
		<nav class="navbar navbar-expand-lg navbar-red navbar-dark">
		<div class="wrapper">
		</div>
		<div class="container-fluid all-show">
			<a class="navbar-brand" href="inicio.php">Tienda Reparación Móviles <i class="fa fa-codepen"></i></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="insertar.php">Insertar Incidencia</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="../logoff.php">Salir</a>
					</li>
				</ul>
				<div class="d-flex flex-column sim">
					<span>Bienvenido <?php echo $_SESSION['usuario']; ?></span>
					<span>Hora de conexión: <?php echo $_SESSION['hora']; ?></span>
				</div>
			</div>
		</div>
	</nav>
	<?php
	} else {
	?>
		<nav class="navbar navbar-expand-lg navbar-red navbar-dark">
			<div class="wrapper">
			</div>
			<div class="container-fluid all-show">
				<a class="navbar-brand" href="inicio.php">Tienda Reparación Móviles <i class="fa fa-codepen"></i></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="../inicio.php">Inicio</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="insertar.php">Insertar Incidencia</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="gestion.php">Gestionar Incidencia</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">contacto</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../logoff.php">Salir</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#"><i class="fa fa-search"></i></a>
						</li>
					</ul>
					<div class="d-flex flex-column sim">
						<span>Bienvenido <?php echo $_SESSION['usuario']; ?></span>
						<span>Hora de conexión: <?php echo $_SESSION['hora']; ?></span>
					</div>
				</div>
			</div>
		</nav>
	<?php
	}
	?>
	<div class="formu">
	<form method="post" >
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" id="nombre"><br>

		<label for="mail">Email:</label>
		<input type="text" name="mail" id="mail"><br>

		<input type="hidden" name="tecnico" id="tecnico" value="">

		<label for="problema">Problema:</label>
		<textarea name="problema" id="problema"></textarea><br>

		<input type="submit" name="submit" value="Guardar">
		<input type="submit" name="volver" value="Volver">

		<div>
			<?php
			echo $mensaje;
			?>
		</div>
	</form>
	</div>
	
</body>
</html>