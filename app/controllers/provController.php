<?php

namespace app\controllers;

use app\models\mainModel;

class provController extends mainModel
{

    public function obtenerOpcionesProveedores()
    {
        $consulta_proveedores = "SELECT * FROM proveedores ORDER BY nombre_proveedor";
        $datos_proveedores = $this->ejecutarConsulta($consulta_proveedores);
        $opciones_proveedores = "";

        while ($proveedor = $datos_proveedores->fetch()) {
            $opciones_proveedores =  $proveedor['nombre_proveedor'];
            $opciones_proveedores =  $proveedor['email_proveedor'];
            $opciones_proveedores =  $proveedor['telefono_proveedor'];
            $opciones_proveedores =  $proveedor['direccion_proveedor'];
            $opciones_proveedores =  $proveedor['contacto_proveedor'];

        }

        return $opciones_proveedores;
    }

    /*----------  Controlador registrar proveedor  ----------*/
    public function registrarProveedorControlador()
    {

        # Almacenando datos#

        $proveedor = $this->limpiarCadena($_POST['nombre_proveedor']);
        $RFC = $this->limpiarCadena($_POST['RFC_proveedor']);
        $email = $this->limpiarCadena($_POST['email_proveedor']);
        $telefono = $this->limpiarCadena($_POST['telefono_proveedor']);
        $direccion = $this->limpiarCadena($_POST['direccion_proveedor']);
        $contacto = $this->limpiarCadena($_POST['contacto_proveedor']);

        # Verificando campos obligatorios #
        if ($proveedor == "" || $RFC == "" || $telefono == "" || $email == "" || $direccion == "" || $contacto == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        
        if ($this->verificarDatos("[a-zA-Z0-9 ]{3,100}", $RFC)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El nombre de proveedor no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El email de proveedor no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9]{6,20}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El teléfono de proveedor no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

       
        
       

        # Verificando proveedor #
        $check_proveedor = $this->ejecutarConsulta("SELECT nombre_proveedor FROM proveedores WHERE nombre_proveedor='$proveedor'");
        if ($check_proveedor->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El proveedor ingresado ya se encuentra registrado, por favor elija otro",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $proveedor_datos_reg = [

            [
                "campo_nombre" => "nombre_proveedor",
                "campo_marcador" => ":Proveedor",
                "campo_valor" => $proveedor
            ],
            [
                "campo_nombre" => "RFC_proveedor",
                "campo_marcador" => ":RFC",
                "campo_valor" => $RFC
            ],
            [
                "campo_nombre" => "email_proveedor",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "telefono_proveedor",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "direccion_proveedor",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "contacto_proveedor",
                "campo_marcador" => ":Contacto",
                "campo_valor" => $contacto
            ]
           
        ];

        $registrar_proveedor = $this->guardarDatos("proveedores", $proveedor_datos_reg);

        if ($registrar_proveedor->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Usuario registrado",
                "texto" => "El proveedor " . $proveedor . " se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el proveedor, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);

    }
    




    /*----------  Controlador listar usuario  ----------*/
    public function listarProvedoresControlador($pagina, $registros, $url, $busqueda)
    {

        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);

        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";

        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        $consulta_datos = "SELECT *
                FROM proveedores
                WHERE nombre_proveedor LIKE '%$busqueda%'
                ORDER BY nombre_proveedor ASC
                LIMIT $inicio, $registros;
                ";

        $consulta_total = "SELECT COUNT(id_proveedor)
                FROM proveedores
                WHERE nombre_proveedor LIKE '%$busqueda%';
                ";

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla .= '
		        <div class="table-container">
		        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
		            <thead>
		                <tr>
		                    <th class="has-text-centered">#</th>
		                    <th class="has-text-centered">Nombre</th>
                            <th class="has-text-centered">RFC</th>
                            <th class="has-text-centered">e-mail</th>
                            <th class="has-text-centered">Teléfono</th>
                            <th class="has-text-centered">Direccion</th>
                            <th class="has-text-centered">Contacto</th>
		                    <th class="has-text-centered" colspan="3">Opciones</th>
		                </tr>
		            </thead>
		            <tbody>
		    ';

        if ($total >= 1 && $pagina <= $numeroPaginas) {
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
						<tr class="has-text-centered" >
							<td>' . $contador . '</td>
							<td>' . $rows['nombre_proveedor'] . '</td>
                            <td>' . $rows['RFC_proveedor'] . '</td>
                            <td>' . $rows['email_proveedor'] . '</td>
                            <td>' . $rows['telefono_proveedor'] . '</td>
                            <td>' . $rows['direccion_proveedor'] . '</td>
                            <td>' . $rows['contacto_proveedor'] . '</td>
			                <td>
			                    <a href="' . APP_URL . 'provUpdate/' . $rows['id_proveedor'] . '/" class="btn btn-info">Actualizar</a>
			                </td>
						</tr>
					';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla .= '
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    <a href="' . $url . '1/" class="button is-link is-rounded is-small mt-4 mb-4">
			                        Haga clic acá para recargar el listado
			                    </a>
			                </td>
			            </tr>
					';
            } else {
                $tabla .= '
						<tr class="has-text-centered" >
			                <td colspan="7">
			                    No hay registros en el sistema
			                </td>
			            </tr>
					';
            }
        }

        $tabla .= '</tbody></table></div>';

        ### Paginacion ###
        if ($total > 0 && $pagina <= $numeroPaginas) {
            $tabla .= '<p class="has-text-right">Mostrando proveedores <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';

            $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
        }

        return $tabla;
    }


    /*----------  Controlador actualizar usuario  ----------*/
    public function actualizarProveedorControlador()
    {

        $id = $this->limpiarCadena($_POST['id_proveedor']);

        # Verificando usuario #
        $datos = $this->ejecutarConsulta("SELECT * FROM proveedores WHERE id_proveedor='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el proveedor en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $datos = $datos->fetch();
        }

        $proveedor = $this->limpiarCadena($_POST['nombre_proveedor']);
        $RFC = $this->limpiarCadena($_POST['RFC_proveedor']);
        $email = $this->limpiarCadena($_POST['email_proveedor']);
        $telefono = $this->limpiarCadena($_POST['telefono_proveedor']);
        $direccion = $this->limpiarCadena($_POST['direccion_proveedor']);
        $contacto = $this->limpiarCadena($_POST['contacto_proveedor']);

        # Verificando campos obligatorios  #
        if ($proveedor == "" || $RFC == "" || $email == "" || $telefono == "" || $direccion == "" || $contacto == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "Favor de llenar todos los campos",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

       
        if ($this->verificarDatos("[a-zA-Z0-9 ]{12,14}", $RFC)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El RFC de proveedor no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El email de proveedor no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-Z0-9 ]{5,20}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El teléfono de proveedor no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

       
        # Verificando proveedor #
        if ($datos['nombre_proveedor'] != $proveedor) {
            $check_usuario = $this->ejecutarConsulta("SELECT nombre_proveedor FROM proveedores WHERE nombre_proveedor='$proveedor'");
            if ($check_usuario->rowCount() > 0) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El Proveedor ingresado ya se encuentra registrado, por favor elija otro",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }


        $proveedor_datos_up = [
            [
                "campo_nombre" => "nombre_proveedor",
                "campo_marcador" => ":Proveedor",
                "campo_valor" => $proveedor
            ],
            [
                "campo_nombre" => "RFC_proveedor",
                "campo_marcador" => ":RFC",
                "campo_valor" => $RFC
            ],
            [
                "campo_nombre" => "email_proveedor",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "telefono_proveedor",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "direccion_proveedor",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "contacto_proveedor",
                "campo_marcador" => ":Contacto",
                "campo_valor" => $contacto
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_proveedor",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("proveedores", $proveedor_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Proveedor actualizado",
                "texto" => "Los datos del proveedor " . $datos['nombre_proveedor'] . " se actualizaron correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del proveedor " . $datos['nombre_proveedor'] . ", por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }


}