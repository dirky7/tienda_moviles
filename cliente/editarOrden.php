<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<title>Tienda Moviles</title>
	<link rel="stylesheet" type="text/css" href="css/inicio.css">
	<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/inicio.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="../css/inicio.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

	<style>
		body{
			background-color:rgb(240, 240, 240);
		}

		form {
			background-color: rgb(220, 220, 220);
			border-radius: 5px;
			box-shadow: 0 0 10px rgba(0,0,0,0.2);
			padding: 20px;
			margin: 50px auto;
			max-width: 500px;

		}

		label {
			display: block;
			font-weight: bold;
			margin-bottom: 5px;
		}

		input[type=text], textarea {
			border: 1px solid #CCC;
			border-radius: 3px;
			font-size: 16px;
			padding: 10px;
			width: 93%;
			margin-bottom: 20px;
		}

		input[type=submit] {
			background-color: rgb(250, 0, 0);
			border: none;
			border-radius: 3px;
			color: #FFFFFF;
			font-size: 16px;
			padding: 10px;
			width: 100%;
		}

		input[type=submit]:hover {
			background-color: #cc0000;
		}

		input[type=submit]:focus {
			outline: none;
		}

		textarea {
			height: 150px;
		}


	</style>
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

                </ul>

            </div>
        </div>
    </nav>
	<nav>
            <ul class="menu">

            </ul>
        </nav>ºz
<?php
include('../config/funciones.php');
session_start();
comprobarSiEstaLogeado();

$id = $_GET['id'];
    if (isset($_POST['submit'])) {
        $precio=$_POST['precio'];
        $observaciones=$_POST['observaciones'];

        $fecha2 = date('d/m/Y');

        actualizarIncidencia($id,$precio,$observaciones,$fecha2);


    }
    if (isset($_POST['volver'])) {
		header('Location:gestion.php');


	}
?>


	<?php
	// Obtener el ID del registro a modificar
	$id = $_GET['id'];

	// Obtener los datos del registro desde el archivo JSON
	$data = file_get_contents('incidencias.json');
	$data = json_decode($data, true);
	$saveData = $data[$id];
	?>

	<form method="post">

        <label for="nombre">Nombre:</label>
		<input type="text" name="nombre" id="nombre" value="<?php echo $saveData['nombre']; ?>" readonly><br><br>


		<label for="mail">Email:</label>
		<input type="text" name="mail" id="mail" value="<?php echo $saveData['email']; ?>"readonly><br><br>


		<label for="texto">Problema:</label>
		<textarea name="problema" id="problema" value="<?php echo $saveData['problema']; ?>"readonly></textarea><br><br>

		<label for="precio">Precio:</label>
		<input type="number" name="precio" id="precio"value="<?php echo $saveData['precio']; ?>"requierd><br><br>



        <label for="resumenprecio">Observaciones:</label>
		<textarea name="resumenprecio" id="resumenprecio" value=""></textarea><br><br>

		<label for="fecha">Fecha Inicio:</label>
		<input type="text" name="fecha" id="fecha" value="<?php echo $saveData['fecha']; ?>"><br><br>
        <label for="fecha2">Fecha Modificaciones:</label>
		<input type="text" name="fecha2" id="fecha2" value="<?php echo $saveData['fechaActu']; ?>"><br><br>

		<input type="submit" name="submit" value="Actualizar">
        <input type="submit" name="volver" value="Volver">

	</form>
</body>
</html>