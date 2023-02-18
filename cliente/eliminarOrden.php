<?php
include('../config/funciones.php');
session_start();
comprobarSiEstaLogeado();

borrarIncidencia($_GET['id']);
// Redireccionar de vuelta a la página de inicio
header('Location: gestion.php');
?>