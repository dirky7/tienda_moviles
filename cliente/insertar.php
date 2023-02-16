    
<?php
	include "../config/funciones.php";
	session_start();
	if (isset($_POST['submit'])) {
		$name=$_POST['nombre'];
		$mail=$_POST['mail'];
		$problema=$_POST['problema'];
		$tecnico=$_POST['tecnico'];		
		$fecha = date('d-m-Y');
		insertarIncidencia($name, $mail,$tecnico, $problema, $fecha);
			
		
	}
	if (isset($_POST['volver'])) {
		header('Location:index.php');
			
		
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
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" id="nombre" required><br>

		<label for="mail">Email:</label>
		<input type="text" name="mail" id="mail" required><br>

		<input type="hidden" name="tecnico" id="tecnico" value="">

		<label for="texto">Problema:</label>
		<textarea name="problema" id="problema" required></textarea><br>

		<input type="submit" name="submit" value="Guardar">
		<input type="submit" name="volver" value="Volver">
	</form>
	
	
</body>

</html>