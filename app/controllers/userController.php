<?php

	namespace app\controllers;
	use app\models\mainModel;

	class userController extends mainModel{

		/*----------  Controlador registrar usuario  ----------*/
		public function registrarUsuarioControlador(){

			# Almacenando datos#

		    $usuario=$this->limpiarCadena($_POST['usuario_usuario']);
		    $clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
		    $clave2=$this->limpiarCadena($_POST['usuario_clave_2']);


		    # Verificando campos obligatorios #
		    if($usuario=="" || $clave1=="" || $clave2==""){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando integridad de los datos #

		   
            # Verificando claves #
            if($clave1!=$clave2){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Las contraseñas que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
					"icono"=>"error"
				];
				return json_encode($alerta);
				exit();
			}else{
				$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
            }

            # Verificando usuario #
		    $check_usuario=$this->ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
		    if($check_usuario->rowCount()>0){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['usuario_foto']['name']!="" && $_FILES['usuario_foto']['size']>0){

    			# Creando directorio #
		        if(!file_exists($img_dir)){
		            if(!mkdir($img_dir,0777)){
		            	$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Error al crear el directorio",
							"icono"=>"error"
						];
						return json_encode($alerta);
		                exit();
		            } 
		        }

		        # Verificando formato de imagenes #
		        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Verificando peso de imagen #
		        if(($_FILES['usuario_foto']['size']/1024)>5120){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"La imagen que ha seleccionado supera el peso permitido",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

		        # Nombre de la foto #
		        $foto=str_ireplace(" ","_",$usuario);
		        $foto=$foto."_".rand(0,100);

		        # Extension de la imagen #
		        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
		            case 'image/jpeg':
		                $foto=$foto.".jpg";
		            break;
		            case 'image/png':
		                $foto=$foto.".png";
		            break;
		        }

		        chmod($img_dir,0777);

		        # Moviendo imagen al directorio #
		        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
		        	$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"No podemos subir la imagen al sistema en este momento",
						"icono"=>"error"
					];
					return json_encode($alerta);
		            exit();
		        }

    		}else{
    			$foto="";
    		}


		    $usuario_datos_reg=[
				
				[
					"campo_nombre"=>"usuario_usuario",
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				[
					"campo_nombre"=>"usuario_clave",
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"usuario_creado",
					"campo_marcador"=>":Creado",
					"campo_valor"=>date("Y-m-d H:i:s")
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$registrar_usuario=$this->guardarDatos("usuario",$usuario_datos_reg);

			if($registrar_usuario->rowCount()==1){
				$alerta=[
					"tipo"=>"limpiar",
					"titulo"=>"Usuario registrado",
					"texto"=>"El usuario ".$usuario." se registro con exito",
					"icono"=>"success"
				];
			}else{
				
				if(is_file($img_dir.$foto)){
		            chmod($img_dir.$foto,0777);
		            unlink($img_dir.$foto);
		        }

				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No se pudo registrar el usuario, por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);

		}



		/*----------  Controlador listar usuario  ----------*/
		public function listarUsuarioControlador($pagina,$registros,$url,$busqueda){

			$pagina=$this->limpiarCadena($pagina);
			$registros=$this->limpiarCadena($registros);

			$url=$this->limpiarCadena($url);
			$url=APP_URL.$url."/";

			$busqueda=$this->limpiarCadena($busqueda);
			$tabla="";

			$pagina = (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
			$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

			if(isset($busqueda) && $busqueda!=""){

				$consulta_datos="SELECT * FROM usuario WHERE ( (usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_usuario ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='".$_SESSION['id']."' AND usuario_id!='1') AND (usuario_usuario LIKE '%$busqueda%'))";

			}else{

				$consulta_datos="SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1' ORDER BY usuario_usuario ASC LIMIT $inicio,$registros";

				$consulta_total="SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='".$_SESSION['id']."' AND usuario_id!='1'";

			}

			$datos = $this->ejecutarConsulta($consulta_datos);
			$datos = $datos->fetchAll();

			$total = $this->ejecutarConsulta($consulta_total);
			$total = (int) $total->fetchColumn();

			$numeroPaginas =ceil($total/$registros);

			$tabla .= '
<div class="container-fluid">
    <div class="row">

        <!-- Menú lateral -->
        <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark bg-black">
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="' . APP_URL . 'userList/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Lista de Usuarios
                    </a>
                </li>
            </ul>
            <hr>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="' . APP_URL . 'userNew/" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                        Registrar Nuevo
                    </a>
                </li>
            </ul>
            <hr>
        </div>

        <!-- Contenido principal -->
        <div class="col-12 col-md-9 col-lg-10">
            <div class="container-fluid mb-4">
                <!-- Título de la página -->
                <h4 class="text-center">Usuarios</h4>
                <!-- Subtítulo de la página -->
                <h5 class="lead text-center">Lista de usuarios</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="table-primary text-center">
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                            <th colspan="3">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>';

        if($total >= 1 && $pagina <= $numeroPaginas){
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach($datos as $rows){
                $tabla .= '
                    <tr class="text-center">
                        <td>'.$contador.'</td>
                        <td>'.$rows['usuario_usuario'].'</td>
                        <td>'.date("d-m-Y  h:i:s A", strtotime($rows['usuario_creado'])).'</td>
                        <td>'.date("d-m-Y  h:i:s A", strtotime($rows['usuario_actualizado'])).'</td>
                        <td>
                            <a href="'.APP_URL.'userPhoto/'.$rows['usuario_id'].'/" class="btn btn-primary btn-sm">Foto</a>
                        </td>
                        <td>
                            <a href="'.APP_URL.'userUpdate/'.$rows['usuario_id'].'/" class="btn btn-info btn-sm">Actualizar</a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="'.APP_URL.'app/ajax/usuarioAjax.php" method="POST" autocomplete="off">
                                <input type="hidden" name="modulo_usuario" value="eliminar">
                                <input type="hidden" name="usuario_id" value="'.$rows['usuario_id'].'">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                ';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if($total >= 1){
                $tabla .= '
                    <tr class="text-center">
                        <td colspan="7">
                            <a href="'.$url.'1/" class="btn btn-link mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </td>
                    </tr>
                ';
            } else {
                $tabla .= '
                    <tr class="text-center">
                        <td colspan="7">
                            No hay registros en el sistema
                        </td>
                    </tr>
                ';
            }
        }

        $tabla .= '</tbody></table>
            </div>
        </div>
    </div>
</div>';
			

			return $tabla;
		}


		/*----------  Controlador eliminar usuario  ----------*/
		public function eliminarUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			if($id==1){
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos eliminar el usuario principal del sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
			}

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $eliminarUsuario=$this->eliminarRegistro("usuario","usuario_id",$id);

		    if($eliminarUsuario->rowCount()==1){

		    	if(is_file("../views/fotos/".$datos['usuario_foto'])){
		            chmod("../views/fotos/".$datos['usuario_foto'],0777);
		            unlink("../views/fotos/".$datos['usuario_foto']);
		        }

		        $alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario eliminado",
					"texto"=>"El usuario ".$datos['usuario_usuario']." ha sido eliminado del sistema correctamente",
					"icono"=>"success"
				];

		    }else{

		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido eliminar el usuario ".$datos['usuario_usuario']." del sistema, por favor intente nuevamente",
					"icono"=>"error"
				];
		    }

		    return json_encode($alerta);
		}


		/*----------  Controlador actualizar usuario  ----------*/
		public function actualizarUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    $admin_usuario=$this->limpiarCadena($_POST['administrador_usuario']);
		    $admin_clave=$this->limpiarCadena($_POST['administrador_clave']);

		    # Verificando campos obligatorios admin #
		    if($admin_usuario=="" || $admin_clave==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha llenado todos los campos que son obligatorios, que corresponden a su USUARIO y CLAVE",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"Su CLAVE no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando administrador #
		    $check_admin=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario='$admin_usuario' AND usuario_id='".$_SESSION['id']."'");
		    if($check_admin->rowCount()==1){

		    	$check_admin=$check_admin->fetch();

		    	if($check_admin['usuario_usuario']!=$admin_usuario || !password_verify($admin_clave,$check_admin['usuario_clave'])){

		    		$alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"USUARIO o CLAVE de administrador incorrectos",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		    	}
		    }else{
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"USUARIO o CLAVE de administrador incorrectos",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }


			# Almacenando datos#
		    $usuario=$this->limpiarCadena($_POST['usuario_usuario']);
		    $clave1=$this->limpiarCadena($_POST['usuario_clave_1']);
		    $clave2=$this->limpiarCadena($_POST['usuario_clave_2']);

		    # Verificando campos obligatorios #
		    if($usuario==""){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No has llenado todos los campos que son obligatorios",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando integridad de los datos #

		    if($this->verificarDatos("[a-zA-Z0-9 -]{4,20}",$usuario)){
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"El USUARIO no coincide con el formato solicitado",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    # Verificando email #

            # Verificando claves #
            if($clave1!="" || $clave2!=""){
            	if($this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave1) || $this->verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave2)){

			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Las CLAVES no coinciden con el formato solicitado",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }else{
			    	if($clave1!=$clave2){

						$alerta=[
							"tipo"=>"simple",
							"titulo"=>"Ocurrió un error inesperado",
							"texto"=>"Las nuevas CLAVES que acaba de ingresar no coinciden, por favor verifique e intente nuevamente",
							"icono"=>"error"
						];
						return json_encode($alerta);
						exit();
			    	}else{
			    		$clave=password_hash($clave1,PASSWORD_BCRYPT,["cost"=>10]);
			    	}
			    }
			}else{
				$clave=$datos['usuario_clave'];
            }

            # Verificando usuario #
            if($datos['usuario_usuario']!=$usuario){
			    $check_usuario=$this->ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
			    if($check_usuario->rowCount()>0){
			        $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"El USUARIO ingresado ya se encuentra registrado, por favor elija otro",
						"icono"=>"error"
					];
					return json_encode($alerta);
			        exit();
			    }
            }

            $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_usuario",
					"campo_marcador"=>":Usuario",
					"campo_valor"=>$usuario
				],
				[
					"campo_nombre"=>"usuario_clave",
					"campo_marcador"=>":Clave",
					"campo_valor"=>$clave
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['usuario']=$usuario;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Usuario actualizado",
					"texto"=>"Los datos del usuario ".$datos['usuario_usuario']." se actualizaron correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos podido actualizar los datos del usuario ".$datos['usuario_usuario'].", por favor intente nuevamente",
					"icono"=>"error"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador eliminar foto usuario  ----------*/
		public function eliminarFotoUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		chmod($img_dir,0777);

    		if(is_file($img_dir.$datos['usuario_foto'])){

		        chmod($img_dir.$datos['usuario_foto'],0777);

		        if(!unlink($img_dir.$datos['usuario_foto'])){
		            $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al intentar eliminar la foto del usuario, por favor intente nuevamente",
						"icono"=>"error"
					];
					return json_encode($alerta);
		        	exit();
		        }
		    }else{
		    	$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado la foto del usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>""
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']="";
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"La foto del usuario ".$datos['usuario_usuario']." se elimino correctamente",
					"icono"=>"success"
				];
			}else{
				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto eliminada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['usuario_usuario'].", sin embargo la foto ha sido eliminada correctamente",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}


		/*----------  Controlador actualizar foto usuario  ----------*/
		public function actualizarFotoUsuarioControlador(){

			$id=$this->limpiarCadena($_POST['usuario_id']);

			# Verificando usuario #
		    $datos=$this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id='$id'");
		    if($datos->rowCount()<=0){
		        $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No hemos encontrado el usuario en el sistema",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
		    }else{
		    	$datos=$datos->fetch();
		    }

		    # Directorio de imagenes #
    		$img_dir="../views/fotos/";

    		# Comprobar si se selecciono una imagen #
    		if($_FILES['usuario_foto']['name']=="" && $_FILES['usuario_foto']['size']<=0){
    			$alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No ha seleccionado una foto para el usuario",
					"icono"=>"error"
				];
				return json_encode($alerta);
		        exit();
    		}

    		# Creando directorio #
	        if(!file_exists($img_dir)){
	            if(!mkdir($img_dir,0777)){
	                $alerta=[
						"tipo"=>"simple",
						"titulo"=>"Ocurrió un error inesperado",
						"texto"=>"Error al crear el directorio",
						"icono"=>"error"
					];
					return json_encode($alerta);
	                exit();
	            } 
	        }

	        # Verificando formato de imagenes #
	        if(mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name'])!="image/png"){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado es de un formato no permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Verificando peso de imagen #
	        if(($_FILES['usuario_foto']['size']/1024)>5120){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"La imagen que ha seleccionado supera el peso permitido",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Nombre de la foto #
	        if($datos['usuario_foto']!=""){
		        $foto=explode(".", $datos['usuario_foto']);
		        $foto=$foto[0];
	        }else{
	        	$foto=str_ireplace(" ","_",$datos['usuario_usuario']);
	        	$foto=$foto."_".rand(0,100);
	        }
	        

	        # Extension de la imagen #
	        switch(mime_content_type($_FILES['usuario_foto']['tmp_name'])){
	            case 'image/jpeg':
	                $foto=$foto.".jpg";
	            break;
	            case 'image/png':
	                $foto=$foto.".png";
	            break;
	        }

	        chmod($img_dir,0777);

	        # Moviendo imagen al directorio #
	        if(!move_uploaded_file($_FILES['usuario_foto']['tmp_name'],$img_dir.$foto)){
	            $alerta=[
					"tipo"=>"simple",
					"titulo"=>"Ocurrió un error inesperado",
					"texto"=>"No podemos subir la imagen al sistema en este momento",
					"icono"=>"error"
				];
				return json_encode($alerta);
	            exit();
	        }

	        # Eliminando imagen anterior #
	        if(is_file($img_dir.$datos['usuario_foto']) && $datos['usuario_foto']!=$foto){
		        chmod($img_dir.$datos['usuario_foto'], 0777);
		        unlink($img_dir.$datos['usuario_foto']);
		    }

		    $usuario_datos_up=[
				[
					"campo_nombre"=>"usuario_foto",
					"campo_marcador"=>":Foto",
					"campo_valor"=>$foto
				],
				[
					"campo_nombre"=>"usuario_actualizado",
					"campo_marcador"=>":Actualizado",
					"campo_valor"=>date("Y-m-d H:i:s")
				]
			];

			$condicion=[
				"condicion_campo"=>"usuario_id",
				"condicion_marcador"=>":ID",
				"condicion_valor"=>$id
			];

			if($this->actualizarDatos("usuario",$usuario_datos_up,$condicion)){

				if($id==$_SESSION['id']){
					$_SESSION['foto']=$foto;
				}

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"La foto del usuario ".$datos['usuario_usuario']." se actualizo correctamente",
					"icono"=>"success"
				];
			}else{

				$alerta=[
					"tipo"=>"recargar",
					"titulo"=>"Foto actualizada",
					"texto"=>"No hemos podido actualizar algunos datos del usuario ".$datos['usuario_usuario'].", sin embargo la foto ha sido actualizada",
					"icono"=>"warning"
				];
			}

			return json_encode($alerta);
		}

	}