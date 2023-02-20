<?php
include('../config/funciones.php');
//Inciamos la sesion
session_start();
//Comprobamos si esta logeado el usuario
comprobarSiEstaLogeado();

//borramos la incidencia
borrarIncidencia($_GET['id']);
// Redireccionar de vuelta a la página de inicio
header('Location: gestion.php');
?>