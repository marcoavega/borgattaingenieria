<?php

namespace app\controllers;

use app\models\mainModel;

class clientController extends mainModel
{

    public function obtenerOpcionesClientes()
    {
        $consulta = "SELECT * FROM clientes ORDER BY nombre_cliente";
        $datos = $this->ejecutarConsulta($consulta);
        $opciones = "";

        while ($cliente = $datos->fetch()) {
            $opciones =  $cliente['nombre_cliente'];
            $opciones =  $cliente['email'];
            $opciones =  $cliente['telefono'];
            $opciones =  $cliente['direccion'];
        }

        return $opciones;
    }

    /*----------  Controlador registrar proveedor  ----------*/
    public function registrarClienteControlador()
    {

        # Almacenando datos#

        $cliente = $this->limpiarCadena($_POST['nombre_cliente']);
        $RFC = $this->limpiarCadena($_POST['rfc_cliente']);
        $direccion = $this->limpiarCadena($_POST['direccion']);
        $email = $this->limpiarCadena($_POST['email']);
        $telefono = $this->limpiarCadena($_POST['telefono']);

        # Verificando campos obligatorios #
        if ($cliente == "" || $RFC == "" || $telefono == "" || $email == "" || $direccion == "") {
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
                "texto" => "El nombre de cliente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El email de cliente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[0-9]{6,20}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El teléfono de cliente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

       
        
       

        # Verificando proveedor #
        $check_cliente = $this->ejecutarConsulta("SELECT nombre_cliente FROM clientes WHERE nombre_cliente='$cliente'");
        if ($check_cliente->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El cliente ingresado ya se encuentra registrado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $cliente_datos_reg = [

            [
                "campo_nombre" => "nombre_cliente",
                "campo_marcador" => ":Cliente",
                "campo_valor" => $cliente
            ],
            [
                "campo_nombre" => "rfc_cliente",
                "campo_marcador" => ":RFC",
                "campo_valor" => $RFC
            ],
            [
                "campo_nombre" => "direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ]
           
        ];

        $registrar_cliente = $this->guardarDatos("clientes", $cliente_datos_reg);

        if ($registrar_cliente->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Usuario registrado",
                "texto" => "El cliente " . $cliente . " se registro con exito",
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
    public function listarClientesControlador($pagina, $registros, $url, $busqueda)
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
                FROM 
                clientes
                WHERE nombre_cliente LIKE '%$busqueda%'
                ORDER BY nombre_cliente ASC
                LIMIT $inicio, $registros;
                ";

        $consulta_total = "SELECT COUNT(id_cliente)
                FROM clientes
                WHERE nombre_cliente LIKE '%$busqueda%';
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
							<td>' . $rows['nombre_cliente'] . '</td>
                            <td>' . $rows['rfc_cliente'] . '</td>
                            <td>' . $rows['email'] . '</td>
                            <td>' . $rows['telefono'] . '</td>
                            <td>' . $rows['direccion'] . '</td>
			                <td>
			                    <a href="' . APP_URL . 'clientUpdate/' . $rows['id_cliente'] . '/" class="btn btn-info">Actualizar</a>
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
            $tabla .= '<p class="has-text-right">Mostrando clientes <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';

            $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
        }

        return $tabla;
    }


    /*----------  Controlador actualizar usuario  ----------*/
    public function actualizarClienteControlador()
    {

        $id = $this->limpiarCadena($_POST['id_cliene']);

        # Verificando usuario #
        $datos = $this->ejecutarConsulta("SELECT * FROM clientes WHERE id_cliente='$id'");
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

        $cliente = $this->limpiarCadena($_POST['nombre_cliente']);
        $RFC = $this->limpiarCadena($_POST['rfc_cliente']);
        $direccion = $this->limpiarCadena($_POST['direccion']);
        $email = $this->limpiarCadena($_POST['email']);
        $telefono = $this->limpiarCadena($_POST['telefono']);
       

        # Verificando campos obligatorios  #
        if ($cliente == "" || $RFC == "" || $email == "" || $telefono == "" || $direccion == "") {
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
                "texto" => "El RFC de cliente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El email de cliente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-Z0-9 ]{5,20}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El teléfono de cliente no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

       
        # Verificando proveedor #
        if ($datos['nombre'] != $cliente) {
            $check_usuario = $this->ejecutarConsulta("SELECT nombre_cliente FROM clientes WHERE nombre_cliente='$cliente'");
            if ($check_usuario->rowCount() > 0) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "El cliente ingresado ya se encuentra registrado, por favor elija otro",
                    "icono" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        }


        $cliente_datos_up = [
            [
                "campo_nombre" => "nombre_cliente",
                "campo_marcador" => ":Ciente",
                "campo_valor" => $cliente
            ],
            [
                "campo_nombre" => "rfc_cliente",
                "campo_marcador" => ":RFC",
                "campo_valor" => $RFC
            ],
            [
                "campo_nombre" => "email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion
            ]

        ];

        $condicion = [
            "condicion_campo" => "id_cliente",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("proveedores", $cliente_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Proveedor actualizado",
                "texto" => "Los datos del Cliemte " . $datos['nombre_cliente'] . " se actualizaron correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del cliente " . $datos['nombre_proveedor'] . ", por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }


}