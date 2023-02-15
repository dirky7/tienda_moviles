<?php
include("config/funciones.php");

session_start();
comprobarSiEstaLogeado();




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/inicio.css">
    <title>Document</title>
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
                        <a class="nav-link" href="#">Gestionar Incidencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logoff.php">Salir</a>
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

    <main>
        <ul class="card-wrapper">
            <?php
			
				if ($_SESSION['usuario'] == "")
				{
					echo "
					<li class='card'>
						<img src='https://images.unsplash.com/photo-1611916656173-875e4277bea6?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MXwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHw&ixlib=rb-1.2.1&q=80&w=400' alt=''>
						<a href='cliente/insertar.php'>
							<input type='button' value='Insertar Incidencia'>
						</a>
					</li>
					";
				}
				else
				{
					//usuario: admin
					//password: Adminjdm1
					if ($_SESSION['usuario'] == "admin")
					{
						echo "
						<li class='card'>
							<img src='https://images.unsplash.com/photo-1611083360739-bdad6e0eb1fa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MXwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHw&ixlib=rb-1.2.1&q=80&w=400' alt=''>
							<a href='cliente/gestion.php'>
								<input type='button' value='Gestionar Incidencia'>
							</a>
						</li>
						<li class='card'>
							<img src='https://images.unsplash.com/photo-1613230485186-2e7e0fca1253?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MXwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHw&ixlib=rb-1.2.1&q=80&w=400' alt=''>
							<a href=''>
								<input type='button' value='Gestionar Usuarios'>
							</a>
						</li>";
					}
					else
					{
						echo "
						<li class='card'>
							<img src='https://images.unsplash.com/photo-1611083360739-bdad6e0eb1fa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MXwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHw&ixlib=rb-1.2.1&q=80&w=400' alt=''>
							<a href='cliente/gestion.php'>
								<input type='button' value='Gestionar Incidencia'>
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