<?php
include("../config/funciones.php");

//Inciamos la sesion
session_start();
//Comprobamos si esta logeado el usuario
comprobarSiEstaLogeado();

//Si existe el id
if(isset($_GET['id'])) {
    //añadimos el tecnico a la incidencia
    anyadirTecnicoIncidencia($_GET['id']);
    header("Location:gestion.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gestionar Incidencias</title>
	<link rel="stylesheet" href="../css/inicio.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
                        <a class="nav-link active" aria-current="page" href="../inicio.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="insertar.php">Insertar Incidencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion.php">Gestionar Incidencia</a>
                    </li>
                    <?php
                    if($_SESSION['usuario'] == "admin")
                    {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../usuarios.php">Gestionar Usuarios</a>
                    </li>
                    <?php
                    }
                    ?>
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
	<main>
        <nav>
            <ul class="menu">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                <form action="" method="post">
                    <li><input type="submit" value="Incidencias" name="incidencias"></li>
                </form>
                <form action="" method="post">
                    <li><input type="submit" value="Incidencias Resueltas" name="incidencias_resueltas"></li>
                </form>
                <form action="" method="post">
                    <li><input type="submit" value="Mis Incidencias Resueltas" name="mis_incidencias_resueltas"></li>
                </form>
            </ul>
        </nav>
		<aside>
            <?php
            //si existe fin
            if(isset($_GET['fin'])) {
                //comprobamos que no haya datos vacio
                if(comprobarNoHayDatosVacios($_GET['fin'])) {
                    //actualizamos la incidencia
                    actualizarIncidenciaResuelta($_GET['fin']);
                    //movemos la incidencia
                    moverIncidenciasResueltas($_GET['fin']);
                //si hay datos vacios
                } else {
                    echo "<p class='error'>Debes actualizar el precio y las observaciones</p>";
                }
            }

            //si pinchamos en incidencias
            if(isset($_POST['incidencias'])) {
                //mostramos las incidencias
                echo mostrarIncidencias();
            //si pinchamos en incidencias resueltas
            } elseif(isset($_POST['incidencias_resueltas'])) {
                //mostramos las incidencias resueltas
                echo mostrarIncidenciasResueltas();
            //si pinchamos en mis incidencias resueltas
            } elseif(isset($_POST['mis_incidencias_resueltas'])) {
                //mostramos las incidencias del usuario logeado
                echo mostrarIncidenciasResueltasUsuario();
            } else {
                //mostramos las incidencias
                echo mostrarIncidencias();
            }
            ?>
		</aside>
	</main>
</body>
</html>