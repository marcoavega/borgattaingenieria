<!-- Establece el conjunto de caracteres para la página web a UTF-8, que incluye la mayoría de los caracteres de todos los idiomas escritos y es el conjunto de caracteres recomendado para todas las páginas web modernas -->
<meta charset="UTF-8">

<!-- Establece el modo de compatibilidad de Internet Explorer a la versión más reciente disponible -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Establece el ancho de la vista de la página al ancho del dispositivo y la escala inicial al 100%. Esto es importante para la correcta visualización en dispositivos móviles y para el correcto funcionamiento del diseño responsive -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Establece el título de la página al valor de la constante APP_NAME -->
<title><?php echo APP_NAME; ?></title>

<!-- Enlaza el archivo CSS de Bootstrap, que es un marco de trabajo para el diseño de sitios y aplicaciones web -->
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/bootstrap.min.css">

<!-- Enlaza el archivo CSS personalizado 'estilos.css' -->
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/estilos.css">

<!-- Enlaza el archivo CSS de SweetAlert2, que es una biblioteca para mostrar alertas bonitas y personalizadas -->
<link rel="stylesheet" href="<?php echo APP_URL; ?>app/views/css/sweetalert2.min.css">

<!-- Enlaza el archivo JavaScript de SweetAlert2 -->
<script src="<?php echo APP_URL; ?>app/views/js/sweetalert2.all.min.js" ></script>

<!-- Enlaza el archivo JavaScript 'index.js' personalizado -->
<script src="<?php echo APP_URL; ?>app/views/js/index.js" ></script>

<script src="<?php echo APP_URL; ?>app/views/js/jquery-3.1.1.min.js" ></script>

<link rel="icon" href="<?php echo APP_URL; ?>app/views/img/logo.ico" type="image/x-icon">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bakbak+One&family=Lilita+One&family=Orbitron:wght@400..900&family=Russo+One&display=swap" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
