<?php
//Iniciamos la sesion
session_start();
//Destruimos la sesion o las sesiones
session_destroy();
//Nos redirige al index
header("Location:index.php");
?>