
<?php
	include "../config/funciones.php";
	session_start();
	if (isset($_POST['submit'])) {
		$name=$_POST['nombre'];
		$mail=$_POST['mail'];
		$problema=$_POST['problema'];
		$tecnico=$_POST['tecnico'];
		$fecha = date("d-m-Y h:i");
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
	<link rel="stylesheet" href="../css/inicio.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
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
                    <span>1 item added to your quote</span>
                    <small class="text-primary">view your quote</small>
                </div>
            </div>
        </div>
    </nav>
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