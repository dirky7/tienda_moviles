<?php
// Obtener el ID del registro a eliminar
$id = $_GET['id'];

// Leer los datos existentes del archivo JSON
$data = file_get_contents('incidencias.json');
$data = json_decode($data, true);

// Recorrer el array y buscar el registro con el ID que deseas eliminar
unset($data[$id]);


$data = json_encode($data);
file_put_contents('../incidencias.json', $data);

// Redireccionar de vuelta a la página de inicio
header('Location: gestion.php');
?>