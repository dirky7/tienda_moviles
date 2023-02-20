<?php
//Funcion que le pasamos un fichero y nos lo devuelve en un array
function obtenerDatosJson($ruta)
{
	if(file_exists($ruta))
	{
		$datos_fichero = file_get_contents($ruta);
		$json_datos = json_decode($datos_fichero, true);
		//Devolvemos el contenido del fichero
		return $json_datos;
	}
}

//Funcion para comprobar si existe el usuario
function existeLogin($login)
{
	//obtenemos los datos de los tecnicos
	$datos_tecnicos =  obtenerDatosJson("datos_tecnicos.json");
	if (count($datos_tecnicos) != 0) {
		foreach ($datos_tecnicos as $tecnicos) {
			//si el login es igual login pasado por parametro
			if ($tecnicos['login'] == $login) {
				return true;
			}
		}
		return false;
	}
}

//Metodo para validar la contraseña
function validacionContraseya($password, $password2)
{
	$error = "";
	//si las contraseñas son iguales
	if (strcmp($password, $password2) == 0) {
		//si la contraseña tiene menos de 6 caracteres
		if (strlen($password) < 6) {
			$error = "La contraseña debe tener al menos 6 caracteres";
		}
		//si la contraseña no tiene minuscula
		if (!preg_match('`[a-z]`', $password)) {
			$error = "La contraseña debe tener al menos 1 minuscula";
		}
		//si la contraseeña no tiene mayuscula
		if (!preg_match('`[A-Z]`', $password)) {
			$error = "La contraseña debe tener al menos 1 mayuscula";
		}
		//si la contraseña no tiene un numero
		if (!preg_match('`[0-9]`', $password)) {
			$error = "La contraseña debe tener al menos un numero";
		}
	//si las contraseñas no son iguales
	} else {
		$error = "Las contraseñas deben ser iguales";
	}
	return $error;
}

//Funcion para validar el email
function validar_email($email)
{
	$error = "";
	//si el email no cumple esta expresion regular
	if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
		$error = "El email no es valido";
	}
	return $error;
}

//Funcion para obtener la contraseña del usuario
function obtenerPassword($login)
{
	$datos_tecnicos =  obtenerDatosJson("datos_tecnicos.json");
	foreach ($datos_tecnicos as $clave => $valor) {
		//si el login es igual login pasado por parametro
		if ($valor['login'] == $login) {
			//devolvemos la contraseña
			return ($valor['password']);
		}
	}
}

//Funcion para comprobar las credenciales de incio de sesion de un usuario
function comprobarInicioSesion($login, $password)
{
	//obtenemos la contraseña del usuario
	$password_json = obtenerPassword($login);
	//si la contraseña obtenida corresponde con la contraseña pasado por parametro
	if (password_verify($password, $password_json)) {
		return true;
	} else {
		return false;
	}
}

//Funcion para anyadir un tecnico al fichero json datos_tecnicos
function anyadirTecnicoJson($nombre, $apellidos, $login, $password, $email)
{
	$data = file_get_contents('datos_tecnicos.json');
	$data = json_decode($data, true);
	//Array donde asignamos a cada clave un valor
	$add_arr = array(
		'nombre' => $nombre,
		'apellidos' => $apellidos,
		'login' => $login,
		'password' => crypt($password, "XC"),
		'email' => $email,
		'autorizado' => 'No'
	);
	$data[] = $add_arr;
	$data = json_encode($data, JSON_PRETTY_PRINT);
	//pasamos los datos del array al archivo
	file_put_contents('datos_tecnicos.json', $data);
}

//Funcion para darle permisos de autorizacion a un tecnico
function autorizarTecnico($login)
{
	//obtenemos los datos de los tecnicos
	$tecnicos = obtenerDatosJson("datos_tecnicos.json");
	foreach ($tecnicos as $tecnico) {
		//si el login del tecnico es igual al login pasado por parametro y no este autorizado
		if ($tecnico['login'] == $login && $tecnico['autorizado'] == "no") {
			return (true);
		}
		return (false);
	}
}

//Funcion para comprobar si el usuario tiene una incidencia asignada
function comprobarUsuarioTieneIncidencia($login)
{
	//obtenemos los datos de las incidencias
	$incidencias =  obtenerDatosJson("incidencias.json");
	foreach ($incidencias as $incidencia) {
		//si el tecnico de las incidencias corresponde con el login pasado por parametro y la incidencia no esta resuelta
		if ($incidencia['tecnico'] == $login && $incidencia['resuelto'] == "No") {
			return true;
		}
	}
	return false;
}

//Funcion para mostrar los usuarios
function mostrarUsuarios()
{
	//obtenemos los datos de los usuarios
	$tecnicos =  obtenerDatosJson("datos_tecnicos.json");
	//si hay tecnicos
	if (count($tecnicos) > 0) {
		$tabla = "
						<div class='table-responsive'>
							<table  class='table table-dark table-hover'>
								<tr>
									<th>Nombre</th>
									<th>Apellidos</th>
									<th>Login</th>
									<th>Email</th>
									<th>Autorización</th>
									<th>Cambiar estado</th>
									<th>Borrar</th>
								</tr>";
		foreach ($tecnicos as $tecnico) {
			$tabla .= "
								<tr>
									<td>" . $tecnico['nombre'] . "</td>
									<td>" . $tecnico['apellidos'] . "</td>
									<td>" . $tecnico['login'] . "</td>
									<td>" . $tecnico['email'] . "</td>
									<td>" . $tecnico['autorizado'] . "</td>";
									if($tecnico['autorizado'] == "Si") {
										$tabla.= "<td>
											<a href='usuarios.php?estado=$tecnico[login]'>
												<input type='image' src='../img/intimidad.png'/>
											</a>
									</td>";
									} else {
										$tabla.= "<td>
										<a href='usuarios.php?estado=$tecnico[login]'>
											<input type='image' src='../img/permiso.png'/>
										</a>
									</td>";
									}
									$tabla.="<td class='FinEdiBorr'>
										<a href='usuarios.php?login=$tecnico[login]'>
											<input type='image' src='../img/borrar-usuario.png'/>
										</a>
									</td>
								</tr>";
		}
		$tabla .= "
							</table>
						</div>";
		return $tabla;
	} else {
		echo "<p>No hay usuarios disponibles</p>";
	}
}

//Funciones para mostrar las incidencias
function mostrarIncidencias()
{
	//obtenemos los datos de las incidencias
	$incidencias =  obtenerDatosJson("incidencias.json");
	//si hay incidencias
	if (count($incidencias) > 0) {
		//si el usuario con el que hemos inciado sesion tiene incidencias
		if (comprobarUsuarioTieneIncidencia($_SESSION['usuario'])) {
			$tabla = "
						<div class='table-responsive'>
							<table class='table table-dark table-hover'>
								<tr>
									<th>Nombre</th>
									<th>Email</th>
									<th>Problema del móvil</th>
									<th>Técnico</th>
									<th>Fecha Ingreso</th>
									<th>Precio</th>
									<th>Observaciones</th>
									<th>Resuelto</th>
									<th></th>
									<th></th>
									<th></th>
								</tr>";
			foreach ($incidencias as $incidencia) {
				//si el tecnico de la incidencia es el usuario de incio de sesion
				if ($incidencia['tecnico'] == $_SESSION['usuario']) {
					$tabla .= "
								<tr>
									<td>" . $incidencia['nombre'] . "</td>
									<td>" . $incidencia['email'] . "</td>
									<td>" . $incidencia['problema'] . "</td>
									<td>" . $incidencia['tecnico'] . "</td>
									<td>" . $incidencia['fecha'] . "</td>
									<td>" . $incidencia['precio'] . "</td>
									<td>" . $incidencia['observaciones'] . "</td>
									<td>" . $incidencia['resuelto'] . "</td>
									<td class='FinEdiBorr'>
										<a href='gestion.php?fin=$incidencia[id]'>
										<input type='image' src='../img/tarea-completada.png' name='finalizar'/>
										</a>
									</td>
									<td class='FinEdiBorr'>
										<a href='editarOrden.php?id=$incidencia[id]'>
											<input type='image' src='../img/lapiz.png' name='editar'/>
										</a>
									</td>
									<td class='FinEdiBorr'>
										<a href='eliminarOrden.php?id=$incidencia[id]'>
											<input type='image' src='../img/borrar.png' name='borrar'/>
										</a>
									</td>
								</tr>";
				}
			}
			$tabla .= "</table></div>";
			return $tabla;
		//si el usuario con el que hemos inciado sesion no tiene incidencias
		} else {
			$tabla = "
						<div class='table-responsive'>
							<table class='table table-dark table-hover '>
								<tr>
									<th>Nombre</th>
									<th>Email</th>
									<th>Problema del móvil</th>
									<th>Técnico</th>
									<th>Fecha</th>
									<th>Resuelto</th>
								</tr>";
			foreach ($incidencias as $incidencia) {
				if ($incidencia['tecnico'] == "") {
				$tabla .= "
								<tr>
									<td>" . $incidencia['nombre'] . "</td>
									<td>" . $incidencia['email'] . "</td>
									<td>" . $incidencia['problema'] . "</td>
									<td>" . $incidencia['tecnico'] . "</td>
									<td>" . $incidencia['fecha'] . "</td>
									<td>" . $incidencia['resuelto'] . "</td>
									<td>
										<a href='gestion.php?id=$incidencia[id]'>
											<input class='aceptar' type='image' src='../img/aceptar.png' name='aceptar'/>
										</a>
									</td>
								</tr>";
				}
			}
			$tabla .= "</table></div>";
			return $tabla;
		}
	//si no hay incidencias
	} else {
		return "<p>No hay incidencias para mostrar</p>";
	}
}

//Funcion para comprobar si el usuario esta logeado
function comprobarSiEstaLogeado($invitado = false)
{
	//si la variable invitado es igual a true
	if ($invitado) {
		//si no existe la sesion de usuario
		if (!isset($_SESSION['usuario'])) {
			die("Error debes <a href='../index.php'>identificarse</a> o entrar como <a href='../index.php'>Invitado</a>");
		}
	//si la variable invitado es true
	} else {
		//si no existe la sesion usuario o la sesion de  usuario es igual a invitado
		if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "Invitado") {
			die("Error debes <a href='../index.php'>identificarse</a>");
		}
	}
}

function comprobarSiEsAdministrador() {
	if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != "admin") {
		die("Error debes <a href='../index.php'>identificarse</a> como administrador");
	}
}

//Funcion para asignar una incidencia a un tecnico
function anyadirTecnicoIncidencia($id)
{
	//obtenemos los datos de las incidencias
	$incidencias = obtenerDatosJson("incidencias.json");
	foreach ($incidencias as $clave => $valor) {
		//si el id de la incidencia es igual al id pasado por parametro
		if ($valor['id'] == $id) {
			//sobreescribimos el tecnico asignadonde la sesion de usuario
			$incidencias[$clave]['tecnico'] = $_SESSION['usuario'];
		}
	}
	$data = json_encode($incidencias, JSON_PRETTY_PRINT);
	//sobreescribimos el fichero
	file_put_contents('incidencias.json', $data);
}

//Funcion para comprobar si no hay datos vacios en la incidencia
function comprobarNoHayDatosVacios($id)
{
	//obtenemos las incidencias
	$incidencias = obtenerDatosJson("incidencias.json");
	foreach ($incidencias as $clave => $valor) {
		//si el id de la incidencia es igual al id pasado por parametro
		if ($valor['id'] == $id) {
			//si el precio es mayor a 0 y las observaciones es diferentes a vacio
			if ($valor['precio'] > 0 && $valor['observaciones'] != "") {
				return true;
			}
		}
	}
	return false;
}

//Funcion para actualizar las incidencias resuelta
function actualizarIncidenciaResuelta($id)
{
	//obtenemos las incidencias
	$incidencias = obtenerDatosJson("incidencias.json");
	foreach ($incidencias as $clave => $valor) {
		//si el id de la incidencia es igual al id pasado por parametro
		if ($valor['id'] == $id) {
			//sobreescribimos la fecha actual asignadonde la fecha actual
			$incidencias[$clave]['fechaActu'] = date("d-m-Y h:i");
			//sobreescribimos resuelto asignadonde Si
			$incidencias[$clave]['resuelto'] = "Si";
		}
	}
	$data = json_encode($incidencias, JSON_PRETTY_PRINT);
	//sobreescribimos el fichero
	file_put_contents('incidencias.json', $data);
}

//Funcion para mover las incidencias resueltas
function moverIncidenciasResueltas($id)
{
	//obtenemis las incidencias
	$incidencias = obtenerDatosJson("incidencias.json");
	//obtenemos las incidencias resueltas
	$incidencia_resueltas = obtenerDatosJson("incidencias_resueltas.json");
	foreach ($incidencias as $clave => $valor) {
		//si el id de la incidencia es igual al id pasado por parametro y la incidencia esta resuelta
		if ($valor['id'] == $id && $valor['resuelto'] == "Si") {
			//añadimos las incidencias al array
			array_push($incidencia_resueltas, $valor);
		}
	}
	$data = json_encode($incidencia_resueltas, JSON_PRETTY_PRINT);
	//sobreescribimos las incidencias resueltas
	file_put_contents('incidencias_resueltas.json', $data);
	//borramos las incidencia que esta resuelta del archivo incidencias
	borrarIncidenciaResuelta($id);
}

//Funcion para deasignar un usuario de una incidencia
function quitarUsuarioIncidencia($login)
{
	//obtenmos las incidencias
	$incidencias = obtenerDatosJson("cliente/incidencias.sjon");
	foreach ($incidencias as $clave => $valor) {
		//si el tecnico es igual al login pasado por parametro
		if ($valor['tecnico'] == $login) {
			//sobreescribimos el tecnico asignadonde vacio
			$incidencias[$clave]['tecnico'] = "";
		}
	}
	$data = json_encode($incidencias, JSON_PRETTY_PRINT);
	//sobreescribimos el fichero
	file_put_contents('cliente/incidencias.json', $data);
}

//Funcion para borrar un usuario
function borrarUsuario($login)
{
	//si el usuario tiene una incidencia
	if (comprobarUsuarioTieneIncidencia($login)) {
		//le desasignamos la incidencia al usuario
		quitarUsuarioIncidencia($login);
	}
	//obtenemos los usuarios
	$datos_usuarios = obtenerDatosJson("datos_tecnicos.json");
	foreach ($datos_usuarios as $clave => $valor) {
		//si el login es igual al login pasado por parametro
		if ($valor['login'] == $login) {
			//boramos el usuario
			unset($datos_usuarios[$clave]);
		}
	}
	//organizamos el array
	$datos_usuarios = array_values($datos_usuarios);
	$data = json_encode($datos_usuarios, JSON_PRETTY_PRINT);
	//sobrescribimos el fichero
	file_put_contents('datos_tecnicos.json', $data);
}

//Funcion para borrar una incidencia
function borrarIncidencia($id)
{
	//obtenemos las inciendias
	$incidencias = obtenerDatosJson("incidencias.json");
	foreach ($incidencias as $clave => $valor) {
		//si el id de la incidencia es igual al id pasado por parametro
		if ($valor['id'] == $id) {
			//borramos la incidencia
			unset($incidencias[$clave]);
		}
	}
	//organizamos el array
	$incidencias = array_values($incidencias);
	$data = json_encode($incidencias, JSON_PRETTY_PRINT);
	//sobrescribimos el fichero
	file_put_contents('incidencias.json', $data);
}

//Funcion para borrar una incidencia resuelta
function borrarIncidenciaResuelta($id)
{
	$incidencias = obtenerDatosJson("incidencias.json");
	foreach ($incidencias as $clave => $valor) {
		//si el id de la incidencia es igual al id pasado por parametro y esta resuelta
		if ($valor['id'] == $id  && $valor['resuelto'] == "Si") {
			//borramos la incidencia
			unset($incidencias[$clave]);
		}
	}
	//organizamos el array
	$incidencias = array_values($incidencias);
	$data = json_encode($incidencias, JSON_PRETTY_PRINT);
	//sobrescribimos el fichero
	file_put_contents('incidencias.json', $data);
}

//Funcion para mostras las incidencias resueltas
function mostrarIncidenciasResueltas()
{
	//obtenemos las incidencias
	$incidencias = obtenerDatosJson("incidencias_resueltas.json");
	//si hay incidencias
	if (count($incidencias) > 0) {
		$tabla = "
				<div class='table-responsive'>
					<table  class='table table-dark table-hover'>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Problema del móvil</th>
							<th>Técnico</th>
							<th>Fecha Registro</th>
							<th>Fecha Arreglo</th>
                            <th>Precio</th>
							<th>Observaciones</th>
							<th>Resuelto</th>
						</tr>";
		foreach ($incidencias as $incidencia) {
			$tabla .= "
						<tr>
							<td>" . $incidencia['nombre'] . "</td>
                    		<td>" . $incidencia['email'] . "</td>
                    		<td>" . $incidencia['problema'] . "</td>
                    		<td>" . $incidencia['tecnico'] . "</td>
		                    <td>" . $incidencia['fecha'] . "</td>
							<td>" . $incidencia['fechaActu'] . "</td>
                    		<td>" . $incidencia['precio'] . "</td>
                            <td>" . $incidencia['observaciones'] . "</td>
                    		<td>" . $incidencia['resuelto'] . "</td>
                    	</tr>";
		}
		$tabla .= "</table></div>";
		return $tabla;
	//si no hay incidencias
	} else {
		return "<p>No hay incidencias resueltas</p>";
	}
}

//Funcion para comprobar si el usuario tiene incidencias resueltas
function comprobarUsuarioTieneIncidenciaResuelta()
{
	//obtenemos las incidencias
	$incidencias = obtenerDatosJson("incidencias_resueltas.json");
	foreach ($incidencias as $incidencia) {
		//si el tecnico es igual al usuario de la sesion
		if ($incidencia['tecnico'] == $_SESSION['usuario']) {
			return true;
		}
	}
	return false;
}

//Funcion para mostrar las incidencias resueltas de un usuario
function mostrarIncidenciasResueltasUsuario()
{
	//obtenemos las incidencias
	$incidencias = obtenerDatosJson("incidencias_resueltas.json");
	//sii el usuario tiene incidencias resuelta
	if (comprobarUsuarioTieneIncidenciaResuelta()) {
		$tabla = "
				<div class='table-responsive'>
					<table  class='table table-dark table-hover'>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Problema del móvil</th>
							<th>Técnico</th>
							<th>Fecha Registro</th>
							<th>Fecha Arreglo</th>
							<th>Precio</th>
							<th>Observaciones</th>
							<th>Resuelto</th>
						</tr>";
		foreach ($incidencias as $incidencia) {
			if ($incidencia['tecnico'] == $_SESSION['usuario']) {
				$tabla .= "
						<tr>
						<td>" . $incidencia['nombre'] . "</td>
						<td>" . $incidencia['email'] . "</td>
						<td>" . $incidencia['problema'] . "</td>
						<td>" . $incidencia['tecnico'] . "</td>
						<td>" . $incidencia['fecha'] . "</td>
						<td>" . $incidencia['fechaActu'] . "</td>
						<td>" . $incidencia['precio'] . "</td>
						<td>" . $incidencia['observaciones'] . "</td>
						<td>" . $incidencia['resuelto'] . "</td>
                    	</tr>";
			}
		}
		$tabla .= "</table></div>";
		return $tabla;
	//si el usuario no tiene incidencias resuelta
	} else {
		return "<p>No tienes incidencias resueltas</p>";
	}
}

//Funcion para inserta una incidenia
function insertarIncidencia($nombre, $mail, $tecnico, $problema, $fecha)
{
	//Obtengo el contenido del json
	$data = file_get_contents('incidencias.json');
	//Decodifico el json
	$arrayexistente = json_decode($data, true);

	//Creo un contador para el id segun los archivos del json para asignar una id
	$id = 0;
	foreach ($arrayexistente as &$registro) {
		if ($registro['id'] > $id) {
			$id = $registro['id'];
		}
	}
	$id += 1;
	//Creo el array con los datos
	$datos = array(
		'id' => $id,
		'nombre' => $nombre,
		'email' => $mail,
		'tecnico' => $tecnico,
		'problema' => $problema,
		'fecha' => $fecha,
		'resuelto' => "No",
		'precio' => 0,
		'fechaActu' => "",
		'observaciones' => "",
	);

	//Agrego los datos al array
	array_push($arrayexistente, $datos);
	//Codifico el json
	$nuevosdatos = json_encode($arrayexistente, JSON_PRETTY_PRINT);
	// Guardar el array actualizado en el archivo JSON
	file_put_contents('incidencias.json', $nuevosdatos);
}

//Funcion para actualizar una incidencia
function actualizarIncidencia($id, $precio, $observaciones)
{
	//Obtengo el contenido del json
	$json = file_get_contents('incidencias.json');
	//Decodifico el json
	$data = json_decode($json, true);
	//Creo un contador para el id segun los archivos del json para asignar una id
	foreach ($data as &$registro) {
		if ($registro['id'] == $id) {
			// Actualizar la ciudad del registro
			$registro['precio'] = $precio;
			$registro['observaciones'] = $observaciones;
		}
	}
	$nuevosdatos = json_encode($data, JSON_PRETTY_PRINT);
	//sobrescribimos el fichero
	file_put_contents('incidencias.json', $nuevosdatos);
}

//Funcion para comprobar si el usuario esta autorizado
function comprobarUsuarioEstaAutorizado($login) {
	//obtrnemos los tecnicos
	$tecnicos = obtenerDatosJson('datos_tecnicos.json');
	foreach ($tecnicos as $tecnico) {
		//si el login es igual al login pasado por parametro y esta autorizado
		if ($tecnico['login'] == $login && $tecnico['autorizado'] == 'Si') {
			return true;
		}
	}
	return false;
}

function actualizarEstadoUsuarioAutorizado($login) {
	//obtrnemos los tecnicos
	$tecnicos = obtenerDatosJson('datos_tecnicos.json');
	foreach ($tecnicos as $clave => $valor) {
		//si el login es igual al login pasado por parametro y no esta autorizado
		if ($valor['login'] == $login && $valor['autorizado'] == "No") {
			//cambios el estado de autorizado a Si
			$tecnicos[$clave]['autorizado'] = "Si";
		//si el login es igual al login pasado por parametro y esta autorizado
		} elseif($valor['login'] == $login && $valor['autorizado'] == "Si") {
			//cambios el estado de autorizado a No
			$tecnicos[$clave]['autorizado'] = "No";
		}
	}
	$data = json_encode($tecnicos, JSON_PRETTY_PRINT);
	//sobreescribimos el fichero
	file_put_contents('datos_tecnicos.json', $data);
}