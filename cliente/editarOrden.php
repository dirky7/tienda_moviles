<?php
include('../config/funciones.php');

//Inciamos la sesion
session_start();
//Comprobamos si esta logeado el usuario
comprobarSiEstaLogeado();

//obtenemos el id
$id = $_GET['id'];
//si hemos pinchado en submit
if (isset($_POST['submit'])) {
    //obtenos el precio
    $precio = $_POST['precio'];
    //obtenemos las observaciones
    $observaciones = $_POST['observaciones'];

    //actualizamos la incidencia
    actualizarIncidencia($id, $precio, $observaciones);
    header('Location:gestion.php');
}

//si pinchamos en volver
if (isset($_POST['volver'])) {
    //Nos redirige a gestion
    header('Location:gestion.php');
}

// Obtener los datos del registro desde el archivo JSON
$datos = obtenerDatosJson('incidencias.json');
foreach ($datos as $valor) {
    if ($valor['id'] == $id) {
        $nombre = $valor['nombre'];
        $email = $valor['email'];
        $problema = $valor['problema'];
        $precio = $valor['precio'];
        $fecha = $valor['fecha'];
        $observaciones = $valor['observaciones'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <title>Editar Incidencia</title>
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

    <div class="formu">
        <form method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" readonly><br><br>

            <label for="mail">Email:</label>
            <input type="text" name="mail" id="mail" value="<?php echo $email; ?>" readonly><br><br>

            <label for="problema">Problema:</label>
            <textarea name="problema" id="problema" readonly><?php echo $problema; ?></textarea><br><br>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" value="<?php echo $precio; ?>"><br><br>

            <label for="observaciones">Observaciones:</label>
            <textarea name="observaciones" id="observaciones"><?php echo $observaciones; ?></textarea><br><br>

            <label for="fecha">Fecha Inicio:</label>
            <input type="text" name="fecha" id="fecha" value="<?php echo $fecha; ?>" readonly><br><br>

            <input type="submit" name="submit" value="Actualizar">
            <input type="submit" name="volver" value="Volver">
        </form>
    </div>
</body>
</html>