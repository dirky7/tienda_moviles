<?php
    //Funcion para anyadir un tecnico al fichero json datos_tecnicos
    function anyadirTecnicoJson($nombre, $apellidos, $login, $password, $email){
        $data = file_get_contents('datos_tecnicos.json');
        $data = json_decode($data, true);
		//Array donde asignamos a cada clave un valor
        $add_arr = array(
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'login' => $login,
        'password' => crypt($password, "XC"),
        'email' => $email,
		'autorizado' => 'no'
        );
        $data[] = $add_arr;
        $data = json_encode($data, JSON_PRETTY_PRINT);
		//pasamos los datos del array al archivo
        file_put_contents('datos_tecnicos.json', $data);
    }

	//Funcion para darle permisos de autorizacion a un tecnico
	function autorizarTecnico($login)
	{
		//obtenemos los tecnicos
		$tecnicos = obtenerUsuarios();
		foreach ($tecnicos as $tecnico)
		{
			//si el login del tecnico es igual al login pasado por parametro y no este autorizado
			if ($tecnico['login'] == $login && $tecnico['autorizado'] == "no")
			{
				return (true);
			}
			return (false);
		}
	}

	//Funcion con la que obtenemos los tecnicos del fichero json
    function obtenerTecnicosJson(){
        $datos_tecnicos = file_get_contents("datos_tecnicos.json");
        $json_tecnicos = json_decode($datos_tecnicos, true);
		//Devolvemos el contenido del fichero
        return $json_tecnicos;
    }

	//Funcion para comprobar si existe el usuario
    function existeLogin($login) {
		//oobtenemos los datos de los tecnicos
        $datos_tecnicos = obtenerTecnicosJson();
        if (count($datos_tecnicos) != 0) {
            foreach($datos_tecnicos as $tecnicos) {
				//si el login es igual login pasado por parametro
                if($tecnicos['login'] == $login) {
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
    function obtenerPassword($login) {
        $datos_tecnicos = obtenerTecnicosJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			//si el login es igual login pasado por parametro
			if ($valor['login'] == $login)
			{
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

	//Funcion para obtener las incidencias del json
    function obtenerIncidenciasJson() {
        $incidencias = file_get_contents("incidencias.json");
        $json_tecnicos = json_decode($incidencias, true);
		//Devolvemos el contenido del fichero
        return $json_tecnicos;
    }

	function obtenerUsuarios()
	{
		$tecnicos = file_get_contents("datos_tecnicos.json");
        $json_tecnicos = json_decode($tecnicos, true);
        return $json_tecnicos;
	}

    function comprobarUsuarioTieneIncidencia() {
        $incidencias = obtenerIncidenciasJson();
		foreach($incidencias as $incidencia) {
			if($incidencia['tecnico'] == $_SESSION['usuario'] && $incidencia['resuelto'] == "No")
			{
				return true;
			}
		}
		return false;
    }


	function mostrarUsuarios()
	{
		$tecnicos = obtenerUsuarios();
		$tabla = "
				<div class='table-responsive'>
					<table  class='table table-dark table-hover'>
						<tr>
							<th>Nombre</th>
							<th>Apellidos</th>
							<th>Login</th>
							<th>Email</th>
							<th>Autorización</th>
						</tr>";
            foreach($tecnicos as $tecnico)
			{
                $tabla.="
						<tr>
							<td>".$tecnico['nombre']."</td>
                    		<td>".$tecnico['apellidos']."</td>
		                    <td>".$tecnico['login']."</td>
                    		<td>".$tecnico['email']."</td>
							<td>".$tecnico['autorizado']."</td>
							<td><
						</tr>";
            }
			$tabla.="
					</table>
				</div>";
			return $tabla;
	}

    function mostrarIncidencias() {
        $incidencias = obtenerIncidenciasJson();
		if(count($incidencias) > 0) {
			if(comprobarUsuarioTieneIncidencia()) {
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
				foreach($incidencias as $incidencia) {
					if($incidencia['tecnico'] == $_SESSION['usuario']) {
						$tabla.="
							<tr>
								<td>".$incidencia['nombre']."</td>
								<td>".$incidencia['email']."</td>
								<td>".$incidencia['problema']."</td>
								<td>".$incidencia['tecnico']."</td>
								<td>".$incidencia['fecha']."</td>
								<td>".$incidencia['precio']."</td>
								<td>".$incidencia['observaciones']."</td>
								<td>".$incidencia['resuelto']."</td>
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
					$tabla.="</table></div>";
					return $tabla;
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
				foreach($incidencias as $incidencia) {
					$tabla.="
							<tr>
								<td>".$incidencia['nombre']."</td>
								<td>".$incidencia['email']."</td>
								<td>".$incidencia['problema']."</td>
								<td>".$incidencia['tecnico']."</td>
								<td>".$incidencia['fecha']."</td>
								<td>".$incidencia['resuelto']."</td>";

					if ( $incidencia['tecnico'] == "")
					{
						$tabla .= "
								<td class='columAceptar'>
									<a href='gestion.php?id=$incidencia[id]'>
									<input class='aceptar' type='image' src='../img/aceptar.png' name='aceptar'/>
									</a>
								</td>
						";
					} else {
						$tabla .= "<td></td>";
					}
				}
				$tabla.="	</tr>
						</table>
					</div>";
				return $tabla;
			}
		} else {
			return "<p>No hay incidencias para mostrar</p>";
		}
    }

    function comprobarSiEstaLogeado($invitado = false) {
		if($invitado) {
			if (!isset($_SESSION['usuario']))  {
				die("Error debes <a href='../index.php'>identificarse</a> o entrar como <a href='../index.php'>Invitado</a>");
			}
		} else {
			if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "Invitado")  {
				die("Error debes <a href='../index.php'>identificarse</a>");
			}
		}
    }

    function anyadirTecnicoIncidencia($id) {
        $datos_tecnicos = obtenerIncidenciasJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['id'] == $id)
			{
				$datos_tecnicos[$clave]['tecnico'] = $_SESSION['usuario'];
			}
		}
        $data = json_encode($datos_tecnicos, JSON_PRETTY_PRINT);
        file_put_contents('incidencias.json', $data);
    }

    function comprobarNoHayDatosVacios($id) {
        $datos_tecnicos = obtenerIncidenciasJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['id'] == $id )
			{
                if($valor['precio'] > 0 && $valor['observaciones'] != "") {
                    return true;
                }
			}
		}
        return false;
    }

    function actualizarIncidenciaResuelta($id) {
        $datos_tecnicos = obtenerIncidenciasJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['id'] == $id)
			{
				$datos_tecnicos[$clave]['fechaActu'] = date("d-m-Y h:i");
				$datos_tecnicos[$clave]['resuelto'] = "Si";
			}
		}
        $data = json_encode($datos_tecnicos, JSON_PRETTY_PRINT);
        file_put_contents('incidencias.json', $data);
    }

	function obtenerIncidenciasResueltasJson() {
        $incidencias_resueltas = file_get_contents("incidencias_resueltas.json");
        $json_resueltas = json_decode($incidencias_resueltas, true);
        return $json_resueltas;
    }

	function comprbarSiNoExisteIncidencia($id) {
		$incidencia_resueltas = obtenerIncidenciasResueltasJson();
		if (count($incidencia_resueltas) > 0) {
			foreach ($incidencia_resueltas as $clave => $valor) {
				if ($valor['id'] != $id) {
					return true;
				} else {
					return false;
				}
			}
		}
		return true;
	}

    function moverIncidenciasResueltas($id) {
        $datos_tecnicos = obtenerIncidenciasJson();
        $incidencia_resueltas = obtenerIncidenciasResueltasJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['id'] == $id && $valor['resuelto'] == "Si")
			{
				if(comprbarSiNoExisteIncidencia($id)) {
					array_push($incidencia_resueltas, $valor);
				}
            }
		}
        $data = json_encode($incidencia_resueltas, JSON_PRETTY_PRINT);
        file_put_contents('incidencias_resueltas.json', $data);
		borrarIncidenciaResuelta($id);
    }

	function borrarIncidencia($id) {
		$datos_tecnicos = obtenerIncidenciasJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['id'] == $id )
			{
				unset($datos_tecnicos[$clave]);
			}
		}
		$datos_tecnicos = array_values($datos_tecnicos);
		$data = json_encode($datos_tecnicos, JSON_PRETTY_PRINT);
        file_put_contents('incidencias.json', $data);
	}


	function borrarIncidenciaResuelta($id) {
		$datos_tecnicos = obtenerIncidenciasJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['id'] == $id  && $valor['resuelto'] == "Si")
			{
				unset($datos_tecnicos[$clave]);
			}
		}
		$datos_tecnicos = array_values($datos_tecnicos);
		$data = json_encode($datos_tecnicos, JSON_PRETTY_PRINT);
        file_put_contents('incidencias.json', $data);
	}

	function mostrarIncidenciasResueltas() {
        $incidencias = obtenerIncidenciasResueltasJson();
		if(count($incidencias) > 0) {
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
            foreach($incidencias as $incidencia) {
                    $tabla.="
						<tr>
							<td>".$incidencia['nombre']."</td>
                    		<td>".$incidencia['email']."</td>
                    		<td>".$incidencia['problema']."</td>
                    		<td>".$incidencia['tecnico']."</td>
		                    <td>".$incidencia['fecha']."</td>
							<td>".$incidencia['fechaActu']."</td>
                    		<td>".$incidencia['precio']."</td>
                            <td>".$incidencia['observaciones']."</td>
                    		<td>".$incidencia['resuelto']."</td>
                    	</tr>";
                }
                $tabla.="</table></div>";
                return $tabla;
		} else {
			return "<p>No hay incidencias resueltas</p>";
		}
    }

	function comprobarUsuarioTieneIncidenciaResuelta() {
        $incidencias = obtenerIncidenciasResueltasJson();
		foreach($incidencias as $incidencia) {
			if($incidencia['tecnico'] == $_SESSION['usuario'])
			{
				return true;
			}
		}
		return false;
    }

	function mostrarIncidenciasResueltasUsuario() {
        $incidencias = obtenerIncidenciasResueltasJson();
		if(comprobarUsuarioTieneIncidenciaResuelta()) {
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
            foreach($incidencias as $incidencia) {
				if($incidencia['tecnico'] == $_SESSION['usuario']) {
                    $tabla.="
						<tr>
						<td>".$incidencia['nombre']."</td>
						<td>".$incidencia['email']."</td>
						<td>".$incidencia['problema']."</td>
						<td>".$incidencia['tecnico']."</td>
						<td>".$incidencia['fecha']."</td>
						<td>".$incidencia['fechaActu']."</td>
						<td>".$incidencia['precio']."</td>
						<td>".$incidencia['observaciones']."</td>
						<td>".$incidencia['resuelto']."</td>
                    	</tr>";
				}
            }
                $tabla.="</table></div>";
                return $tabla;
		} else {
			return "<p>No tienes incidencias resueltas</p>";
		}
    }

	function insertarIncidencia($nombre, $mail,$tecnico, $problema, $fecha){
        //Obtengo el contenido del json
        $data = file_get_contents('incidencias.json');
        //Decodifico el json
        $arrayexistente = json_decode($data, true);
        //Creo un contador para el id segun los archivos del json para asignar una id

		$id=0;
		foreach ($arrayexistente as &$registro) {
			if ($registro['id'] > $id) {
				$id=$registro['id'];
			}

		}
	   $id +=1;
        //Creo el array con los datos
        $datos = array(
        'id' =>$id,
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
	    $nuevosdatos=json_encode($arrayexistente, JSON_PRETTY_PRINT);


		// Guardar el array actualizado en el archivo JSON
		file_put_contents('incidencias.json', $nuevosdatos);
    }

    function actualizarIncidencia($id,$precio,$observaciones){
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


		$nuevosdatos=json_encode($data, JSON_PRETTY_PRINT);
		file_put_contents('incidencias.json', $nuevosdatos);

    }


	function comprbarSiExisteUsuario($login) {
		$datos_tecnicos = obtenerTecnicosJson();
		if (count($datos_tecnicos) > 0) {
			foreach ($datos_tecnicos as $clave => $valor) {
				if ($valor['login'] == $login) {
					return true;
				}
			}
		}
		return false;
	}