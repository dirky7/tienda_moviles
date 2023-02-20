<?php
include("config/funciones.php");

//Inicamos la sesion
session_start();
//comprobamos si estamos logeado
comprobarSiEstaLogeado();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inicio.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <title>Inicio</title>
    <style>

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-red navbar-dark">
        <div class="wrapper"></div>
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
                    <?php
                    if($_SESSION['usuario'] == "admin")
                    {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Gestionar Usuarios</a>
                    </li>
                    <?php
                    }
                    ?>
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
        <ul class="card-wrapper">
            <?php
                if ($_SESSION['usuario'] != "")
				{
					//usuario: admin
					//password: Adminjdm1
					if ($_SESSION['usuario'] == "admin")
					{
						echo "
						<li class='card reparacion'>
                        <div class='rep'>
							<a href='cliente/gestion.php'>
							    <input type='button' value='Gestionar Incidencia'>
							</a>
                        </div>
						</li>
						<li class='card usuarios'>
                        <div class='rep'>
                            <a href='usuarios.php'>
							    <input type='button' value='Gestionar Usuarios'>
							</a>
                        </div>
						</li>";
					}
					else
					{
						echo "
						<li class='card gesti'>
                            <div class='gestion'>
							    <input type='button' class='boton' value='Gestionar Incidencia'>
                            </div>
							</a>
						</li>
						";
					}
				}
			?>
        </ul>
    </main>
</body>
</html>