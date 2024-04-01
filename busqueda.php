<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Buscador</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<!-- ESTILOS -->
		<link rel="stylesheet" href="app/views/css/bootstrap.min.css">
		<!-- SCRIPTS JS-->
		<script src="app/views/js/jquery-3.1.1.min.js"></script>
		<script src="peticion.js"></script>
		<style>
			body {
				background-color: #343a40;
				color: #fff;
			}
			.container {
				margin: 20px auto;
			}
			table .table{
				background-color: #6c757d;
				border-radius: 5px;
			}
			th, td {
				color: #fff;
				text-align: left; /* Alinea el texto a la izquierda */
			}
		</style>
	</head>
	<body>

		<div class="container text-center">
			<header>
				<div class="alert alert-dark">
				<h2>Buscar artículos</h2>
				</div>
			</header>

			<!-- Botón para regresar a la página anterior -->
			<button onclick="history.back()" class="btn btn-light mb-3">Regresar</button>

			<button class="btn btn-primary mb-3" onclick="imprimirArea('areaImprimir')">Imprimir</button>

			<section>
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar..." class="form-control bg-dark text-white mb-3">
			</section>
			<div id="areaImprimir">
			<section id="tabla_resultado">
			<!-- AQUI SE DESPLEGARA NUESTRA TABLA DE CONSULTA -->
			</section>
			</div>
		</div>

	</body>
	<script>

function imprimirArea(id) {
    var contenido = document.getElementById(id).innerHTML;
    var ventanaImpresion = window.open("", "_blank");
    ventanaImpresion.document.write("<html><head><title>Imprimir</title>");
    
    // Aquí puedes agregar tus archivos CSS externos
    ventanaImpresion.document.write('<link rel="stylesheet" href="app/views/css/bootstrap.min.css">');
    
    // Y también puedes agregar tus estilos CSS personalizados
    ventanaImpresion.document.write("<style>");
    ventanaImpresion.document.write("body { font-family: Arial, sans-serif; line-height: 1; }");
    ventanaImpresion.document.write("</style>");
    
    ventanaImpresion.document.write("</head><body>");
    ventanaImpresion.document.write(contenido);
    ventanaImpresion.document.write("</body></html>");
    ventanaImpresion.document.close();
    ventanaImpresion.print();
}


	</script>
</html>
