<?php
include("config/funciones.php");

session_start();
comprobarSiEsAdministrador();

if (isset($_GET['login']))
{
    borrarUsuario($_GET['login']);
    header("Location:usuarios.php");
}

if (isset($_GET['estado'])) {
    actualizarEstadoUsuarioAutorizado($_GET['estado']);
    header("Location:usuarios.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gestion de Usuarios</title>
	<link rel="stylesheet" href="../css/inicio.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
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
                        <a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cliente/insertar.php">Insertar Incidencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cliente/gestion.php">Gestionar Incidencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Gestionar Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logoff.php">Salir</a>
                    </li>
                </ul>
                <div class="d-flex flex-column sim">
                    <span>Bienvenido <?php echo $_SESSION['usuario']; ?></span>
                    <span>Hora de conexión: <?php echo $_SESSION['hora']; ?></span>
                </div>
            </div>
        </div>
    </nav>
	<main>
		<aside>
			<?php
				echo mostrarUsuarios();
			?>
		</aside>
	</main>
</body>
</html>