<?php

namespace app\models;

use \PDO;

if (file_exists(__DIR__ . "/../../config/server.php")) {
	require_once __DIR__ . "/../../config/server.php";
}

class mainModel
{

	private $server = DB_SERVER;
	private $db = DB_NAME;
	private $user = DB_USER;
	private $pass = DB_PASS;


	/*----------  Funcion conectar a BD  ----------*/
	protected function conectar()
	{
		try {
			$conexion = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db, $this->user, $this->pass);
			$conexion->exec("SET CHARACTER SET utf8");
			return $conexion;
		} catch (\PDOException $e) {
			// Manejar la excepción, puedes imprimir un mensaje o registrar el error en un archivo de registro
			die("Error de conexión: " . $e->getMessage());
		}
	}


	/*----------  Funcion ejecutar consultas  ----------*/
	protected function ejecutarConsulta($consulta)
	{
		$sql = $this->conectar()->prepare($consulta);
		$sql->execute();
		return $sql;
	}



	/*----------  Funcion limpiar cadenas  ----------*/
	public function limpiarCadena($cadena) {
		$cadena = trim($cadena);
		$cadena = stripslashes($cadena);
		$cadena = htmlspecialchars($cadena);
		return $cadena;
	}
	

	/*---------- Funcion verificar datos (expresion regular) ----------*/
	protected function verificarDatos($filtro, $cadena)
	{
		if (preg_match("/^" . $filtro . "$/", $cadena)) {
			return false;
		} else {
			return true;
		}
	}

	/*----------  Funcion para ejecutar una consulta INSERT preparada  ----------*/
	protected function guardarDatos($tabla, $datos)
	{

		$query = "INSERT INTO $tabla (";

		$C = 0;
		foreach ($datos as $clave) {
			if ($C >= 1) {
				$query .= ",";
			}
			$query .= $clave["campo_nombre"];
			$C++;
		}

		$query .= ") VALUES(";

		$C = 0;
		foreach ($datos as $clave) {
			if ($C >= 1) {
				$query .= ",";
			}
			$query .= $clave["campo_marcador"];
			$C++;
		}

		$query .= ")";
		$sql = $this->conectar()->prepare($query);

		foreach ($datos as $clave) {
			$sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
		}

		$sql->execute();

		return $sql;
	}


	protected function guardarDatos2($tabla, $datos)
	{
		$conexion = $this->conectar();
		$conexion->beginTransaction(); // Inicia la transacción

		try {
			$query = "INSERT INTO $tabla (";
			$query .= implode(", ", array_column($datos, "campo_nombre"));
			$query .= ") VALUES (";
			$query .= implode(", ", array_column($datos, "campo_marcador"));
			$query .= ")";

			$sql = $conexion->prepare($query);

			foreach ($datos as $clave) {
				$sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
			}

			$sql->execute();
			$lastInsertId = $conexion->lastInsertId();
			$conexion->commit(); // Confirma la transacción

			return ['success' => true, 'lastInsertId' => $lastInsertId];
		} catch (\PDOException $e) {
			$conexion->rollBack(); // Revierte la transacción
			// Manejar el error de SQL de manera adecuada

			die("Error de SQL al guardar datos: " . $e->getMessage());
		}
	}



	public function ultimoIdInsertado()
	{
		$conexion = $this->conectar();
		return $conexion->lastInsertId();
	}

	/*---------- Funcion seleccionar datos ----------*/
	public function seleccionarDatos($tipo, $tabla, $campo, $id)
	{
		$tipo = $this->limpiarCadena($tipo);
		$tabla = $this->limpiarCadena($tabla);
		$campo = $this->limpiarCadena($campo);
		$id = $this->limpiarCadena($id);

		if ($tipo == "Unico") {
			$sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
			$sql->bindParam(":ID", $id);
		} elseif ($tipo == "Normal") {
			$sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
		}
		$sql->execute();

		return $sql;
	}


	public function seleccionarDatos2($tipo, $tabla, $campo, $id)
	{
		$tipo = $this->limpiarCadena($tipo);
		$tabla = $this->limpiarCadena($tabla);
		$campo = $this->limpiarCadena($campo);
		$id = $this->limpiarCadena($id);

		if ($tipo == "Unico") {
			$sql = $this->conectar()->prepare("
					SELECT p.*, sa.stock, sa.id_almacen, a.nombre_almacen 
					FROM productos AS p
					LEFT JOIN stock_almacen AS sa ON p.id_producto = sa.id_producto
					LEFT JOIN almacenes AS a ON sa.id_almacen = a.id_almacen
					WHERE p.$campo = :ID
				");
			$sql->bindParam(":ID", $id);
		} elseif ($tipo == "Normal") {
			$sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
		}
		$sql->execute();
		return $sql;
	}



	/*----------  Funcion para ejecutar una consulta UPDATE preparada  ----------*/
	protected function actualizarDatos($tabla, $datos, $condicion)
	{

		$query = "UPDATE $tabla SET ";

		$C = 0;
		foreach ($datos as $clave) {
			if ($C >= 1) {
				$query .= ",";
			}
			$query .= $clave["campo_nombre"] . "=" . $clave["campo_marcador"];
			$C++;
		}

		$query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];

		$sql = $this->conectar()->prepare($query);

		foreach ($datos as $clave) {
			$sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
		}

		$sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

		$sql->execute();

		return $sql;
	}




	/*---------- Funcion eliminar registro ----------*/
	protected function eliminarRegistro($tabla, $campo, $id)
	{
		$sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
		$sql->bindParam(":id", $id);
		$sql->execute();

		return $sql;
	}


	protected function paginadorTablas($pagina, $numeroPaginas, $url)
	{
		$tabla = '<nav aria-label="Page navigation example"><ul class="pagination">';

		// Enlace a la página anterior
		if ($pagina > 1) {
			$tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina - 1) . '/">Anterior</a></li>';
		} else {
			$tabla .= '<li class="page-item disabled"><span class="page-link">Anterior</span></li>';
		}

		// Generar enlaces para todas las páginas
		for ($i = 1; $i <= $numeroPaginas; $i++) {
			if ($pagina == $i) {
				$tabla .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
			} else {
				$tabla .= '<li class="page-item"><a class="page-link" href="' . $url . $i . '/">' . $i . '</a></li>';
			}
		}

		// Enlace a la página siguiente
		if ($pagina < $numeroPaginas) {
			$tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina + 1) . '/">Siguiente</a></li>';
		} else {
			$tabla .= '<li class="page-item disabled"><span class="page-link">Siguiente</span></li>';
		}

		$tabla .= '</ul></nav>';
		return $tabla;
	}


	// Método para obtener el stock actual de un producto en un almacén específico
	public function obtenerStock($id_producto, $id_almacen)
	{
		$consulta = "SELECT stock FROM stock_almacen WHERE id_producto=:id_producto AND id_almacen=:id_almacen";
		$sql = $this->conectar()->prepare($consulta);
		$sql->bindParam(":id_producto", $id_producto);
		$sql->bindParam(":id_almacen", $id_almacen);
		$sql->execute();
		return $sql->fetch(PDO::FETCH_ASSOC); // Retorna el stock actual o false si no hay datos
	}

	// Método para actualizar el stock de un producto en un almacén específico
	// Método para actualizar el stock de un producto en un almacén específico
	/*
public function actualizarStock($id_producto, $id_almacen, $nuevo_stock)
{
    $consulta = "UPDATE stock_almacen SET stock = :nuevo_stock WHERE id_producto = :id_producto AND id_almacen = :id_almacen";
    $stmt = $this->conectar()->prepare($consulta);
    $stmt->bindParam(":nuevo_stock", $nuevo_stock);
    $stmt->bindParam(":id_producto", $id_producto);
    $stmt->bindParam(":id_almacen", $id_almacen);
    return $stmt->execute(); // Retorna true si la actualización fue exitosa, false en caso contrario
}*/


protected function beginTransaction() {
    return $this->conectar()->beginTransaction();
}

protected function commit() {
    return $this->conectar()->commit();
}

protected function rollBack() {
    return $this->conectar()->rollBack();
}




}