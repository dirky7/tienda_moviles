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
        );
        $data[] = $add_arr;
        $data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('datos_tecnicos.json', $data);
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

    function mostrarIncidencias() {
        $incidencias = obtenerIncidenciasJson();
        $tabla = "<table><tr><th>Nombre</th><th>Email</th><th>Problema del móvil</th><th>Fecha</th>Técnico</th><th>Resuelto</th><th></th><th></th></tr>";
        foreach($incidencias as $incidencia) {
            $tabla.="<tr><td>".$incidencia['nombre']."<td><td>".$incidencia['email']."<td><td>".$incidencia['problema']."<td><td>".$incidencia['fecha']."<td><td>".$incidencia['tecnico']."<td><td>".$incidencia['resuelto']."<td><a href='editarIncidencia.php?id=$incidencia[id]><input type='button' name='editar' value='jesus'></a><td><td><a href='borrarIncidencia.php?id=$incidencia[id]><input type='button' name='borrar'>../img/borrar.png</a><td></tr>";
        }
        $tabla.="</table>";
        return $tabla;
    }
