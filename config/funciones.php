<?php
    //Metodo para crear archivo json
    function anyadirTecnicoJson($nombre, $apellidos, $login, $password, $email){
        $data = file_get_contents('datos_tecnicos.json');
        $data = json_decode($data, true);
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
        file_put_contents('datos_tecnicos.json', $data);
    }

	function autorizarTecnico($login)
	{
		$tecnicos = obtenerUsuarios();
		foreach ($tecnicos as $tecnico)
		{
			if ($tecnico['login'] == $login && $tecnico['autorizado'] == "no")
			{
				return (true);
			}
			return (false);
		}
	}

    function obtenerTecnicosJson(){
        $datos_tecnicos = file_get_contents("datos_tecnicos.json");
        $json_tecnicos = json_decode($datos_tecnicos, true);
        return $json_tecnicos;
    }

    function existeLogin($login) {
        $datos_tecnicos = obtenerTecnicosJson();
        if (count($datos_tecnicos) != 0) {
            foreach($datos_tecnicos as $tecnicos) {
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
        if (strcmp($password, $password2) == 0) {
            if (strlen($password) < 6) {
                $error = "La contraseña debe tener al menos 6 caracteres";
            }
            if (!preg_match('`[a-z]`', $password)) {
                $error = "La contraseña debe tener al menos 1 minuscula";
            }
            if (!preg_match('`[A-Z]`', $password)) {
                $error = "La contraseña debe tener al menos 1 mayuscula";
            }
            if (!preg_match('`[0-9]`', $password)) {
                $error = "La contraseña debe tener al menos un numero";
            }
        } else {
            $error = "Las contraseñas deben ser iguales";
        }
        return $error;
    }

    function validar_email($email)
    {
        $error = "";
        if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
            $error = "El email no es valido";
        }
        return $error;
    }

    function obtenerPassword($login) {
        $datos_tecnicos = obtenerTecnicosJson();
		foreach ($datos_tecnicos as $clave => $valor)
		{
			if ($valor['login'] == $login)
			{
				return ($valor['password']);
			}
		}
    }

    function comprobarInicioSesion($login, $password)
    {
		$password_json = obtenerPassword($login);
        if (password_verify($password, $password_json)) {
            return true;
        } else {
            return false;
        }
    }

    function obtenerIncidenciasJson() {
        $incidencias = file_get_contents("incidencias.json");
        $json_tecnicos = json_decode($incidencias, true);
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
                    		<td>".$tecnico['email']."</td>";
				if ($tecnico['autorizado'] == "si")
				{
						$tabla.= "
							<td>
								<select name='' id=''>
									<option value='si' selected>Si</option>
									<option value='no'>No</option>
								</select>
							</td>
						";
				}
				else
				{
					$tabla.= "
							<td>
								<select name='' id=''>
									<option value='si'>Si</option>
									<option value='no' selected>No</option>
								</select>
							</td>
						";
				}

                $tabla .= "</tr>";
            }
			$tabla.="
					</table>
				</div>";
			return $tabla;
	}

    function mostrarIncidencias() {
        $incidencias = obtenerIncidenciasJson();
        if(comprobarUsuarioTieneIncidencia()) {
            $tabla = "
				<div class='table-responsive'>
					<table  class='table table-dark table-hover'>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Problema del móvil</th>
							<th>Fecha</th>
							<th>Técnico</th>
                            <th>Precio</th>
							<th>Resumen Precio</th>
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
		                    <td>".$incidencia['fecha']."</td>
                    		<td>".$incidencia['tecnico']."</td>
                    		<td>".$incidencia['precio']."</td>
                            <td>".$incidencia['resumen_precio']."</td>
                    		<td>".$incidencia['resuelto']."</td>
		                    <td>
								<a href='gestion.php?fin=$incidencia[id]'>
                                    <input type='image' src='../img/finalizar.png' id='aceptar' name='aceptar' value=''/>
								</a>
							</td>
		                    <td>
								<a href='editarIncidencia.php?id=$incidencia[id]'>
									<img src='../img/lapiz.png' alt=''>
									</a>
							</td>
                    		<td>
								<a href='borrarIncidencia.php?id=$incidencia[id]'>
									<img src='../img/borrar.png' alt=''>
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
					<table  class='table table-dark table-hover'>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Problema del móvil</th>
							<th>Fecha</th>
							<th>Técnico</th>
							<th>Resuelto</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>";
            foreach($incidencias as $incidencia) {
                $tabla.="
						<tr>
							<td>".$incidencia['nombre']."</td>
							<td>".$incidencia['email']."</td>
							<td>".$incidencia['problema']."</td>
							<td>".$incidencia['fecha']."</td>
							<td>".$incidencia['tecnico']."</td>
							<td>".$incidencia['resuelto']."</td>
                			<td>";

				if ( $incidencia['tecnico'] == "")
				{
					$tabla .= "
							<td>
								<a href='gestion.php?id=$incidencia[id]'>
								<input type='image' src='../img/aceptar.png' id='aceptar' name='aceptar'/>
								</a>
							</td>
					";
				}
            }
            $tabla.="	</tr>
					</table>
				</div>";
            return $tabla;
        }
    }

    function comprobarSiEstaLogeado() {
        if (!isset($_SESSION['usuario'])) {
            die("Error debes <a href='../index.php'>identificarse</a>");
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
                if($valor['precio'] > 0  && $valor['resumen_precio'] != "") {
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
		borrarIncidencia($id);
    }


	function borrarIncidencia($id) {
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
            $tabla = "
				<div class='table-responsive'>
					<table  class='table table-dark table-hover'>
						<tr>
							<th>Nombre</th>
							<th>Email</th>
							<th>Problema del móvil</th>
							<th>Fecha</th>
							<th>Técnico</th>
                            <th>Precio</th>
							<th>Resumen Precio</th>
							<th>Resuelto</th>
						</tr>";
            foreach($incidencias as $incidencia) {
                    $tabla.="
						<tr>
							<td>".$incidencia['nombre']."</td>
                    		<td>".$incidencia['email']."</td>
                    		<td>".$incidencia['problema']."</td>
		                    <td>".$incidencia['fecha']."</td>
                    		<td>".$incidencia['tecnico']."</td>
                    		<td>".$incidencia['precio']."</td>
                            <td>".$incidencia['resumen_precio']."</td>
                    		<td>".$incidencia['resuelto']."</td>
                    	</tr>";
                }
                $tabla.="</table></div>";
                return $tabla;
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
							<th>Fecha</th>
							<th>Técnico</th>
                            <th>Precio</th>
							<th>Resumen Precio</th>
							<th>Resuelto</th>
						</tr>";
            foreach($incidencias as $incidencia) {
				if($incidencia['tecnico'] == $_SESSION['usuario']) {
                    $tabla.="
						<tr>
							<td>".$incidencia['nombre']."</td>
                    		<td>".$incidencia['email']."</td>
                    		<td>".$incidencia['problema']."</td>
		                    <td>".$incidencia['fecha']."</td>
                    		<td>".$incidencia['tecnico']."</td>
                    		<td>".$incidencia['precio']."</td>
                            <td>".$incidencia['resumen_precio']."</td>
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