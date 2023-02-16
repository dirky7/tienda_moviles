<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
    if (isset($_POST['submit'])) {
        $precio=$_POST['precio'];	
        $observaciones=$_POST['observaciones'];	
       	
        $fecha2 = date('d-m-Y');
        
        actualizarIncidencia();
        
        header('Location:gestion.php');
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
		<input type="text" name="mail" id="mail" value="<?php echo $saveData['mail']; ?>"readonly><br><br>


		<label for="texto">Problema:</label>
		<textarea name="problema" id="problema" value="<?php echo $saveData['problema']; ?>"readonly></textarea><br><br>		
		

		<label for="fecha">Fecha Inicio:</label>
		<input type="date" name="fecha" id="fecha" value="<?php echo $saveData['fecha']; ?>"><br><br>
        <label for="fecha2">Fecha Modificaciones:</label>
		<input type="date" name="fecha2" id="fecha2" value="<?php echo $saveData['fechaActu']; ?>"><br><br>

        <label for="observaciones">Observaciones:</label>
		<textarea name="observaciones" id="observaciones" value="<?php echo $saveData['observaciones']; ?>"required></textarea><br><br>	

        <label for="precio">Precio:</label>
		<input type="number" name="precio" id="precio"value="<?php echo $saveData['precio']; ?>"requierd><br><br>

		<label for="resuelto">¿Resuelto?</label>
		<input type="checkbox" name="resuelto" id="resuelto" <?php if ($saveData['resuelto']) echo "checked"; ?>><br><br>

		<input type="submit" name="submit" value="Actualizar">
        <input type="submit" name="volver" value="Volver">
        
	</form>

</body>
</html>