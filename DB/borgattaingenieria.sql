-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-04-2024 a las 04:55:29
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `borgattaingenieria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id_almacen` int(11) NOT NULL,
  `nombre_almacen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id_almacen`, `nombre_almacen`) VALUES
(1, 'Almacen General'),
(2, 'Almacen de Maquinado'),
(3, 'Almacen de Ensamble');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id_area`, `nombre_area`) VALUES
(1, 'MAQUINADOS'),
(2, 'ENSAMBLE'),
(3, 'ALMACEN'),
(4, 'ADMINSTRACION'),
(5, 'GERENCIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Herramientas generales'),
(2, 'Insumos consumibles'),
(3, 'Herramientas maquinados'),
(4, 'Papelería'),
(5, 'Tlapaleria'),
(6, 'Materia prima maquinado'),
(8, 'Piezas para kit de articulador maquinadas'),
(9, 'Piezas para kit de articulador'),
(10, 'Compras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cpi_art_af`
--

CREATE TABLE `cpi_art_af` (
  `id_cpi_art_af` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cpi_art_af`
--

INSERT INTO `cpi_art_af` (`id_cpi_art_af`, `nombre`, `descripcion`) VALUES
(1, 'CPI', 'Dispositivo medico dental CPI'),
(2, 'ARTICULADOR', 'Dispositivo medico dental ARTICULADOR'),
(3, 'ARCO FACIAL', 'Dispositivo medico dental ARCO FACIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_compra`
--

CREATE TABLE `detalle_orden_compra` (
  `id_detalle_orden` int(11) NOT NULL,
  `id_orden_compra` int(11) DEFAULT NULL,
  `numero_partida` int(11) DEFAULT NULL,
  `nombre_producto` varchar(1000) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_unidad` int(11) NOT NULL,
  `precio_sin_IVA` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_orden_compra`
--

INSERT INTO `detalle_orden_compra` (`id_detalle_orden`, `id_orden_compra`, `numero_partida`, `nombre_producto`, `cantidad`, `id_unidad`, `precio_sin_IVA`, `total`) VALUES
(1, 1, 1, 'uno', 5, 1, 20.00, 100.00),
(3, 2, 1, 'unoss', 4, 1, 25.00, 100.00),
(4, 1, 2, 'Broca serie extra larga con zanco cilíndrico, diámetro 0.1252\" 1/8 con longitudtotal de 160mm y longitud de filo de 100mm según norma BS 328 con puntacónica 118°, HSS con acabado vaporizado y hélice normal 10xD para aladradosin picado, MCA.DORMER', 5, 1, 3563.00, 17815.00),
(5, 4, 1, 'machuelo', 3, 1, 500.00, 1500.00),
(6, 5, 1, 'RETAZO DE TRAPO BLANCO (GRANDE)', 20, 2, 95.00, 1900.00),
(7, 5, 2, 'GASOLINA BLANCA', 20, 7, 90.00, 1800.00),
(8, 5, 3, 'AIP', 20, 7, 90.00, 1800.00),
(9, 5, 4, 'THINNER', 20, 7, 70.00, 1400.00),
(10, 6, 1, 'CORTADOR RECTO DE CARBURO 1/8\" 4 FL ESTANDAR', 2, 1, 280.00, 560.00),
(11, 6, 2, 'CORTADOR RECTO DE CARBURO 1/8\" 4 FL LARGO', 1, 1, 716.80, 716.80),
(12, 6, 3, 'BOQUILLA ER32 1/8\"', 2, 1, 539.00, 1078.00),
(13, 6, 4, 'BOQUILLA ER40 1/8\"', 1, 1, 580.00, 580.00),
(14, 7, 1, 'VASTAGO MITUTOYO AM GAGE Marca Mitutoyo, VASTAGO C/TUERCA\r\nD8, PARA INDICADOR.', 2, 1, 97.50, 195.00),
(15, 7, 2, '9437925KL25SW7 BROCA DE CENTROS N1', 5, 1, 6.42, 32.10),
(16, 7, 3, '3KL792579SRHG4 MACHUELO HELICOIDAL 1/8-40', 5, 1, 50.82, 254.10),
(17, 7, 4, 'ASRHG434343KLB BROCA HSS NUMERICA 37 ', 12, 1, 2.19, 26.28),
(18, 7, 5, 'R79792579SRMMS BROCA HSS NUMERICA 38 ', 12, 1, 2.19, 26.28),
(19, 8, 1, 'FABRICACION DE HERRAMIENTAS DE CARBURO PARA CHAMFER MEDIANTE AFILADORA UNIVERSAL  A 45°', 5, 1, 1200.00, 6000.00),
(20, 9, 1, 'M-33X Cinta de aislar 19 mm x 18 m', 5, 1, 18.97, 94.85),
(21, 9, 2, 'DR-1/4X6TP Desarmador mango transparente', 1, 1, 29.31, 29.31),
(22, 9, 3, 'DR-5/16X6TP Desarmador mango transparent', 1, 1, 42.24, 42.24),
(23, 9, 4, 'DP-1/8X6 Desarmador phillips de 1/8\"', 1, 1, 33.62, 33.62),
(24, 9, 5, 'DP-3/16X6 Desarmador phillips de 3/16\"', 1, 1, 42.24, 42.24),
(25, 9, 6, 'DP-1/4X6 Desarmador phillips de 1/4\"', 1, 1, 50.86, 50.86),
(26, 9, 7, 'E-8X12 Escuadra cantero profesional 8\"', 1, 1, 59.49, 59.49),
(27, 9, 8, 'CTR-150 Cinta transparente de 48 mm x 15M', 2, 1, 50.86, 101.72),
(28, 9, 9, 'CIN-1810N Cinchos negros de plástico en bolsa de 100 piezas', 4, 1, 14.65, 58.60),
(29, 9, 10, 'LIME-120 Lija de esmeril grano 120', 10, 1, 11.21, 112.10),
(30, 9, 11, 'LIME-80 Lija de esmeril grano 80', 4, 1, 12.50, 50.00),
(31, 9, 12, 'LIMER-120 Lija de esmeril grano 120 roja', 10, 1, 13.36, 133.60),
(32, 9, 13, 'LIMER-100 Lija de esmeril grano 100 ', 5, 1, 13.36, 66.80),
(33, 9, 14, 'LIAG-600 Lija de agua grano 600', 7, 1, 7.33, 51.31),
(34, 9, 15, 'LIAG-240 Lija de agua grano 240', 6, 1, 7.33, 43.98),
(35, 9, 16, 'LIAG-180 Lija de agua grano 180', 8, 1, 7.33, 58.64),
(37, 10, 1, 'Extensión reforzada aterrizada 8 m 3x14 AWG, Volteck', 1, 1, 219.82, 219.82),
(38, 10, 2, 'Extensión reforzada aterrizada 4 m 3x14 AWG, Volteck', 1, 1, 107.75, 107.75),
(39, 10, 3, 'Pinza de presión 9\", punta larga, Truper', 1, 1, 139.65, 139.65),
(40, 10, 4, 'Lima redonda muza 8\", Truper', 2, 1, 38.79, 77.58),
(41, 10, 5, 'Lima redonda muza 10\", Truper', 1, 1, 53.44, 53.44),
(42, 10, 6, 'Lima media caña muzas 8\", Truper', 1, 1, 62.06, 62.06),
(43, 10, 7, 'Lima media caña muzas 10\", Truper', 1, 1, 111.20, 111.20),
(44, 10, 8, 'Cinta de empaque 48 mm x 150 m transparente, Pretul', 6, 1, 37.93, 227.58),
(45, 10, 9, 'Pinza punta recta 7\" para abrir anillos, mango de PVC', 1, 1, 171.55, 171.55),
(46, 10, 10, 'Lija de agua grano 240 de carburo de silicio, Truper', 6, 1, 7.32, 43.92),
(47, 10, 11, 'Lija de agua grano 120 de carburo de silicio, Truper', 5, 1, 7.75, 38.75),
(48, 10, 12, 'Lija de agua grano 280 de carburo de silicio, Truper', 4, 1, 7.32, 29.28),
(49, 11, 1, 'LIGAS DE NITRILO DE 3/32 FABRICACION ESPECIAL', 1000, 1, 5.50, 5500.00),
(50, 12, 1, 'MACHUELO HELICOIDAL 3/8\" X 24 ', 2, 1, 680.00, 1360.00),
(51, 13, 112116, 'Fresa de punta esférica, 2 canales, diámetro corte 1/16\", longitud de corte 1/4\", longitud total 1-1/2\", radio completo 1/32\", zanco cilíndrico 1/8\", metal duro en acabado brillante, hélice 30°, fresado en copia en acero, inoxidable, cobre, no ferrosos, MCA. DORMER.', 5, 1, 19.50, 97.50),
(52, 14, 1, 'MACHUELO HEMICOIDAL M4 x 0.7 ROYCO', 3, 1, 769.50, 2308.50),
(53, 15, 1, 'Cortador largo, 4 gavilanes, diámetro corte 3/8\", longitud de corte 1\", longitud total 4\", longitud zanco reducido 1-3/8\", CARBURO, hélice 30°, para fresado profundo.', 4, 1, 124.50, 498.00),
(54, 15, 2, 'Cortador largo, 4 gavilanes, diámetro corte 1/4\", longitud de corte 1\", longitud total 4\", longitud zanco reducido 1-1/4\", CARBURO, hélice 30°, para fresado profundo.', 4, 1, 89.50, 358.00),
(55, 16, 4, 'MACHUELO HSS 1/8-40 ROYCO ', 10, 1, 154.00, 1540.00),
(56, 17, 1, 'TUBO ACERO INOX CAL 20 C/C DE 1/4\" x 6 MTS', 3, 1, 490.00, 1470.00),
(57, 18, 1, 'Barra de acero inoxidable 316 de 1-1/8\" x 1 M', 1, 3, 170.00, 170.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_gasto`
--

CREATE TABLE `detalle_orden_gasto` (
  `id_detalle_orden` int(11) NOT NULL,
  `id_orden_gasto` int(11) NOT NULL,
  `numero_partida` int(11) NOT NULL,
  `nombre_producto` varchar(1000) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `precio_sin_IVA` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden_gasto`
--

INSERT INTO `detalle_orden_gasto` (`id_detalle_orden`, `id_orden_gasto`, `numero_partida`, `nombre_producto`, `cantidad`, `id_unidad`, `precio_sin_IVA`, `total`) VALUES
(1, 1, 1, 'aaaaa', 2, 1, 2.00, 4.00),
(2, 2, 3, 'REFRACTOMETRO ANALOGO MARCA ARIANA, 0-32%, PARA LA DETERMINACION RAPIDA Y EXACTA DE CONCENTRACION DE EMULSIONES.', 1, 1, 150.87, 150.87);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre_empleado` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre_empleado`, `puesto`, `area`) VALUES
(1, 'FRANCISCO LAGUNA', 'SUPERVISOR ENSABLE', 2),
(2, 'EDGAR', 'AUXILIAR TECNICO', 2),
(3, 'ANTONIO SANTOS ESQUIVEL', 'GARANTIAS Y REPARACIONES', 2),
(4, 'FRANCISCO JAVIER', 'DISEÑADOR', 2),
(5, 'MARCO A. VEGA G.', 'AUXILIAR ADMINISTRATIVO', 2),
(6, 'MARCELO MOJICA', 'GERENTE DE PLANTA', 5),
(7, 'ALEJANDRO ', 'AUXILIAR MAQUINADOS', 1),
(8, 'JONATHAN', 'AUXILIAR MAQUINADOS', 1),
(9, 'ABRAHAM VILLEGAS', 'SUPERVISOR, AUX.', 1),
(10, 'LUIS ANTONIO', 'SUPERVISOR MAQUINADOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_almacen_origen` int(11) NOT NULL,
  `id_almacen_destino` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `nota_movimiento` text NOT NULL,
  `fecha_movimiento` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_movimiento`, `id_producto`, `id_almacen_origen`, `id_almacen_destino`, `cantidad`, `id_empleado`, `nota_movimiento`, `fecha_movimiento`) VALUES
(27, 342, 1, 2, 1, 9, 'Herramienta requerida', '2024-01-18'),
(28, 341, 1, 2, 10, 9, 'Herramienta requerida', '2024-01-18'),
(29, 366, 1, 2, 1, 9, 'Herramienta requerida', '2024-01-18'),
(30, 369, 1, 1, 1, 9, 'Herramienta requerida', '2024-01-18'),
(31, 369, 1, 2, 1, 9, 'Se requiere en maquinados', '2024-01-18'),
(32, 359, 1, 2, 2, 9, 'Se requirió en maquinados', '2024-01-18'),
(33, 352, 1, 2, 2, 9, 'Se requiere en maquinados', '2024-01-18'),
(34, 179, 1, 3, 1, 9, 'Se requiere en ensable', '2024-01-18'),
(35, 376, 2, 1, 15, 9, 'Abraham entrega al almacen general', '2024-01-18'),
(36, 377, 2, 3, 21, 9, 'Abraham entrega a francisco', '2024-01-18'),
(37, 311, 2, 1, 15, 9, 'Abraham entrega al almacen general', '2024-01-18'),
(38, 198, 1, 3, 1, 9, 'Se entregan tijeras a Francisco L. para su área', '2024-01-22'),
(39, 368, 1, 2, 1, 9, 'Se necesita en el área', '2024-01-23'),
(40, 375, 1, 2, 1, 9, 'Se entrega a Abraham', '2024-01-23'),
(41, 247, 2, 3, 33, 9, 'Maquinados entrega a Francios L. 33 condilos directamente', '2024-01-23'),
(42, 378, 2, 3, 21, 9, 'Maquinados entrega a Francisco laguna 21 bases superiores CPI', '2024-01-23'),
(43, 356, 1, 3, 4, 9, 'Se entregan a el area de ensamble los bastidores que se tenian resguardados 4 pzas. mas las 16 de ensamble.', '2024-01-24'),
(44, 351, 1, 3, 19, 9, 'Se entregan pernos a Francisco laguna', '2024-01-24'),
(45, 350, 1, 3, 19, 9, 'Se entregan pernos a Francisco laguna', '2024-01-24'),
(46, 359, 1, 3, 38, 9, 'Se entregan a Francisco L.', '2024-01-24'),
(47, 352, 1, 3, 36, 9, 'Se entregan a Francisco L.', '2024-01-24'),
(48, 379, 2, 3, 47, 9, 'Maquinado le entrega a ensamble 47 pzas. de perno de posicion', '2024-01-24'),
(49, 376, 1, 3, 16, 9, 'Se entregan al area de ensamble', '2024-01-24'),
(50, 311, 1, 3, 15, 9, 'Se entregan al area de ensamble', '2024-01-24'),
(51, 260, 1, 3, 20, 9, 'Se entregan al area de ensamble', '2024-01-24'),
(52, 261, 1, 3, 27, 9, 'Se entregan al area de ensamble', '2024-01-24'),
(53, 245, 1, 3, 6, 9, 'Se entregan al area de ensamble', '2024-01-24'),
(54, 306, 1, 3, 24, 9, 'Se entregan al area de ensamble', '2024-01-24'),
(55, 375, 1, 2, 1, 9, 'Se entrega a jonathan', '2024-01-26'),
(56, 367, 1, 2, 1, 9, 'Se entrega a Abraham', '2024-01-29'),
(57, 369, 1, 2, 1, 9, 'SE ENTREGA MACHUELO A ABRAHAM', '2024-02-02'),
(58, 367, 1, 2, 1, 9, 'SE ENTREGA A ABRAHAM VILLEGAS, PARA SU USO EN MAQUINADOS', '2024-02-06'),
(59, 400, 1, 2, 1, 9, 'SE ENTREGA A JONATHAN', '2024-02-08'),
(60, 368, 1, 2, 1, 9, 'SE ENTREGA A JONATHAN', '2024-02-08'),
(61, 353, 1, 3, 2, 9, 'SE ENTREGAN DOS IMANES CUADRADOS A JAVIER PARA PRUEBAS', '2024-02-08'),
(62, 304, 1, 2, 2, 9, 'se entrega a maquinados', '2024-02-14'),
(63, 401, 1, 2, 2, 9, 'se entregan a maquinados, francisco laguna entrega', '2024-02-14'),
(64, 60, 1, 2, 1, 8, 'Se entrega para area de maquinados.', '2024-02-15'),
(65, 407, 1, 2, 1, 8, 'se entrega llave torx ', '2024-02-22'),
(66, 408, 1, 2, 1, 8, 'se entrega llave', '2024-02-22'),
(67, 353, 1, 3, 2, 1, 'Se entregan para pruebas', '2024-02-26'),
(68, 358, 1, 2, 1, 7, 'Se entrega para pruebas de porta iman', '2024-02-26'),
(69, 410, 1, 2, 1, 10, 'Se entrega para el area', '2024-02-27'),
(70, 84, 1, 2, 5, 8, 'Se entrega para el area.', '2024-02-29'),
(71, 366, 1, 2, 1, 9, 'Se entrega a Abraham', '2024-03-12'),
(72, 166, 1, 2, 1, 9, 'Se entrega a Abraham', '2024-03-12'),
(73, 367, 1, 2, 1, 9, 'Se entrega a Abraham', '2024-03-12'),
(79, 424, 1, 3, 1, 1, 'se utiliza', '2024-03-28'),
(80, 424, 1, 3, 2, 4, 'ensamble', '2024-03-28'),
(81, 420, 1, 2, 2, 10, 'se quedan en el área de maquinado', '2024-03-30'),
(82, 419, 1, 2, 2, 10, 'se quedan en área de maquinados', '2024-03-30'),
(83, 171, 1, 2, 1, 9, 'se usa para calibrador', '2024-04-02'),
(84, 171, 2, 1, 1, 9, 'Se regresa la pila al almacen genera lo que falla es el calibrador', '2024-04-02'),
(85, 372, 1, 2, 1, 9, 'se requiere en area', '2024-04-02'),
(86, 315, 1, 2, 2, 9, 'se requiere en area', '2024-04-02'),
(87, 199, 1, 2, 1, 9, 'SE NECESITA EN AREA', '2024-04-03'),
(88, 430, 1, 2, 1, 8, 'Se requiere en el area', '2024-04-05'),
(89, 374, 1, 2, 1, 8, 'Se requiere en area', '2024-04-05'),
(90, 404, 1, 2, 1, 9, 'Se requiere en area', '2024-04-05'),
(91, 347, 1, 2, 1, 10, 'SE REQUIERE EN EL AREA', '2024-04-05'),
(92, 191, 1, 2, 1, 8, 'Se utiliza en area', '2024-04-07'),
(93, 369, 1, 2, 1, 8, 'se requiere en maquinados', '2024-04-09'),
(94, 285, 1, 2, 1, 8, 'Lo solicita Jonathan', '2024-04-12'),
(95, 458, 1, 3, 1, 1, 'Solicitada en el area de ensamble', '2024-04-15'),
(96, 450, 1, 2, 1, 8, 'REEMPLAZO DE GUANTES', '2024-04-15'),
(97, 352, 3, 1, 36, 5, 'CONTEO DE INVENTARIO', '2024-04-15'),
(98, 352, 2, 1, 4, 5, 'CONTEO DE INVENTARIO', '2024-04-15'),
(99, 183, 1, 2, 1, 8, 'SE ENTREGA PARA USO', '2024-04-16'),
(100, 482, 1, 3, 1, 1, 'SE REQUIERE EN EL AREA DE ENSAMBLE', '2024-04-16'),
(101, 264, 1, 3, 42, 1, 'SE REQUIEREN PARA ENSAMBLE DE LOS 5 ARTICULADORES DE ABRIL', '2024-04-16'),
(102, 483, 1, 3, 19, 1, 'SE DAN A ENSAMBLE UNA SE UTILIZO YA EN EL EQUIPO PARA MERCADOTECNIA', '2024-04-16'),
(103, 485, 1, 2, 1, 9, 'SE ENTREGO PARA SOLDAR', '2024-04-16'),
(104, 486, 1, 2, 1, 9, 'SE ENTREGA PARA SOLDAR', '2024-04-16'),
(105, 487, 1, 3, 20, 1, 'SE QUEDAN EN EL AREA DE ENSAMBLE', '2024-04-16'),
(106, 295, 1, 3, 1, 1, 'SE REQUIERE EN EL AREA', '2024-04-16'),
(107, 367, 1, 2, 2, 9, 'SE NECESITA EN EL AREA', '2024-04-16'),
(108, 259, 1, 3, 82, 1, 'PARA ARMADO DE 20 ARTICULADORES', '2024-04-16'),
(109, 472, 1, 3, 5, 2, 'SE ENTREGAN PARA EL ARMADO DE LOS 5 CPI', '2024-04-17'),
(110, 353, 1, 3, 5, 1, 'NECESARIOS PARA EL ARMADO DE ARTICULADOR', '2024-04-17'),
(111, 473, 1, 3, 10, 1, 'PARA ENSAMBLE DE 5 ARTICULADORES', '2024-04-17'),
(112, 477, 1, 3, 1, 1, 'SE USA EN EQUIPO PARA MARKETING', '2024-04-17'),
(113, 478, 1, 3, 1, 1, 'SE UTILIZA EN EQUIPO PARA MARKETING', '2024-04-17'),
(114, 491, 1, 2, 8, 10, 'SE ENTREGAN PARA FABRICACION DE PERNOS DE POSICION', '2024-04-17'),
(115, 204, 1, 3, 1, 3, 'LA SOLICITA PARA QUITAR PERNOS DE PANTALLA', '2024-04-17'),
(116, 492, 1, 3, 24, 1, 'SE ENTREGAN PARA ARMANDO DE ARTICULADORES', '2024-04-17'),
(117, 493, 1, 3, 22, 1, 'SE UTILIZAN EN ENSAMBLE', '2024-04-17'),
(118, 494, 1, 3, 72, 1, 'SE ENCUENTRAN UNIDOS A LOS SOPORTES', '2024-04-17'),
(119, 358, 1, 3, 1, 4, 'SE ENTREGA PARA ARMADO DE PIEZA SOLICITADA POR CINDY', '2024-04-17'),
(120, 358, 1, 3, 1, 1, 'SE ENTREGA PARA ARMAR PIEZA QUE SOLICITA CINCY', '2024-04-17'),
(121, 499, 1, 3, 5, 2, 'SE ENTREGAN PARA ARMADO DE ARTICULADOR', '2024-04-17'),
(122, 501, 1, 3, 60, 1, 'SE ENTREGAN PARA ENSAMBLE', '2024-04-17'),
(123, 502, 1, 3, 60, 1, 'SE ENTREGAN PARA ARMADO', '2024-04-17'),
(124, 503, 1, 3, 5, 1, 'PARA ARMADO', '2024-04-17'),
(125, 518, 1, 2, 1, 9, 'SE UTILIZA EN EL AREA', '2024-04-19'),
(126, 510, 1, 2, 2, 8, 'Se Entrega para su uso en el area', '2024-04-22'),
(127, 397, 1, 3, 27, 1, 'Se utilizan en Armado de kits', '2024-04-22'),
(128, 510, 1, 2, 2, 8, 'Lo solicita jonathan en el area', '2024-04-22'),
(129, 396, 1, 3, 30, 1, 'Se entregan para ensamble', '2024-04-23'),
(130, 466, 1, 3, 1, 4, 'Se utiliza en el area', '2024-04-23'),
(131, 216, 1, 2, 1, 8, 'Se requiere para el area', '2024-04-23'),
(132, 474, 1, 3, 1, 1, 'PARA ENSAMBLE', '2024-04-23'),
(133, 112, 1, 2, 1, 8, 'Se utiliza en area', '2024-04-24'),
(134, 499, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(135, 473, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(136, 527, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(137, 489, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(138, 353, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(139, 474, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(140, 503, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(141, 490, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(142, 397, 1, 3, 5, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(143, 358, 1, 3, 4, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(144, 505, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(145, 475, 1, 3, 12, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(146, 352, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(147, 359, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(148, 396, 1, 3, 8, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(149, 476, 1, 3, 8, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(150, 350, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(151, 421, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(152, 507, 1, 3, 4, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(153, 472, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(154, 525, 1, 3, 8, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(155, 526, 1, 3, 4, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(156, 531, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(157, 398, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(158, 540, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(159, 541, 1, 3, 2, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(160, 423, 1, 3, 10, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(161, 484, 1, 3, 1, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(162, 422, 1, 3, 4, 1, 'para armado de kit de procedimiento', '2024-04-24'),
(163, 567, 1, 2, 1, 9, 'SE REQUIERE EN AREA', '2024-04-24'),
(164, 508, 1, 2, 1, 10, 'SE REQUIERE EN AREA', '2024-04-24'),
(165, 563, 1, 2, 1, 10, 'SE REQUIERE EN AREA', '2024-04-24'),
(166, 564, 1, 2, 1, 10, 'SE REQUIERE EN AREA', '2024-04-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compra`
--

CREATE TABLE `ordenes_compra` (
  `id_orden_compra` int(11) NOT NULL,
  `numero_orden` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT current_timestamp(),
  `id_proveedor` int(11) DEFAULT NULL,
  `id_moneda` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ordenes_compra`
--

INSERT INTO `ordenes_compra` (`id_orden_compra`, `numero_orden`, `fecha`, `id_proveedor`, `id_moneda`, `id_empleado`) VALUES
(1, 'JJHJ', '2024-02-12', 4, 1, 6),
(2, 'ROC-001', '2024-02-14', 2, 1, 6),
(3, 'ROC-002', '2024-02-16', 2, 1, 6),
(4, 'ROC-003', '2024-03-20', 2, 1, 6),
(5, 'ROC-004', '2024-04-03', 16, 1, 6),
(6, 'ROC-047', '2024-04-03', 2, 1, 6),
(7, 'ROC-048', '2024-04-11', 11, 2, 6),
(8, 'ROC-049', '2024-04-12', 18, 1, 6),
(9, 'ROC-050', '2024-04-15', 17, 1, 6),
(10, 'ROC-051', '2024-04-15', 17, 1, 6),
(11, 'ROC-052', '2024-04-16', 23, 1, 6),
(12, 'ROC-053', '2024-04-16', 2, 1, 6),
(13, 'ROC-054', '2024-04-16', 11, 2, 6),
(14, 'ROC-055', '2024-04-17', 2, 1, 6),
(15, 'ROC-056', '2024-04-17', 11, 2, 6),
(16, 'ROC-057', '2024-04-23', 2, 1, 6),
(17, 'ROC-058', '2024-04-23', 1, 1, 6),
(18, 'ROC-059', '2024-04-24', 1, 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_gasto`
--

CREATE TABLE `ordenes_gasto` (
  `id_orden_gasto` int(11) NOT NULL,
  `numero_orden` varchar(20) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `id_proveedor` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes_gasto`
--

INSERT INTO `ordenes_gasto` (`id_orden_gasto`, `numero_orden`, `fecha`, `id_proveedor`, `id_moneda`, `id_empleado`) VALUES
(1, 'ROG-001', '2024-04-23', 4, 1, 2),
(2, 'ROG-002', '2024-04-24', 11, 2, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `nombre_permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre_permiso`) VALUES
(1, 'Admin'),
(2, 'Consulta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(50) NOT NULL,
  `nombre_producto` varchar(1000) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `url_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, `precio`, `stock`, `fecha_registro`, `id_categoria`, `id_proveedor`, `id_unidad`, `id_moneda`, `url_imagen`) VALUES
(1, 'H-0001', 'Avellanador 1/4\" 1/4\"', 150.00, 6, '2024-01-08 00:00:00', 3, 2, 1, 1, 'avellanador1_4.jpg'),
(44, 'H-0002', 'Avellanador 1/2\" 3FLT 82', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652459c468854_IMG_20231009_134859_398[1].jpg'),
(45, 'H-0003', 'Boquilla ER-32', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65245e5e4adc8_IMG_20231009_135742_685[1].jpg'),
(47, 'H-0004', 'Cortador 211-270 3/4 4FL SQ EM', 980.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65245f668b348_IMG_20231009_140439_159.jpg'),
(48, 'H-0005', 'Cortador Carbice AADF \"KENNAMETAL\" 3/8 x 3/8 x 1 x 3', 700.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65245fd9ed077_IMG_20231009_135542_237.jpg'),
(49, 'H-0006', 'Cortador SA-1FM 1/4 CYL', 650.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'CORTADOR.jpg'),
(50, 'H-0007', 'Cuchilla E100 P7ACERO Y ALUMINIO', 1.00, 9, '2024-01-08 00:00:00', 3, 2, 1, 1, '652460811aecd_IMG_20231009_140404_883.jpg'),
(51, 'H-0008', 'Fresa de carburo de tungsteno clave 125 12,7 x 22,2 x 6,4 mm(1/2x7/8x1/4\")', 784.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, 'FRESA.jpg'),
(53, 'H-0009', 'FRESA DE DOBLE CORTE DE CARBURO SH-5', 784.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '652461bd30ddf_IMG_20231009_140548_946.jpg'),
(54, 'H-0010', 'Fresa de doble corte para dremel SC-42 Double cut burr', 200.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524621ebb627_IMG_20231009_140321_551.jpg'),
(55, 'H-0011', 'Tarraja 1\" M6X1', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246c8bd5430_IMG_20231009_140019_434.jpg'),
(56, 'H-0012', 'Tarraja 1\" M5X.8', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246df03f3d9_IMG_20231009_140039_500.jpg'),
(57, 'H-0013', 'Tarraja 1\" M4X7', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246e42c629b_IMG_20231009_140058_020.jpg'),
(58, 'H-0014', 'Tarraja 1\" M3X.5', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65246e9854526_IMG_20231009_140118_450.jpg'),
(59, 'H-0015', 'Machuelo Hy-Pro Helicoidal \"5303F 1/8 - 40 2B 3FL SEMICONICO', 0.00, 0, '2024-01-08 00:00:00', 0, 0, 0, 0, ''),
(60, 'H-0016', 'Machuelo OSG ROYCO 5303F 1/8 - 40 2B 3FL SEMICONICO', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652475de427e8_IMG_20231009_153018_560.jpg'),
(61, 'H-0017', 'Machuelo OSG ROYCO 5303F 3/16-24 2B 4FL SEMICONICO', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247686b6266_IMG_20231009_152858_760.jpg'),
(63, 'H-0018', 'Machuelo OSG ROYCO 142 M3X0.5 D3 2S/P PLUG', 1.00, 11, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524776535649_IMG_20231009_152807_827.jpg'),
(64, 'H-0019', 'Machuelo OSG ROYCO 5305N 10-24 2B 4FL SEMICONICO', 1.00, 9, '2024-01-08 00:00:00', 3, 2, 1, 1, '652478ecd5372_IMG_20231009_152338_555.jpg'),
(65, 'H-0020', 'Machuelo OSG ROYCO 5301N 10-24 2B 2S/P SEMICONICO', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247a0aa1a16_IMG_20231009_152338_555.jpg'),
(67, 'H-0021', 'Machuelo OSG ROYCO 5303F 1/4-20 2B 4FL SEMICONICO', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247a86be014_IMG_20231009_152858_760.jpg'),
(70, 'H-0022', 'Machuelo OSG ROYCO 5303F 3/8-16 2B 4FL SEMICONICO', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247b763dce8_IMG_20231009_152442_711.jpg'),
(71, 'H-0023', 'Machuelo OSG ROYCO M5X0.8 6H', 1.00, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247bc62733f_IMG_20231009_152701_683.jpg'),
(72, 'H-0024', 'Machuelo OSG ROYCO M6 X1 6H', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247c3f9dfa5_IMG_20231009_152645_816.jpg'),
(74, 'H-0025', 'Machuelo OSG ROYCO M4 X 0.7 6H', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247cc3dc7f0_IMG_20231009_152544_434.jpg'),
(75, 'H-0026', 'Cortador R1.5X6X4X50L', 1.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247f7a95089_IMG-20231009-WA0001.jpg'),
(76, 'H-0027', 'Cortador R1.0X4X4X50L', 1.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247f8f4de19_IMG-20231009-WA0001.jpg'),
(77, 'H-0028', 'Cortador R0.75X3X4X50L', 1.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247fa445d75_IMG-20231009-WA0001.jpg'),
(80, 'H-0029', 'Cortador R2.0X8X4X50L', 1.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '65247fda7de63_IMG-20231009-WA0001.jpg'),
(81, 'H-0030', 'Cortador R0.5X2X4X50L', 1.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524800c28db9_IMG-20231009-WA0001.jpg'),
(82, 'H-0031', 'Inserto DFT05T308HP / KC7140 / 1804829', 1.00, 20, '2024-01-08 00:00:00', 3, 2, 1, 1, '652480ee9141e_IMG_20231009_161518_511.jpg'),
(83, 'H-0032', 'Inserto KC410M / 2984054', 1.00, 15, '2024-01-08 00:00:00', 3, 2, 1, 1, '652481525eae6_IMG_20231009_161612_513.jpg'),
(84, 'H-0033', 'Inserto NT2R / KCU10 / 4175911', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652481907eff1_IMG_20231009_161713_523.jpg'),
(86, 'H-0034', 'Inserto NT3RK / KC5025 / 1795787', 1.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, '652481dc39e07_IMG_20231009_161307_339.jpg'),
(87, 'H-0035', 'Inserto CNMG090308MP / KC5010 / CNMG322MP', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524831fba5b4_IMG_20231009_164537_426.jpg'),
(88, 'H-0036', 'Inserto CNMG090308MP / CNMG322MP / KC5010', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '6524835def208_IMG_20231009_161822_013.jpg'),
(89, 'H-0037', 'Inserto A4G0205M02U02GMN / KC5025', 500.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, '652483a716952_IMG_20231009_161742_020.jpg'),
(91, 'H-0038', 'Inserto NT3R / KC5010', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652484445d5e1_IMG_20231009_165123_369.jpg'),
(92, 'H-0039', 'Broca para metal 10.00 MM', 1.00, 7, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525779ebfad1_IMG_20231010_100001_599.jpg'),
(93, 'H-0040', 'Broca para metal 17/64\"', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525785db67f9_IMG_20231010_100116_298.jpg'),
(94, 'H-0041', 'Broca para metal 1/4\"', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652578cf4aa14_IMG_20231010_100201_147.jpg'),
(95, 'H-0042', 'Broca para metal 6.35 MM', 80.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525791b1534f_IMG_20231010_100354_485.jpg'),
(96, 'H-0043', 'Broca para metal 1/2\"', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '652579aa0c56d_IMG_20231010_100433_527.jpg'),
(97, 'H-0044', 'Broca para metal 3/8\" HSS', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '652579edc8504_IMG_20231010_100541_401.jpg'),
(98, 'H-0045', 'Broca para concreto 3/8\" (10)', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257a28469e7_IMG_20231010_100557_681.jpg'),
(99, 'H-0046', 'Broca para metal 9/16\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257bf5b93cc_IMG_20231010_102027_731.jpg'),
(100, 'H-0047', 'Broca para metal 31/64\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257c3e19dfe_IMG_20231010_102050_437.jpg'),
(101, 'H-0048', 'Broca para metal 7/16\"', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257cbf1b672_IMG_20231010_102116_322.jpg'),
(102, 'H-0049', 'Broca para metal CLEVELAND 1/8\"', 1.00, 15, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257d245682b_IMG_20231010_102147_476.jpg'),
(103, 'H-0050', 'Broca para metal 2.50 MM 0.0984\"', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257d6c28af3_IMG_20231010_102225_747.jpg'),
(104, 'H-0051', 'Broca para metal 15/64\"', 1.00, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257db2b948b_IMG_20231010_102246_630.jpg'),
(105, 'H-0052', 'Broca para metal 7/64\" 0.1094\"', 1.00, 14, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257e53c347f_IMG_20231010_102607_366.jpg'),
(106, 'H-0053', 'Broca para metal 3/32\"', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257e9c98e90_IMG_20231010_102330_517.jpg'),
(107, 'H-0054', 'Broca para metal 3/16\"', 90.00, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257ed86fba6_IMG_20231010_102408_714.jpg'),
(109, 'H-0055', 'Broca para metal 4.00 MM', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257f7bdf85b_IMG_20231010_102424_168.jpg'),
(110, 'H-0056', 'Broca para metal 11/64\" 0.1719\"', 1.00, 9, '2024-01-08 00:00:00', 3, 2, 1, 1, '65257fbd8eebc_IMG_20231010_102534_809.jpg'),
(111, 'H-0057', 'Broca para metal 9/64\" 0.01406\"', 1.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258003de85c_IMG_20231010_102552_755.jpg'),
(112, 'H-0058', 'Broca para metal 1/8\"', 1.00, 8, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258044d9a12_IMG_20231010_102623_674.jpg'),
(114, 'H-0059', 'Broca para metal 5/32\" 0.1562\"', 1.00, 7, '2024-01-08 00:00:00', 3, 2, 1, 1, '652580db7f955_IMG_20231010_102641_410.jpg'),
(115, 'H-0060', 'Broca para metal 5/64\" 0.0781\"', 75.00, 15, '2024-01-08 00:00:00', 3, 2, 1, 1, '652581b01de30_IMG_20231010_102650_179.jpg'),
(116, 'H-0061', 'Broca para metal 27  0.1440\"  ', 1.00, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, '652581ffc15c7_IMG_20231010_102659_658.jpg'),
(117, 'H-0062', 'Broca para concreto 5/8\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258353be987_IMG_20231010_105534_251.jpg'),
(118, 'H-0063', 'Broca para metal 5/16\"', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '652583a12c1bc_IMG_20231010_105604_565.jpg'),
(119, 'H-0064', 'Broca para metal 13/64', 1.00, 11, '2024-01-08 00:00:00', 3, 2, 1, 1, '652583e7491b3_IMG_20231010_105626_665.jpg'),
(120, 'H-0065', 'Broca para metal 7/8\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525842fa53a5_IMG_20231010_105659_302.jpg'),
(121, 'H-0066', 'Broca para metal 3/4\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '652584603c277_IMG_20231010_105722_077.jpg'),
(122, 'H-0067', 'Broca para metal 12.50 MM', 1.00, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, '652584a152913_IMG_20231010_105753_757.jpg'),
(123, 'H-0068', 'Pernos para torno 5/16\"', 1.00, 14, '2024-01-08 00:00:00', 3, 2, 1, 1, '6525889da04c5_IMG_20231010_111900_825.jpg'),
(124, 'H-0069', 'Rima CLEVELAND 3/8\"', 1.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258909e297e_IMG_20231010_111931_604.jpg'),
(125, 'H-0070', 'Rima Fenes 3/8\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258952c5e06_IMG_20231010_112035_863.jpg'),
(126, 'H-0071', 'Rima Fenes 1/2\"', 1.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, '65258999e1c99_IMG_20231010_112058_508.jpg'),
(127, 'H-0072', 'Pistola de silicón Grande', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258d9f1b792_IMG_20231010_113034_246.jpg'),
(128, 'I-0001', 'Barras de silicón 1/2\"', 1.00, 34, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258df2a32fc_IMG_20231010_113138_143.jpg'),
(129, 'I-0002', 'Lentes  de seguridad FOY Ambar', 1.00, 16, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258e42dfb13_IMG_20231010_113233_881.jpg'),
(130, 'I-0003', 'Lentes de seguridad PRETUL Transparentes', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258e9d97d1d_IMG_20231010_113315_252.jpg'),
(131, 'I-0004', 'Lentes de seguridad FOY Transparentes', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '65258faddecd5_IMG_20231010_113429_054.jpg'),
(132, 'I-0005', 'Plasti acero 25 ml', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525913f69a16_IMG_20231010_113453_281.jpg'),
(133, 'I-0006', 'Cinta sella roscas 1/2\" X 7 m', 1.00, 10, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525920b640f5_IMG_20231010_113514_174.jpg'),
(134, 'I-0007', 'Disco de lija Grano 120 fino 5\"', 1.00, 13, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525933e1bb8b_IMG_20231010_113546_500.jpg'),
(136, 'I-0008', 'Disco de lija Grano 80 medio 5\"', 1.00, 11, '2024-01-08 00:00:00', 2, 2, 1, 1, '652593d8eea6c_IMG_20231010_113617_638.jpg'),
(137, 'I-0009', 'Cinta de montaje doble cara 19 mm X 5 m', 1.00, 2, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525944472efc_IMG_20231010_113631_678.jpg'),
(138, 'I-0010', 'Cinta masking 18 mm X 50 m', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525948a58bdf_IMG_20231010_113650_761.jpg'),
(139, 'I-0011', 'Pistola de silicón Chica', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '652594c2942b8_IMG_20231010_113711_071.jpg'),
(140, 'I-0012', 'Tapones auditivos con triple barrera 25 db', 1.00, 9, '2024-01-08 00:00:00', 5, 2, 1, 1, '6525951016b48_IMG_20231010_113734_333.jpg'),
(141, 'I-0013', 'Guantes de nitrilo Grandes', 1.00, 3, '2024-01-08 00:00:00', 5, 2, 1, 1, '652595508a04e_IMG_20231010_113750_383.jpg'),
(143, 'I-0014', 'Guantes de carnaza Unitalla (trabajo ligero)', 53.45, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '652595ca65d46_IMG_20231010_113804_572.jpg'),
(144, 'I-0015', 'Portalámpara para tubo flourescente FA8', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '65259615af253_IMG_20231010_113819_730.jpg'),
(145, 'I-0016', 'Manguera para aire tipo resorte 7.6 m', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '652596833170a_IMG_20231010_115933_963.jpg'),
(146, 'I-0017', 'Fumigador doméstico 1 LT.', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '652596c7cc55c_IMG_20231010_120000_943.jpg'),
(147, 'H-0073', 'Martillo de hojalatero 11 OZ.', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259736a23ab_IMG_20231010_120022_666.jpg'),
(148, 'H-0074', 'Mango para martillo Mango', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525980f04ad2_IMG_20231010_120039_303.jpg'),
(149, 'H-0075', 'Maceta de goma 606', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259960a900f_IMG_20231010_120105_237.jpg'),
(150, 'H-0076', 'Maceta de goma 808', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259995d501c_IMG_20231010_120116_822.jpg'),
(151, 'H-0077', 'Extensión eléctrica de uso rudo 16 AWG X 6 MTS', 1.00, 6, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259a2423a75_IMG_20231010_120145_934.jpg'),
(152, 'H-0078', 'Cautín Weller 221-NM-146', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259c45890f4_IMG_20231010_120456_039.jpg'),
(153, 'H-0079', 'Puntas para multimetro Fluke', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259ddad49cb_IMG_20231010_120509_094.jpg'),
(154, 'H-0080', 'Punta para cautín CT5A7MX', 1.00, 6, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259ee66b32b_IMG_20231010_120636_659.jpg'),
(155, 'H-0081', 'Punta para cautín PTA7MX', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259f71740bd_IMG_20231010_120624_780.jpg'),
(156, 'H-0082', 'Resistencia HEW60PMX', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '65259fcaca494_IMG_20231010_120721_513.jpg'),
(158, 'I-0018', 'Disco 40 grano, 115mm, 22mm', 1.00, 2, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525a7a179664_IMG_20231010_120346_523.jpg'),
(162, 'I-0019', 'Esponja para cautín Esponja', 1.00, 4, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525af2672d9e_IMG_20231010_120529_238.jpg'),
(163, 'I-0020', 'Rollo de lija N. 100 1 1/2\" X 148 Ft.', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525b0191cc09_IMG_20231010_122251_179.jpg'),
(164, 'I-0021', 'Rollo de lija grano 120 38 mm X 45 m', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6525b06eba83a_IMG_20231010_122323_456.jpg'),
(165, 'I-0022', 'Mini cepillo de alambre Surtido', 1.00, 10, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b0fa58367_IMG_20231010_122411_264.jpg'),
(166, 'H-0083', 'Navaja retráctil 18 mm', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b1918b595_IMG_20231010_122514_553.jpg'),
(167, 'H-0084', 'Navaja retráctil Pequeña', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b2121263e_IMG_20231010_122537_660.jpg'),
(168, 'I-0023', 'Repuesto para navajas Repuesto', 1.00, 8, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b2c625380_IMG_20231010_122544_491.jpg'),
(170, 'H-0085', 'Cuchilla para linóleo 7\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b34f832e0_IMG_20231010_122619_684.jpg'),
(171, 'I-0024', 'Pila alcalina A76/LR44', 1.00, 1, '2024-01-08 00:00:00', 10, 2, 1, 1, '6525b3ea55aef_IMG_20231010_135502_790.jpg'),
(175, 'H-0086', 'Lima redonda bastarda 10\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525b8f888bd8_IMG_20231010_140631_205.jpg'),
(178, 'H-0087', 'Maneral tipo garrote 5/32\" a 3/4\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525bbfaa970d_IMG_20231010_140616_249.jpg'),
(179, 'H-0088', 'Lima bastarda de media caña escofina 4\"', 70.00, 0, '2024-01-08 00:00:00', 1, 4, 1, 1, '6525bf2c397c0_IMG_20231010_140059_679.jpg'),
(180, 'H-0089', 'Lima triangular de uso regular 5\"', 1.00, 1, '2024-01-08 00:00:00', 1, 1, 1, 1, '6525bfc39a576_IMG_20231010_140110_037.jpg'),
(181, 'H-0090', 'Lima plana 5\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c0e41ba0b_IMG_20231010_140231_563.jpg'),
(182, 'H-0091', 'Bomba desoldadora Extractor', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c13eddb97_IMG_20231010_140308_697.jpg'),
(183, 'H-0092', 'Maneral ajustable 1/16\" X 1/4\"', 1.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c1d3111fa_IMG_20231010_140321_313.jpg'),
(184, 'H-0093', 'Lima bastarda de media caña 5\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c259c5ab7_IMG_20231010_140403_929.jpg'),
(185, 'H-0094', 'Broca para concreto 1/4\" X 12', 85.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c2e3e549b_IMG_20231010_140424_912.jpg'),
(186, 'H-0095', 'Segueta Diente fino', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c36f1b8b4_IMG_20231010_140447_425.jpg'),
(187, 'H-0096', 'Broca para concreto Longitud 12\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c3eab5029_IMG_20231010_140603_518.jpg'),
(188, 'H-0097', 'Maneral tipo garrote 5/32\" X 3/4\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c46a46249_IMG_20231010_140616_249.jpg'),
(189, 'H-0098', 'Tijera 8\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c520ab147_IMG_20231010_152301_159.jpg'),
(190, 'I-0025', 'Rueda flap con vástago grano 80 Ø 2\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c5fd16336_IMG_20231010_152326_826.jpg'),
(191, 'I-0026', 'Rueda flap con vástago grano 120 Ø 2\"', 1.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c65f73832_IMG_20231010_152326_826.jpg'),
(192, 'I-0027', 'Cuchillas de repuesto para cortador de tubo 18 mm', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c82ab8050_IMG_20231010_152338_762.jpg'),
(193, 'H-0099', 'Destornillador de caja 3/8\" X 3\"', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525c945b5da9_IMG_20231010_152358_564.jpg'),
(194, 'H-0100', 'Desarmador Comfort Grip 75 mm x 3\"', 1.00, 3, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525ca43c0e7c_IMG_20231010_152435_828.jpg'),
(195, 'H-0101', 'Desarmador Screwdriver 7\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cbc6b03b5_IMG_20231010_152502_653.jpg'),
(196, 'H-0102', 'Desarmador Phillips PH0 x 4\"', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cc468391d_IMG_20231010_152543_607.jpg'),
(197, 'H-0103', 'Desarmador de cruz 1/4\" x 4', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525ccd6a8bec_IMG_20231010_152631_435.jpg'),
(198, 'H-0104', 'Dado corto 9/16\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cd5485220_IMG_20231010_152650_260.jpg'),
(199, 'H-0105', 'Desarmador Plano', 1.00, 0, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cda71bafc_IMG_20231010_152722_888.jpg'),
(200, 'H-0106', 'Punzón para barrenar 3/8\"', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cf9cb1b93_IMG_20231010_152809_144.jpg'),
(201, 'H-0107', 'Punzón 5/16\" X 1/8\"', 1.00, 3, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525cfd0b2658_IMG_20231010_152923_737.jpg'),
(202, 'H-0108', 'Destornillador de caja 7 mm', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6525d0405cc72_IMG_20231010_152942_826.jpg'),
(203, 'H-0109', 'llave ajustable 6\" marca: FOY', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652874bb6fa72_IMG_20231010_154434_712.jpg'),
(204, 'H-0110', 'Llave de presión 10\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528751b2fbb0_IMG_20231010_154521_868.jpg'),
(205, 'H-0111', 'pinzas para abrir anillos de retención. desde 65mm hasta 12mm', 190.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528758810807_IMG_20231010_154539_966.jpg'),
(206, 'H-0112', 'Pinzas de presión Tipo prensa', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '65287606afac3_IMG_20231010_154605_145.jpg'),
(208, 'H-0113', 'pinzas de punta medianas', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652876a891028_IMG_20231010_154616_619.jpg'),
(209, 'H-0114', 'Pinzas para anillo de retención de 90grados', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '652876fc979d2_IMG_20231010_154629_828.jpg'),
(210, 'H-0115', 'Matraca 3/8\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528775b9ea45_IMG_20231010_154639_333.jpg'),
(211, 'H-0116', 'juego de llaves Allen tipo navaja estándar', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6528781895bd7_IMG_20231010_154720_527.jpg'),
(212, 'H-0117', 'llave combinada. 3/8\" X 16cm', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6529acbf18aa1_IMG_20231010_154821_267.jpg'),
(213, 'H-0118', 'Llave combinada 9/16\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6529b93ac3c8c_IMG_20231010_155051_770.jpg'),
(214, 'H-0119', 'Dado Corto 9/16\" 9/16\" marca SURTEK', 30.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6532f3afa9ab7_IMG_20231020_153551_656_hdr.jpg'),
(216, 'I-0028', 'Brocha 1\" 1\" Marca Comex', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6532f541a667b_IMG_20231020_153607_481_hdr.jpg'),
(218, 'H-0120', 'Llave Mixta 1/2\" 1/2\" Marca Urrea', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ea0dc3f5e_IMG_20231010_155121_905.jpg'),
(219, 'H-0121', 'Llave Mixta 3/8\" 3/8\" Marca Urrea', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ea8d57ef4_IMG_20231010_155144_754.jpg'),
(220, 'H-0122', 'Llave Allen 3/16\" Llave Allen 3/16\"', 1.00, 3, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536eba15e073_IMG_20231010_155208_965.jpg'),
(221, 'H-0123', 'Llave Allen 3.0mm Llave Allen 3.0mm', 1.00, 6, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ec2182e0e_IMG_20231010_155230_884.jpg'),
(222, 'H-0124', 'Llave Allen 5/32\" Llave Allen 5/32\"', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ec7417827_IMG_20231010_155305_259.jpg'),
(223, 'H-0125', 'Llave Allen 5/64\" Llave Allen 5/64\"', 1.00, 13, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ecbd71cce_IMG_20231010_155322_039.jpg'),
(224, 'H-0126', 'Llave Allen 1/8\" Llave Allen 1/8\"', 1.00, 9, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ed14c3b40_IMG_20231010_155448_355.jpg'),
(225, 'H-0127', 'Llave Allen tipo T 3/32\" Llave Allen tipo T 3/32\"', 1.00, 4, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536ed6bb7880_IMG_20231010_155505_574.jpg'),
(226, 'H-0128', 'Llave Allen Tipo T 1/8\" Llave Allen Tipo T 1/8\" ', 1.00, 4, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536eea290400_IMG_20231010_155516_199.jpg'),
(227, 'H-0129', 'Maneral ajustable tipo T 1/2\" Maneral ajustable tipo T 1/2\" marca truper', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536efa239bbb_IMG_20231010_155708_862.jpg'),
(228, 'H-0130', 'Maneral Tipo T ajustable 3/16\" Maneral Tipo T ajustable 3/16\" marca Surtek', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536effe5e1b3_IMG_20231010_155730_317.jpg'),
(229, 'H-0131', 'Manera Tipo T ajustable 1/4\" Manera Tipo T ajustable 1/4\" marca truper', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f05aef38d_IMG_20231010_155813_643.jpg'),
(230, 'H-0132', 'Broquero 1/2\" Broquero 1/2\" marca truper', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f0b0bc6f6_IMG_20231010_155800_670.jpg'),
(232, 'I-0029', 'Cople Rápido Macho Cople Rápido Macho', 1.00, 4, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f2171b4fa_IMG_20231010_155836_005.jpg'),
(233, 'I-0030', 'Cople rápido hembra Cople rápido hembra surtek', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f287a1b0f_IMG_20231010_155848_071.jpg'),
(234, 'I-0031', 'Cople rápido hembra Cople rápido hembra marca truper', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f2bec2c4d_IMG_20231010_155903_289.jpg'),
(235, 'H-0133', 'Flexometro 5m x 16\" Flexometro 5m x 16\" truper', 1.00, 2, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f34d60237_IMG_20231010_155922_495.jpg'),
(236, 'I-0032', 'Pila 2016 de 3V Pila 2016 de 3V marca steren', 1.00, 11, '2024-01-08 00:00:00', 10, 2, 1, 1, '6536f46a4b3ac_IMG_20231010_160102_979.jpg'),
(238, 'I-0033', 'Pila AA 1.5V Pila AA 1.5V marca RadioShack', 1.00, 1, '2024-01-08 00:00:00', 1, 2, 1, 1, '6536f64d64536_IMG_20231010_160316_111.jpg'),
(239, 'I-0034', 'Pila AAA Pila AAA marca duracel', 1.00, 6, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f6af551d7_IMG_20231010_160547_272.jpg'),
(240, 'I-0035', 'Pila 9V Pila 9V marca Duracell', 1.00, 1, '2024-01-08 00:00:00', 2, 2, 1, 1, '6536f736d0c06_IMG_20231010_160446_493.jpg'),
(241, 'I-0036', 'Gas butano Gas butano Pretul', 1.00, 2, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f76a9dc4b_IMG_20231010_160737_064.jpg'),
(242, 'I-0037', 'WD40 WD40', 1.00, 1, '2024-01-08 00:00:00', 5, 2, 1, 1, '6536f79498c77_IMG_20231010_160757_880.jpg'),
(243, 'MPM-001', 'Barra redonda INOX 1/8\" X 1.20cm Barra redonda INOX 1/8\" X 1.20cm', 80.00, 5, '2024-01-08 00:00:00', 6, 1, 1, 1, '6536f804ad445_IMG-20231016-WA0001.jpg'),
(245, 'MARC001-5B', 'TORNILLO PARA MESA INCISAL', 20.00, 20, '2024-01-08 00:00:00', 9, 3, 1, 1, '653ad8eb74bfc_IMG_20231010_16081.jpg'),
(246, 'I-0038', 'Bolsas para basura. Bolsas para basura, para desperdicio de maquinado.', 50.00, 10, '2024-01-08 00:00:00', 2, 4, 1, 1, '653ad8eb74bfc_IMG_20231010_160813_434.jpg'),
(247, 'MARC001-5Ñ', 'CONDILO', 20.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, '653ada08abb5c_condilo.jpg'),
(248, 'MARC001-4J', 'PERNO PARA LIGA DE CONTRACCION', 20.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, '653ade70bc6c0_dhjasdkjadljAFKADADKADLKahjkdahdkahd12651.png'),
(253, 'H-0134', 'Boquilla ER25 1/2\" ER25 1/2\"', 532.50, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162509.jpg'),
(254, 'H-0135', 'Cortador 5/8\" HSS 5/8\" HSS', 1032.40, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162528.jpg'),
(255, 'H-0136', 'Broca 28 Broca 28', 50.75, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162546.jpg'),
(256, 'H-0137', 'Broca 29 Broca 29', 50.75, 3, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162601.jpg'),
(257, 'H-0138', 'Broca 30 Broca 30', 50.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, '20231027_162608.jpg'),
(258, 'H-0139', 'Broca para metal 7/32\" Broca para metal 7/32\"', 80.75, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG_20231030_132125_501_hdr.jpg'),
(259, 'MARC001-5X', 'PORTA PLATINA', 40.00, 74, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085206_665_hdr.jpg'),
(260, 'MARC001-5Q', 'TORNILLO DE FIJACION TORNILLO 1', 8.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085129_359_hdr.jpg'),
(261, 'MARC001-6D', 'TORNILLO SUJECION 3', 8.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085117_602_hdr.jpg'),
(262, 'MARC001-4Ñ', 'VARILLA DE SOPORTE', 40.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085158_182_hdr.jpg'),
(263, 'MARC001-4W', 'PERNO 4 SUJECION NIVEL', 35.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231031_085140_134_hdr.jpg'),
(264, 'MARC001-5C', 'PERNO DE POSICION (3/16\" x .470\")', 7.50, 118, '2024-01-08 00:00:00', 9, 3, 1, 1, 'pernos.jpg'),
(265, 'I-0039', 'Kola loka Pegamento kola loka', 20.00, 10, '2024-01-08 00:00:00', 11, 4, 1, 1, 'IMG_20231101_080204_317_hdr.jpg'),
(266, 'I-0040', 'Disco para esmeriladora angular para corte de metal 4 1/2\" Disco para esmeriladora angular para corte de metal 4 1/2\"  marca maxtool', 50.00, 3, '2024-01-08 00:00:00', 11, 4, 1, 1, 'IMG_20231101_120033_192_hdr.jpg'),
(267, 'P-0001', 'Hojas Blancas paquete 500 hojas Hojas Blancas paquete 500 hojas', 1.00, 3, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_124600_652_hdr.jpg'),
(268, 'P-0002', 'Etiquetas redondas dorada paquete Etiquetas redondas dorada paquete', 1.00, 4, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_124920_580_hdr.jpg'),
(269, 'P-0003', 'Grapas caja de 5000 pzas. Grapas caja de 5000 pzas.', 1.00, 2, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_125114_229_hdr.jpg'),
(270, 'P-0004', 'Libreta profesional cuadro grande Libreta profesional cuadro grande', 20.00, 5, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_125216_282_hdr.jpg'),
(271, 'P-0005', 'Hojas de colores combinadas Hojas de colores combinadas por hojas', 1.00, 150, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_125341_661_hdr.jpg'),
(272, 'P-0006', 'Hojas blancas 500 pzas.', 180.00, 5, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_124600_652_hdr_654c02cef14dc.jpg'),
(273, 'P-0007', 'Cuaderno profesional cuadro grande', 22.00, 1, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_125216_282_hdr_654c0317801c3.jpg'),
(274, 'P-0008', 'Tinta color azul Tinta color roja', 1.00, 1, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_125834_988_hdr.jpg'),
(275, 'P-0009', 'Tinta color negro Tinta color negro', 1.00, 1, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_125841_629_hdr.jpg'),
(276, 'P-0010', 'Cinta chica transparente scotch 550 Cinta chica transparente scotch 550', 1.00, 7, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_130008_700_hdr.jpg'),
(277, 'P-0011', 'Marcador sharpie delgado punto fino color rojo. Marcador sharpie delgado punto fino color rojo.', 10.30, 12, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_130629_590_hdr.jpg'),
(278, 'P-0012', 'Marcador Sharpie delgado punto fino color negro Marcador Sharpie delgado punto fino color negro', 17.10, 8, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_130751_772_hdr.jpg'),
(279, 'P-0013', 'Marcador BIC delgado punto fino color negro Marcador BIC delgado punto fino color negro', 17.40, 6, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_130847_249_hdr.jpg'),
(280, 'P-0014', 'Marcador Baco delgado punto fino color azul Marcador Baco delgado punto fino color azul', 18.00, 8, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_130937_485_hdr.jpg'),
(281, 'p-0015', 'Bolígrafo Azor punto fino color negro Bolígrafo Azor punto fino color negro', 1.00, 8, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_131122_472_hdr.jpg'),
(282, 'P-0016', 'Bolígrafo azor punto fino color rojo Bolígrafo azor punto fino color rojo', 1.00, 6, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_131146_164_hdr.jpg'),
(283, 'P-0017', 'Bolígrafo Azor punto fino color azul Bolígrafo Azor punto fino color azul', 1.00, 6, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_131236_084_hdr.jpg'),
(284, 'P-0018', 'Marcador Esterbrook negro Marcador Esterbrook negro', 28.12, 4, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_131330_455_hdr.jpg'),
(285, 'P-0019', 'Marcador Esterbrook color azul Marcador Esterbrook color azul', 28.12, 3, '2024-01-08 00:00:00', 4, 5, 1, 1, 'IMG_20231108_131521_459_hdr.jpg'),
(286, 'P-0020', 'Marcador Esterbrook color rojo Marcador Esterbrook color rojo', 28.12, 2, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132237_713_hdr.jpg'),
(287, 'P-0021', 'Boligrafo BIC color negro punto fino Boligrafo BIC color negro punto fino', 1.00, 4, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_131634_257_hdr.jpg'),
(288, 'P-0022', 'Bolígrafo BIC color negro punto mediano Bolígrafo BIC color negro punto mediano', 1.00, 5, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_131711_565_hdr.jpg'),
(289, 'P-0023', 'Lapiz Paper Mate HB 2.5 Lapiz Paper Mate HB 2.5', 1.00, 12, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132053_648_hdr.jpg'),
(290, 'P-0024', 'Marcador Azor grueso color rojo Marcador Azor grueso color rojo', 15.24, 2, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132209_726_hdr.jpg'),
(291, 'P-0025', 'Marcador sharpie punto ultra fino color negro Marcador sharpie punto ultra fino color negro', 17.10, 5, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132331_183_hdr.jpg'),
(292, 'P-0026', 'Marcador colores surtido Marcador colores surtido', 11.20, 4, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132107_774_hdr.jpg'),
(293, 'P-0027', 'Marcador Magistral color negro Marcador Magistral color negro', 18.62, 4, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132439_110_hdr.jpg'),
(294, 'P-0028', 'Lapiz adhesivo Dixon Lapiz adhesivo Dixon', 1.00, 6, '2024-01-08 00:00:00', 6, 5, 1, 1, 'IMG_20231108_132710_926_hdr.jpg'),
(295, 'P-0029', 'Masking Tape Janel 24mm Masking Tape Janel 24mm', 23.66, 5, '2024-01-08 00:00:00', 2, 5, 1, 1, 'IMG_20231108_132844_337_hdr.jpg'),
(296, 'H-0140', 'Disco para esmeril, corte de metal, delgado de 4-1/2\" marca Astromex', 50.00, 2, '2024-01-08 00:00:00', 11, 4, 1, 1, 'IMG20231110103057.jpg'),
(297, 'H-0141', 'Boquilla ER40 1/4\" (7-6mm) Boquilla ER40 1/4\" (7-6mm)', 580.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133250.jpg'),
(298, 'H-0142', 'Boquilla ER32 3/32\" (3-2mm) Boquilla ER32 3/32\" (3-2mm)', 539.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133258.jpg'),
(299, 'H-0143', 'Rima recta 3/16\" clevelan Rima recta 3/16\" clevelan', 882.00, 1, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133317.jpg'),
(300, 'H-0144', 'Broca HSS 4F 3/32\" Cleveland Broca HSS 4F 3/32\" Cleveland', 28.00, 10, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133421.jpg'),
(301, 'H-0145', 'Sierra cinta classic 3/4\" X 39\" 6-10 dientes Lenox Sierra cinta classic 3/4\" X 39\" 6-10 dientes Lenox', 960.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133636.jpg'),
(302, 'H-0146', 'Broca HSS #7 Cleveland Broca HSS #7 Cleveland', 50.75, 6, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133415.jpg'),
(303, 'H-0147', 'Broca HSS #20 Cleveland Broca HSS #20 Cleveland', 50.75, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133410.jpg'),
(304, 'H-0148', 'Cortador vertical de HSS 4F 1/8\" CLEV Cortador vertical de HSS 4F 1/8\" CLEV', 340.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231110133343.jpg'),
(305, 'I-0041', 'Plasti Loka Plasti Loka', 25.00, 2, '2024-01-08 00:00:00', 11, 4, 1, 1, 'IMG20231114083449.jpg'),
(306, 'MARC001-6M', 'TORNILLO SUJECION 2, (TORNILLO PARA PORTA PLATINA Y BASE DE CALIBRACION).', 10.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231003_085415_568_hdr.jpg'),
(307, 'MARC001-6G', 'SOPORTE DE PANTALLA CENTRAL', 25.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231027_075910_962_hdr.jpg'),
(308, 'MARC001-5J', 'PANTALLA DE REGISTRO DERECHA', 15.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20231010_075948_466.jpg'),
(309, 'MARC001-5H', 'PANTALLA DE REGISTRO IZQUIERDA', 15.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'pantallas derechas.jpg'),
(310, 'MARC001-5A', 'MESA INCISAL', 25.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'IMG_20230913_083850_991_hdr.jpg'),
(311, 'MARC001-5T', 'Varilla para Sujeción Central Varilla para Sujeción Central', 25.00, 15, '2024-01-08 00:00:00', 9, 3, 1, 1, 'varillacentral.jpg'),
(312, 'S/C', '', 0.00, 100, '2024-01-08 00:00:00', 1, 6, 1, 1, 'IMG20231122153955.jpg'),
(313, 'I-0042', 'Gasolina Blanca Gasolina Blanca ', 90.00, 20, '2024-01-08 00:00:00', 2, 7, 1, 1, 'IMG20231114130100.jpg'),
(314, 'I-0043', 'Retazo de Trapo blanco Retazo de Trapo blanco', 100.00, 20, '2024-01-08 00:00:00', 2, 7, 1, 1, 'IMG20231114130103.jpg'),
(315, 'H-0149', 'Boquilla ER40 1/8\"(4-3) Boquilla ER40 1/8\"(4-3)', 580.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231122115247.jpg'),
(316, 'H-0150', 'Broca numerica #19 Cleveland Broca numerica #19 Cleveland', 50.75, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231122115311.jpg'),
(317, 'H-0151', 'Llave allen bola 3/32\" en L Llave allen bola 3/32\" en L', 38.00, 10, '2024-01-08 00:00:00', 1, 2, 1, 1, 'IMG20231122115332.jpg'),
(318, 'H-0152', 'Broca HSS 1/8\" larga Broca HSS 1/8\" larga', 50.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231122115411.jpg'),
(319, 'I-0044', 'Playo para empaque rollo chico Playo para empaque rollo chico', 40.00, 11, '2024-01-08 00:00:00', 2, 4, 1, 1, 'IMG20231114130404.jpg'),
(320, 'ACTUALIZAR', 'ACTUALIZAR', 0.00, 0, '2024-01-08 00:00:00', 10, 3, 1, 1, 'IMG20231116145914.jpg'),
(321, 'MARC001-4K', 'VARILLA PARA NIVEL', 25.00, 0, '2024-01-08 00:00:00', 9, 3, 1, 1, 'Captura de pantalla 2023-11-23 140637.png'),
(322, 'MARC001-5R', 'Pin de Marca Central Pin de Marca Central', 10.00, 0, '2024-01-08 00:00:00', 8, 3, 1, 1, 'Captura de pantalla 2023-11-23 141330.png'),
(323, 'I-0045', 'Cuchillas, Navajas de repuesto de 18mm Cuchillas, Navajas de repuesto de 18mm', 3.14, 17, '2024-01-08 00:00:00', 1, 4, 1, 1, '.trashed-1703363215-IMG20231123142433.jpg'),
(324, 'H-0153', 'Lima Plana Muza de 8\" con mango Lima Plana Muza de 8\" con mango', 65.52, 2, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143139.jpg'),
(325, 'H-0154', 'Juego de 11 Brocas para Metal y concreto Juego de 11 Brocas para Metal y concreto', 176.00, 0, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142325.jpg'),
(326, 'I-0046', 'Guantes de nylon recubiertos de poliuretano MEDIANOS Guantes de nylon recubiertos de poliuretano MEDIANOS', 42.00, 5, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142300.jpg'),
(327, 'I-0047', 'Guantes de nylon recubiertos de poliuretano GRANDES Guantes de nylon recubiertos de poliuretano GRANDES', 42.24, 5, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142307.jpg'),
(328, 'H-0155', 'Escuadra Para Carpintero de 8\" Escuadra Para Carpintero de 8\"', 99.00, 2, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123142858.jpg'),
(329, 'I-0048', 'Segueta bimetálica de 18DPP largo de 12\" Segueta bimetálica de 18DPP largo de 12\"', 20.25, 6, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143300.jpg'),
(330, 'I-0049', 'Segueta Bimetálica de 24DPP, 12\" de largo Segueta Bimetálica de 24DPP, 12\" de largo', 20.25, 6, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143322.jpg'),
(331, 'H-0156', 'Llave combinada de 1/2\" X 170mm. de largo Llave combinada de 1/2\" X 170mm. de largo', 25.00, 1, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143227.jpg'),
(332, 'H-0157', 'Llave combinada 9/16\" X 180mm de largo Llave combinada 9/16\" X 180mm de largo', 30.17, 1, '2024-01-08 00:00:00', 1, 4, 1, 1, 'IMG20231123143215.jpg'),
(338, 'H-0159', 'Broca de cobalto C/ Alcrona 1/8\" X 70mm Corte 13mm largo total DORMER', 756.00, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231206152658.jpg'),
(339, 'H-0160', 'Broca HSS Alfabética Letra \"B\" CLEVELAND', 65.25, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20231206152430.jpg'),
(340, 'I-0050', 'Nivel de gota para arco facial', 3.00, 92, '2024-01-08 00:00:00', 9, 4, 1, 1, 'IMG20231206161640.jpg'),
(341, 'H-0161', 'Inserto de carburo A4R125I03P00GMN KCU10 KENNAMETAL', 546.00, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133744.jpg'),
(342, 'H-0162', 'PortaHerramientas Derecho A4SMR1616K0314 KENNAMETAL', 3208.75, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133754.jpg'),
(343, 'H-0163', 'Broca HSS Alfabetica Letra \"D\" Clev', 65.25, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102134457.jpg'),
(344, 'H-0164', 'BROCA HSS NUMERICA \"#30\" CLEV', 43.50, 0, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133730.jpg'),
(345, 'H-0165', 'Broca HSS Alfabetica Letra \"N\" CLEV', 85.55, 5, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102134427.jpg'),
(346, 'H-0166', 'Broca HSS Numerica \"#15\" CLEV', 50.75, 4, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102133812.jpg'),
(347, 'H-0167', 'RIMA HSS 3/16\"', 913.50, 2, '2024-01-08 00:00:00', 3, 2, 1, 1, 'IMG20240102134304.jpg'),
(350, 'MARC001-6F', 'PERNO PARA PANTALLA CENTRAL DE 1/4\" x 1-1/2\", PERNO RECTIFICADO ACERO INOXIDABLE DE 1/4\" x 1-1/2\"', 10.00, 72, '2024-01-08 00:00:00', 9, 3, 1, 1, 'PERNO_PARA_PANTALLA_46.jpg'),
(351, 'ACTUALIZAR', 'ACTUALIZAR', 0.00, 0, '2024-01-08 00:00:00', 10, 4, 1, 1, 'PERNO_2_DE_PANTALLA_CENTRAL_DE_1_1_4_x_3_16_63.jpg'),
(352, 'MARC001-5W', 'PERNO 2 PARA PANTALLA DERECHA O IZQUIERDA DE 5/16\" x 1\"', 8.21, 60, '2024-01-08 00:00:00', 9, 4, 1, 1, 'PERNO_2_PARA_PANTALLA_DERECHA_O_IZQUIERDA_DE_1_pulgada_x_5-16_pulgadas_89.jpg'),
(353, 'MARC001-4X', 'IMAN DE NEODIMIO CUADRADO DE 15X15X3MM', 14.09, 96, '2024-01-08 00:00:00', 9, 12, 1, 1, 'IMAN_DE_NEODIMIO_DE_15X15X3MM_96.jpg'),
(354, 'MARC001-5D', 'BASE INFERIOR', 116.17, 37, '2024-01-08 00:00:00', 9, 3, 1, 1, 'BASE_INFERIOR_32.png'),
(355, 'MARC001-6H', 'PANTALLA CENTRAL', 113.18, 20, '2024-01-08 00:00:00', 9, 3, 1, 1, 'PANTALLA_CENTRAL_28.png'),
(356, 'MARC001-5F', 'BASTIDOR MARCO CPI', 325.38, 25, '2024-01-08 00:00:00', 9, 3, 1, 1, 'BASTIDOR_MARCO_CPI_19.png'),
(358, 'MARC001-5M', 'IMAN DE NEODIMIO REDONDO 3/4 x 0.100', 26.68, 95, '2024-01-14 00:00:00', 9, 25, 1, 1, 'IMG20231122153955.jpg'),
(359, 'MARC001-5Z', 'PERNO 1 PARA PANTALLA DERECHA O IZQUIERDA, PERNO SOLIDO RECTIFICADO ACERO INOXIDABLE DE  1/4\" x 1\"', 10.00, 41, '2024-01-15 00:00:00', 9, 4, 1, 1, 'perno1pantalla.png'),
(360, 'MARC001-7M', 'SOPORTE NASAL', 10.00, 0, '2024-01-16 00:00:00', 9, 3, 1, 1, 'SOPORTE_NASAL_77.png'),
(361, 'MARC001-7W', 'CONECTOR 2 HORQUILLA', 10.00, 0, '2024-01-16 00:00:00', 9, 3, 1, 1, 'CONECTOR_2_HORQUILLA_28.png'),
(362, 'MARC001-7K', 'CONECTOR 1 HORQUILLA', 10.00, 0, '2024-01-16 00:00:00', 9, 3, 1, 1, 'CONECTOR_1_HORQUILLA_12.png'),
(363, 'MARC001-7T', 'OLIVA', 10.00, 0, '2024-01-16 00:00:00', 9, 3, 1, 1, 'OLIVA_39.png'),
(364, 'MARC001-7Y', 'TRAVESAÑO PARA PERNO', 20.00, 0, '2024-01-16 00:00:00', 8, 3, 1, 1, 'TRAVESAÑO_PARA_PERNO_39.png'),
(365, 'MARC001-8A', 'PERNO AJUSTADOR GRANDE', 30.00, 0, '2024-01-16 00:00:00', 9, 3, 1, 1, 'TORNILLO_GRANDE_15.png'),
(366, 'H-0168', 'BOQUILLA ER32 3/16\" (5-4)', 539.00, 0, '2024-01-16 00:00:00', 3, 2, 1, 1, 'BOQUILLA_ER32_17.jpg'),
(367, 'H-0169', 'MACHUELO HELICOIDAL M4 x 0.7 ROYCO', 769.50, 5, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M4_x_0.7_ROYCO_28.jpg'),
(368, 'H-0170', 'MACHUELO HELICOIDAL M5 x 0.8 ROYCO', 769.50, 2, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M5_x_0.8_ROYCO_21.jpg'),
(369, 'H-0171', 'MACHUELO HELICOIDAL M6 x 1 ROYCO', 769.50, 2, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M6_x_1_ROYCO_68.jpg'),
(370, 'H-0172', 'MACHUELO GUN 2F  3/16\" - 24 ROYCO 2B 2S/P', 152.25, 4, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_GUN_2F__3_16_-_24_ROYCO_33.jpg'),
(371, 'H-0173', 'CORTADOR VERTICAL RECTO 1/2\" 4FL ALTIN', 1222.00, 2, '2024-01-16 00:00:00', 3, 2, 1, 1, 'CORTADOR_VERTICAL_RECTO_1_2_4FL_ALTIN_27.jpg'),
(372, 'H-0174', 'CORTADOR DE CARBURO LARGO 1/8\" x 4\" 4FL BRILLANTE', 504.00, 1, '2024-01-16 00:00:00', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_LARGO_1_8_x_4_4FL_BRILLANTE_75.jpg'),
(373, 'H-0175', 'BROCA DE CENTRO #1 CLEV', 72.50, 6, '2024-01-16 00:00:00', 3, 2, 1, 1, 'BROCA_DE_CENTRO_1_CLEV_0.jpg'),
(374, 'H-0176', 'CORTADOR VERTOCAL A.V. 4F 3mm GREENFIELD', 145.00, 1, '2024-01-16 00:00:00', 3, 2, 1, 1, 'CORTADOR_VERTOCAL_A.V._4F_3mm_GREEBFIELD_59.jpg'),
(375, 'H-0177', 'MACHUELO HELICOIDAL N10-24 ROYCO', 540.00, 2, '2024-01-16 00:00:00', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_N10-24_ROYCO_95.jpg'),
(376, 'MARC001-5K', 'VARILLA DE NIVEL', 4.63, 0, '2024-01-18 00:00:00', 9, 3, 1, 1, 'VARILLA_DE_NIVEL_18.png'),
(377, 'MARC001-5Y', 'BASE COLUMNA DE CALIBRACION', 158.50, 20, '2024-01-18 00:00:00', 9, 3, 1, 1, 'BASE_COLUMNA_DE_CALIBRACION_97.png'),
(378, 'MARC001-5G', 'BASE SUPERIOR CPI', 258.06, 20, '2024-01-23 00:00:00', 9, 3, 1, 1, 'BASE_SUPERIOR_CPI_10.png'),
(379, 'MARC001-4A', 'MARCO PARA ANALOGO', 10.00, 24, '2024-01-24 00:00:00', 9, 3, 1, 1, 'PERNO_DE_POSICION_79.png'),
(380, 'H-0178', 'SET DE BOQUILLAS ER 32 ORION', 233.50, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'SET_DE_BOQUILLAS_ER_32_ORION_60.jpg'),
(381, 'H-0179', 'CONO CAT 40 A ER16, PROYECCIÓN DE 101.6mm, MCA. SANDVIK', 149.90, 3, '2024-01-24 00:00:00', 3, 11, 1, 2, 'CONO_CAT_40_A_ER16,_PROYECCIÓN_DE_101.6mm,_MCA._SANDVIK_77.jpg'),
(382, 'H-0180', 'LLAVE PARA TUERCA CONO CAT 40 A ER16, MCA. Sandvik', 27.40, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'LLAVE_PARA_TUERCA_CONO_CAT_40_A_ER16,_MCA._Sandvik_4.png'),
(383, 'H-0181', 'CONO CAT 40 A ER20, PROYECCIÓN DE 152.4mm, MCA. SANDVIK.', 149.90, 4, '2024-01-24 00:00:00', 3, 11, 1, 2, 'CONO_CAT_40_A_ER20,_PROYECCIÓN_DE_152.4mm,_MCA._SANDVIK._98.jpg'),
(384, 'H-0182', 'LLAVE PARA TUERCA CONO CAT 40 A ER20, MCA. Sandvik.', 27.40, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'LLAVE_PARA_TUERCA_CONO_CAT_40_A_ER20,_MCA._Sandvik._71.jpg'),
(385, 'H-0183', 'TORNILLO DE RETENCIÓN, PULL STUD, ROSCA M16, MCA. Sandvik.', 40.15, 2, '2024-01-24 00:00:00', 3, 11, 1, 2, 'TORNILLO_DE_RETENCIÓN,_PULL_STUD,_ROSCA_M16,_MCA._Sandvik._13.jpg'),
(386, 'H-0184', 'PORTA PINZAS (BOQUILLA) ER20, RANGO DE 2mm A 13mm, MCA. ORION, TECNOLOGÍA ALEMANA', 150.00, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'PORTA_PINZAS_(BOQUILLA)_ER20,_RANGO_DE_2mm_A_13mm,_MCA._ORION,_TECNOLOGÍA_ALEMANA_10.jpg'),
(387, 'H-0185', 'PORTA PINZAS (BOQUILLA) ER16, RANGO DE 0.5mm A 10mm, MCA. ORION, TECNOLOGÍA ALEMANA', 180.00, 1, '2024-01-24 00:00:00', 3, 11, 1, 2, 'PORTA_PINZAS_(BOQUILLA)_ER16,_RANGO_DE_0.5mm_A_10mm,_MCA._ORION,_TECNOLOGÍA_ALEMANA_2.png'),
(388, 'H-0186', 'INSERTO DE CARBURO DGN 2202JT IC 808ISCAR', 32.50, 10, '2024-01-24 00:00:00', 3, 2, 1, 2, 'INSERTO_DE_CARBURO_DGN_2202JT_IC_808ISCAR_85.jpg'),
(389, 'H-0187', 'Fresa 4 filos, diámetro 1/8\" con longitud de corte 1\" y longitud total 3\", con mango\ncilíndrico 1/8\", carburo en acabado brillante, Marca Dormer', 20.71, 10, '2024-02-06 00:00:00', 3, 11, 1, 2, NULL),
(390, 'H-0188', 'Fresa 4 filos, diámetro 1/4\" con longitud de corte 1-1/8\" y longitud total 3\", con\r\nmango cilíndrico 1/4\", carburo en, acabado brillante Marca Dormer', 26.10, 6, '2024-02-06 00:00:00', 3, 11, 1, 2, NULL),
(391, 'H-0189', 'Fresa 4 filos, diámetro 3/8\" con longitud de corte 1-1/8\" y longitud total 3\", con\r\nmango cilíndrico 3/8\", carburo en, acabado brillante Marca Dormer', 36.30, 6, '2024-02-06 00:00:00', 3, 11, 1, 2, NULL),
(392, 'H-0190', 'CORTADOR DE 1/2 DE DIAMETRO 4 FILOS DE\r\nCORTE X 1 DE LARGO DE CORTE X 3 DE LARGO\r\nTOTAL MCA. DORMER', 43.29, 6, '2024-02-06 14:35:35', 3, 11, 1, 2, NULL),
(393, 'H-0191', 'CORTADOR DE 3/4 DE DIAMETRO 4 FILOS DE\r\nCORTE X 1 1/2 DE LARGO DE CORTE X 4 DE\r\nLARGO TOTAL MCA. DORMER', 122.62, 4, '2024-02-06 14:40:35', 3, 11, 1, 2, NULL),
(394, 'MP-VC-250-8', 'CAPUCHON, ROUND VINYL CAPS, 0.250 X 0.350 X .0500', 0.26, 1000, '2024-02-07 10:06:02', 9, 10, 1, 2, 'CAPUCHON,_ROUND_VINYL_CAPS,_0.250_X_0.350_X_.0500_97.jpg'),
(395, 'MP-VC-437-16', 'CAPUCHON ROUND VINYL CAPS 0.437 X 0.560 X 1.000', 0.16, 2500, '2024-02-07 10:08:05', 9, 10, 1, 2, 'CAPUCHON_ROUND_VINYL_CAPS_0.437_X_0.560_X_1.000_92.jpg'),
(396, 'MARC001-6A', 'ARANDELA PLANA DIAMETRO 12.7MM, SPECIAL FLAT WASHER .750 X .193 X .040 W-07514', 0.12, 1000, '2024-02-07 10:10:09', 9, 10, 1, 2, 'ARANDELA_SPECIAL_FLAT_WASHER_.750_X_.193_X_.040_82.jpg'),
(397, 'MARC001-5E', 'ARANDELA PLANA MESA, SPECIAL FLAT WASHER .500 X .265 X .031  W-5031', 0.06, 973, '2024-02-07 10:12:24', 9, 10, 1, 2, 'ARANDELA_SPECIAL_FLAT_WASHER_.500_X_.265_X_.031_2.jpg'),
(398, 'MARC001-7D', 'ARANDELA PLANA 1.6MM, SPECIAL FLAT WASHER .750 X .257 X .062 W-07530', 0.08, 1000, '2024-02-07 10:17:52', 9, 10, 1, 2, 'ARANDELA_SPECIAL_FLAT_WASHER_.750_X_.257_X_.062_59.jpg'),
(399, 'H-0192', 'INSERTO DE CARBURO NG2031RK KC5025 KENNAMETAL', 469.00, 10, '2024-02-07 12:23:14', 3, 2, 1, 1, 'INSERTO_DE_CARBURO_NG2031RK_KC5025_KENNAMETAL_82.jpg'),
(400, 'H-0193', 'CORTADOR DE CARBURO 3/16 x 1 Y MEDIO CORTE x 4 LT 4 4FL BRILLANTE', 672.00, 1, '2024-02-08 10:35:15', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_3_16_x_1_Y_MEDIO_CORTE_x_4_LT_4_4FL_BRILLANTE_64.jpg'),
(401, 'H-0194', 'MACHUELO HELICOIDAL M3 x 0.5', 686.00, 0, '2024-02-08 10:36:55', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_M3_x_0.5_55.jpg'),
(402, 'H-0195', 'FRESA DE DOBLE CORTE DE CARBURO SL-4', 784.00, 2, '2024-02-08 10:46:59', 3, 2, 1, 1, 'LIMA_ROTATIVA_CONICA_DE_CARBURO_SL-4_99.jpg'),
(404, 'H-0197', 'CORTADOR DE CARBURO 3/16\" x 2\" 4FL', 414.45, 1, '2024-02-16 14:10:11', 3, 2, 1, 1, 'CORTADOR_DE_CARBURO_3_16_PULGADAS_x_2_PULGADAS_4FL_10.jpg'),
(405, 'H-0197', 'BROCA LARGA 1/8\" x 5-1/8\"  CLEV', 91.50, 2, '2024-02-16 14:12:31', 3, 2, 1, 1, 'BROCA_LARGA_1_8_x_5_1_8__CLEV_83.jpg'),
(406, 'H-0198', 'BROCA EXTRA LARGA 1/8\"  x 8\" CLEV', 301.00, 2, '2024-02-16 14:15:06', 3, 2, 1, 1, 'BROCA_EXTRA_LARGA_1_8__x_8_CLEV_53.jpg'),
(407, 'H-0199', 'LLAVE TORX  T9x6\" URREA', 183.40, 1, '2024-02-16 14:18:34', 1, 2, 1, 1, 'LLAVE_TORX__T9x6_URREA_56.jpg'),
(408, 'H-0200', 'LLAVE TORX T10x6\" URREA', 183.40, 0, '2024-02-16 14:19:53', 1, 2, 1, 1, 'LLAVE_TORX_T10x6_URREA_11.jpg'),
(409, 'H-0201', 'PORTA PINZAS BOQUILLA ER20 RANGO DE 2mm A 13mm', 180.00, 0, '2024-02-19 10:29:53', 3, 11, 1, 2, 'PORTA_PINZAS_BOQUILLA_ER20_RANGO_DE_2mm_A_13mm_90.jpg'),
(410, 'H-0202', 'Broca serie extra larga con zanco cilíndrico, diámetro 0.1252\" 1/8 con longitudtotal de 160mm y longitud de filo de 100mm según norma BS 328 con puntacónica 118°, HSS con acabado vaporizado y hélice normal 10xD para aladradosin picado, MCA.DORMER', 23.25, 4, '2024-02-22 10:24:02', 3, 11, 1, 2, 'Broca_serie_extra_larga__22.jpg'),
(411, 'I-0051', 'CUBETA 19 LT REFRIGERANTE PARA CNC BLASER UNIVERSAL 2000', 362.50, 1, '2024-03-11 15:41:01', 2, 2, 1, 2, 'CUBETA_19_LT_REFRIGERANTE_PARA_CNC_BLASER_UNIVERSAL_2000_44.jpg'),
(412, 'I-0052', 'ACEITE 3 EN UNO 90ML', 56.00, 6, '2024-03-11 15:43:04', 5, 2, 1, 1, 'ACEITE_3_EN_UNO_90ML_44.jpg'),
(413, 'H-0203', 'BROCA RECTA A.V. 43/64\" CLEV', 658.00, 1, '2024-03-11 15:50:54', 3, 2, 1, 1, 'BROCA_RECTA_A_V_43_64_CLEV_31.jpg'),
(414, 'H-0204', 'BROCA RECTA A.V. 21/32\" CLEV', 644.00, 1, '2024-03-11 16:01:43', 1, 2, 1, 1, 'BROCA_RECTA_A_V_21_32_CLEV_18.jpg'),
(415, 'H-0205', 'MACHUELO HELICOIDAL 5/16-18 GH2 3FX MB S/O', 900.00, 2, '2024-03-14 15:20:07', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_5_16_18_GH2_3FX_MB_S_O_91.jpg'),
(416, 'H-0206', 'fresa para redondear esquinas, corner rounding end mill 3/16 x 1/2', 980.00, 1, '2024-03-15 11:45:57', 3, 2, 1, 1, 'fresa_para_redondear_esquinas,_corner_rounding_end_mill_3_16_x_1_2_5.jpg'),
(417, 'H-0207', 'BROCA #16', 70.00, 5, '2024-03-19 13:33:23', 3, 2, 1, 1, 'BROCA_16_1.jpg'),
(418, 'H-0208', 'SIERRA CINTA LONGITUD DE 2,362mm (93\", FABRICACION ESPECIAL), DIENTE M42, COMBINADO, MCA. GARANT,, TECNOLOGIA ALEMANA', 44.96, 6, '2024-03-19 13:42:24', 3, 11, 1, 2, 'SIERRA_CINTA_LONGITUD_DE_2,362mm_(93,_FABRICACION_ESPECIAL),_DIENTE_M42,_COMBINADO,_MCA._GARANT,,_TECNOLOGIA_ALEMANA_90.jpg'),
(419, 'H-0209', 'BROCA DE CENTROS 1.6mm, EXTRA LARGA, ACERO AL COBALTO (HSS+E), MCA. GARANT. TECNOLOGIA ALEMANA', 26.80, 2, '2024-03-19 13:46:50', 3, 11, 1, 2, 'BROCA_DE_CENTROS_1.6mm,_EXTRA_LARGA,_ACERO_AL_COBALTO_(HSS+E),_MCA._GARANT._TECNOLOGIA_ALEMANA_31.jpg'),
(420, 'H-0210', 'BROCA DE CENTROS 3mm, EXTRA LARGA, ACERO AL COBALTO (HSS+E), MCA. GARANT. TECNOLOGIA ALEMANA.', 20.50, 2, '2024-03-19 13:48:03', 3, 11, 1, 2, 'BROCA_DE_CENTROS_3mm,_EXTRA_LARGA,_ACERO_AL_COBALTO_(HSS+E),_MCA._GARANT._TECNOLOGIA_ALEMANA._41.jpg'),
(421, 'MARC001-6J', 'TORNILLO PARA PANTALLA CENTRAL, TORNILLO SOCKET CILINDRO NEGRO NC- 10-24 x 3/8\"', 5.00, 65, '2024-03-21 14:49:06', 9, 13, 1, 1, 'TORNILLO_PARA_PANTALLA_CENTRAL_3_16_93.jpg'),
(422, 'MARC001-8E', 'OPRESOR 1/4\", ANILLO DE RETENCION 1/4\"', 4.00, 100, '2024-03-21 14:54:37', 9, 14, 1, 1, 'OPRESOR_14_41.jpg'),
(423, 'MARC001-8C', 'ORING PARA TRAVESAÑO, PERNOS, D.I 1.78 D.E. 5.34', 2.50, 150, '2024-03-21 15:28:26', 9, 13, 1, 1, 'ORING_PARA_TRAVESAÑO,_PERNOS_5.jpg'),
(424, 'MARC001-8X', 'MOCHILA PARA ARTICULADOR', 400.00, 149, '2024-03-22 14:52:12', 9, 4, 1, 1, 'MOCHILA_PARA_ARTICULADOR_93.jpg'),
(425, 'pru-001', 'prueba', 10.00, 2, '2024-03-29 23:14:07', 10, 4, 1, 1, 'prueba_93.png');
INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, `precio`, `stock`, `fecha_registro`, `id_categoria`, `id_proveedor`, `id_unidad`, `id_moneda`, `url_imagen`) VALUES
(426, 'H-0211', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 4.76mm (3/16\") longitud total 87mm, longitud de cuchilla de 44mm, Para escariar agujeros tolerancia H7, HSS DOMER', 45.00, 1, '2024-04-01 12:27:17', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_4_76mm_3_16_longitud_total_87mm_longitud_de_cuchilla_de_44mm_Para_escariar_agujeros_tolerancia_H7_HSS_DOMER_11.jpg'),
(427, 'H-0212', 'PRENSA ESQUINERA DE ALUMINIO 3\"', 233.80, 2, '2024-04-01 16:25:27', 1, 2, 1, 1, 'PRENSA_ESQUINERA_DE_ALUMINIO_3__60.jpg'),
(428, 'H-0213', 'LLAVE TORX T9 BANDERA', 105.00, 2, '2024-04-01 16:27:28', 1, 2, 1, 1, 'LLAVE_TORX_T9_BANDERA_39.jpg'),
(429, 'H-0214', 'LLAVE TORX T10 BANDERA', 105.00, 2, '2024-04-01 16:29:27', 1, 2, 1, 1, 'LLAVE_TORX_T10_BANDERA_79.jpg'),
(430, 'H-0215', 'CORTADOR VERTICAL 1/4 \", FILO 3/4\" LT DE 2-1/2\"', 520.00, 2, '2024-04-01 16:32:02', 3, 2, 1, 1, 'CORTADOR_VERTICAL_1_4_FILO_3_4_LT_DE_2_1_2__32.jpg'),
(431, 'H-0216', 'BROCA RECTA NUMERICA #9 CLEV', 56.00, 6, '2024-04-01 16:33:14', 3, 2, 1, 1, 'BROCA_RECTA_NUMERICA_9_CLEV_100.jpg'),
(432, 'H-0217', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 6.35mm (1/4\") longitud total de 100mm, longitud de cuchilla de 50mm, DORMER', 48.00, 1, '2024-04-02 16:02:04', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_6_35mm_1_4_longitud_total_de_100mm_longitud_de_cuchilla_de_50mm_DORMER_98.jpg'),
(433, 'H-0218', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 7.94mm (5/16\") longitud total de 115mm, longitud de cuchilla de 58mm, DORMER', 52.00, 1, '2024-04-02 16:03:50', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_7_94mm_5_16_longitud_total_de_115mm_longitud_de_cuchilla_de_58mm_DORMER_6.jpg'),
(434, 'H-0219', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 9.52mm (3/8\") longitud total de 124mm, longitud de cuchilla de 62mm, DORMER', 55.00, 1, '2024-04-02 16:05:04', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_9_52mm_3_8_longitud_total_de_124mm_longitud_de_cuchilla_de_62mm_DORMER_7.jpg'),
(435, 'H-0220', 'Escariador manual con cuchillas de hélice lenta a izquierda, diámetro 9.52mm\r\n(3/8\") longitud total de 124mm, longitud de cuchilla de 62mm, Para escariar\r\nagujeros tolerancia H7, HSS MCA. DORMER.', 55.00, 1, '2024-04-09 09:25:34', 3, 11, 1, 2, 'Escariador_manual_con_cuchillas_de_h_lice_lenta_a_izquierda_di_metro_9_52mm_3_8_longitud_total_de_124mm_longitud_de_cuchilla_de_62mm_Para_escariar_agujeros_tolerancia_H7_HSS_MCA_DORMER__5.jpg'),
(436, 'I-0054', 'Retazo de trapo blanco', 95.00, 20, '2024-04-09 09:48:44', 2, 16, 2, 1, 'Retazo_de_trapo_blanco_94.jpg'),
(437, 'I-0055', 'Gasolina blanca', 90.00, 20, '2024-04-09 09:49:57', 2, 16, 7, 1, 'Gasolina_blanca_38.jpg'),
(438, 'I-0056', 'Alcohol Isopropilico', 90.00, 20, '2024-04-09 09:51:15', 2, 13, 7, 1, 'Alcohol_Isopropilico_70.jpg'),
(439, 'I-0057', 'Thinner estandar', 70.00, 20, '2024-04-09 09:52:29', 2, 16, 7, 1, 'Thinner_estandar_41.jpg'),
(440, 'H-0221', 'CoroTurn® 107, herramienta con mango para torneado, zanco 3/4\" x 3/4\", a\r\nderecha, MCA. Sandvik', 186.50, 1, '2024-04-09 14:29:29', 3, 11, 1, 2, 'CoroTurn_107_herramienta_con_mango_para_torneado_zanco_3_4_x_3_4_a_derecha_MCA_Sandvik_55.jpg'),
(441, 'H-0222', 'Plaquita CoroTurn® 107 para torneado, acabado radio de punta 0.2mm, 2 filos,\r\nmaterial Aluminio, Marca Sandvik', 15.60, 10, '2024-04-09 14:33:37', 3, 11, 1, 2, 'Plaquita_CoroTurn_107_para_torneado_acabado_radio_de_punta_0_2mm_2_filos_material_Aluminio_Marca_Sandvik_35.jpg'),
(442, 'H-0223', 'Plaquita CoroTurn® 107 para torneado, acabado radio de punta 0.4mm, 2 filos,\r\nmaterial Inoxidable, Marca Sandvik', 19.98, 10, '2024-04-09 14:34:25', 3, 11, 1, 2, 'Plaquita_CoroTurn_107_para_torneado_acabado_radio_de_punta_0_4mm_2_filos_material_Inoxidable_Marca_Sandvik_12.jpg'),
(443, 'H-0224', 'CORTADOR RECTO DE CARBURO 1/8\" 4 FL ESTANDAR', 280.00, 2, '2024-04-11 13:42:16', 3, 2, 1, 1, 'CORTADOR_RECTO_DE_CARBURO_1_8_4_FL_ESTANDAR_37.jpg'),
(444, 'H-0225', 'Boquilla ER32 1/8\"', 539.00, 2, '2024-04-11 13:52:48', 3, 2, 1, 1, 'Boquilla_ER32_1_8__17.jpg'),
(445, 'H-0226', 'Boquilla ER40 1/8\"', 580.00, 1, '2024-04-11 14:02:19', 3, 2, 1, 1, 'Boquilla_ER40_1_8__6.jpg'),
(446, 'IC-0001', 'GU-352 Guante p/pintar talla mediano', 42.24, 1, '2024-04-11 16:09:50', 2, 17, 8, 1, 'GU_352_Guante_p_pintar_talla_mediano_9.jpg'),
(447, 'IC-0002', 'GU-352 Guante p/pintar talla mediano', 42.24, 1, '2024-04-11 16:11:41', 2, 17, 8, 1, 'GU_352_Guante_p_pintar_talla_mediano_42.jpg'),
(448, 'IC-0003', 'GU-121P Guante de nylon recubierto de nitrilo medianos', 28.45, 1, '2024-04-11 16:14:24', 2, 17, 8, 1, 'GU_121P_Guante_de_nylon_recubierto_de_nitrilo_medianos_57.jpg'),
(449, 'CI-0004', 'GU-122P Guante de nylon recubierto de nitrilo chicos', 28.45, 1, '2024-04-11 16:15:38', 2, 17, 8, 1, 'GU_122P_Guante_de_nylon_recubierto_de_nitrilo_chicos_68.jpg'),
(450, 'CI-0005', 'GU-113P Guante de nylon recubierto de poliuretano medianos', 25.00, 5, '2024-04-11 16:18:34', 2, 17, 8, 1, 'GU_113P_Guante_de_nylon_recubierto_de_poliuretano_medianos_57.jpg'),
(451, 'CI-0006', 'GU-112P Guante de nylon recubierto de poliuretano grandes', 25.00, 5, '2024-04-11 16:22:39', 2, 17, 8, 1, 'GU_112P_Guante_de_nylon_recubierto_de_poliuretano_grandes_86.jpg'),
(452, 'IC-0007', 'M-33X Cinta de aislar 19 mm x 18 m', 18.97, 5, '2024-04-12 14:52:57', 2, 17, 1, 1, 'M_33X_Cinta_de_aislar_19_mm_x_18_m_6.jpg'),
(453, 'H-0227', 'DR-1/4X6TP Desarmador Plano mango transparente 1/4\" X 6\"', 29.31, 1, '2024-04-12 15:00:03', 1, 17, 1, 1, 'DR_1_4X6TP_Desarmador_Plano_mango_transparente_1_4_X_6__12.jpg'),
(454, 'H-0228', 'DR-5/16X6TP Desarmador plano mango transparente 5/16\" x 6\" ', 42.24, 1, '2024-04-12 15:02:16', 1, 17, 1, 1, 'DR_5_16X6TP_Desarmador_plano_mango_transparente_5_16_x_6__39.jpg'),
(455, 'H-0229', 'DP-1/8X6 Desarmador phillips de 1/8\" x 6\"', 33.62, 1, '2024-04-12 15:03:40', 1, 17, 1, 1, 'DP_1_8X6_Desarmador_phillips_de_1_8_x_6__0.jpg'),
(456, 'H-0230', 'DP-3/16X6 Desarmador phillips de 3/16\" x 6\"', 42.24, 1, '2024-04-12 15:05:06', 1, 17, 1, 1, 'DP_3_16X6_Desarmador_phillips_de_3_16_x_6__54.jpg'),
(457, 'H-0231', 'DP-1/4X6 Desarmador phillips de 1/4\" X 6\"', 50.86, 1, '2024-04-12 15:06:48', 1, 17, 1, 1, 'DP_1_4X6_Desarmador_phillips_de_1_4_X_6__63.jpg'),
(458, 'H-0232', 'E-8X12 Escuadra cantero profesional 8\" x 12\" ', 59.49, 1, '2024-04-12 15:08:45', 1, 17, 1, 1, 'E_8X12_Escuadra_cantero_profesional_8_x_12__3.jpg'),
(459, 'IC-0008', 'CTR-150 Cinta transparente de 48 mm x 15M', 50.86, 2, '2024-04-15 10:15:12', 2, 17, 1, 1, 'CTR_150_Cinta_transparente_de_48_mm_x_15M_17.jpg'),
(460, 'IC-0009', 'CIN-1810N Cinchos negros de plástico de 100mm x 2.5mm paquete de 100 cinchos', 14.65, 4, '2024-04-15 10:21:33', 2, 17, 1, 1, 'CIN_1810N_Cinchos_negros_de_pl_stico_de_100mm_x_2_5mm_paquete_de_100_cinchos_97.jpg'),
(461, 'IC-0010', 'LIME-120 Lija de esmeril grano 120', 11.21, 10, '2024-04-15 10:25:29', 2, 17, 1, 1, 'LIME_120_Lija_de_esmeril_grano_120_12.jpg'),
(462, 'IC-0011', 'LIME-80 Lija de esmeril grano 80', 12.50, 4, '2024-04-15 10:28:02', 2, 17, 1, 1, 'LIME_80_Lija_de_esmeril_grano_80_46.jpg'),
(463, 'IC-0012', 'LIMER-120 Lija de esmeril grano 120 roja', 13.36, 11, '2024-04-15 10:30:05', 2, 17, 1, 1, 'LIMER_120_Lija_de_esmeril_grano_120_roja_1.jpg'),
(464, 'IC-0013', 'LIMER-100 Lija de esmeril grano 100', 13.36, 5, '2024-04-15 10:33:48', 2, 17, 1, 1, 'LIMER_100_Lija_de_esmeril_grano_100_36.jpg'),
(465, 'IC-0014', 'LIAG-600 Lija de agua grano 600', 7.33, 7, '2024-04-15 10:35:17', 2, 17, 1, 1, 'LIAG_600_Lija_de_agua_grano_600_4.jpg'),
(466, 'IC-0015', 'LIAG-240 Lija de agua grano 240', 7.33, 8, '2024-04-15 10:37:38', 2, 17, 1, 1, 'LIAG_240_Lija_de_agua_grano_240_36.jpg'),
(467, 'IC-0016', 'LIAG-180 Lija de agua grano 180', 7.33, 8, '2024-04-15 10:39:19', 2, 17, 1, 1, 'LIAG_180_Lija_de_agua_grano_180_29.jpg'),
(468, 'IC-0017', 'LIJA DE AGUA 120', 7.33, 7, '2024-04-15 10:42:04', 2, 17, 1, 1, 'LIJA_DE_AGUA_120_80.jpg'),
(469, 'IC-0018', 'LIJA DE AGUA 800', 7.33, 5, '2024-04-15 10:43:00', 2, 17, 1, 1, 'LIJA_DE_AGUA_800_51.jpg'),
(470, 'IC-0019', 'LIJA DE AGUA 1200', 7.33, 10, '2024-04-15 10:45:14', 2, 17, 1, 1, 'LIJA_DE_AGUA_1200_73.jpg'),
(471, 'IC-0020', 'LIJA DE AGUA 1500', 7.33, 9, '2024-04-15 10:46:47', 2, 17, 1, 1, 'LIJA_DE_AGUA_1500_26.jpg'),
(472, 'MARC001-6N', 'PERNO PARA CLIP, PERNO SOLIDO RECTIFICADO ACERO ALEADO 3/8\" X 1-1/4\"', 12.17, 50, '2024-04-15 15:45:02', 9, 14, 1, 1, 'PERNO_PARA_CLIP_PERNO_SOLIDO_RECTIFICADO_3_8_X_1_1_4__55.jpg'),
(473, 'MARC001-4M', 'PERNO CENTRADOR PARA CLIP, PERNO SOLIDO RECTIFICADO 1/8 \" X 1\"', 2.82, 100, '2024-04-15 16:21:38', 9, 14, 1, 1, 'PERNO_CENTRADOR_PARA_CLIP_PERNO_SOLIDO_RECTIFICADO_1_8_X_1__72.jpg'),
(474, 'MARC001-7Ñ', 'TORNILLO PARA CONECTOR, TORNILLO ALLEN SOCKET CILINDRO INOXIDABLE A2 M4x20M', 0.94, 50, '2024-04-15 16:25:37', 9, 14, 1, 1, 'TORNILLO_PARA_CONECTOR_TORNILLO_ALLEN_SOCKET_CILINDRO_INOXIDABLE_A2_M4x20M_90.jpg'),
(475, 'MARC001-5S', 'INSERTO, OPRESOR ALLEN INOXIDABLE A2 MILIMETRICO M5 X 6MM', 0.53, 450, '2024-04-15 16:36:20', 9, 14, 1, 1, 'INSERTO_OPRESOR_ALLEN_INOXIDABLE_A2_MILIMETRICO_M5_X_6M_8.jpg'),
(476, 'MARC001-6B', 'TORNILLO 1 (M3), TORNILLO ALLEN SOCKET CILINDRO INOXIDABLE A2 M3 x 6MM', 0.48, 200, '2024-04-16 09:20:16', 9, 14, 1, 1, 'TORNILLO_1_M3_TORNILLO_ALLEN_SOCKET_CILINDRO_INOXIDABLE_A2_M3_x_6MM_41.jpg'),
(477, 'MARC001-9B', 'LLAVE HEXAGONAL ALLEN TIPO \"L\" METRICA M3.0 (3MM)', 2.89, 50, '2024-04-16 09:39:42', 9, 14, 1, 1, 'LLAVE_EXAGONAL_ALLEN_TIPO_L_METRICA_M3_0_3MM__7.jpg'),
(478, 'MARC001-8Y', 'LLAVE EXAGONAL ALLEN TIPO \"L\" METRICA M2.5 (2.5MM)', 2.54, 40, '2024-04-16 09:41:37', 9, 14, 1, 1, 'LLAVE_EXAGONAL_ALLEN_TIPO_L_METRICA__43.jpg'),
(479, 'IC-0021', 'ADHESIVO EPOXICO EN JERINGA 25 ML (0.84 OZ) TRANSPARENTE 5 MINUTOS', 115.56, 2, '2024-04-16 09:47:27', 2, 14, 1, 1, 'ADHESIVO_EPOXICO_EN_JERINGA_25_ML_0_84_OZ_TRANSPARENTE_5_MINUTOS_43.jpg'),
(480, 'H-0233', 'MANERAL PARA MACHUELO AJUSTABLE 1/16\" A 3/8\"', 62.02, 1, '2024-04-16 09:51:08', 1, 14, 1, 1, 'MANERAL_PARA_MACHUELO_AJUSTABLE_1_16_A_3_8__20.jpg'),
(481, 'H-0234', 'MANERAL PARA MACHUELO AJUSTABLE 3/32\" A 3/8\"', 81.40, 1, '2024-04-16 09:52:07', 1, 14, 1, 1, 'MANERAL_PARA_MACHUELO_AJUSTABLE_3_32_A_3_8__31.jpg'),
(482, 'H-0235', 'CALIBRADOR VERNIER DIGITAL 152MM/0-6\" DE ACERO INOXIDABLE', 640.22, 1, '2024-04-16 09:53:29', 1, 14, 1, 1, 'CALIBRADOR_VERNIER_DIGITAL_152MM_0_6_DE_ACERO_INOXIDABLE_50.png'),
(483, 'MARC001-4T', 'SOPORTE ANALOGO ', 498.00, 20, '2024-04-16 11:12:49', 9, 19, 1, 1, 'SOPORTE_ANALOGO__29.png'),
(484, 'MARC001-8D', 'APUNTADOR ORBITAL', 95.00, 20, '2024-04-16 11:15:50', 9, 19, 1, 1, 'APUNTADOR_ORBITAL_72.png'),
(485, 'MARC001-7E', 'HORQUILLA DOBLADA', 90.00, 20, '2024-04-16 11:17:47', 9, 19, 1, 1, 'HORQUILLA_DOBLADA_13.png'),
(486, 'MARC001-7R', 'HORQUILLA PLANA', 70.00, 20, '2024-04-16 11:22:59', 9, 19, 1, 1, 'HORQUILLA_PLANA_64.png'),
(487, 'MARC001-7B', 'TIJERA DERECHA', 215.00, 20, '2024-04-16 11:36:02', 9, 19, 1, 1, 'TIJERA_DERECHA_74.png'),
(488, 'MARC001-7C', 'TIJERA IZQUIERDA', 215.00, 20, '2024-04-16 11:38:27', 9, 19, 1, 1, 'TIJERA_IZQUIERDA_61.png'),
(489, 'MARC001-4Q', 'SEGURO (CON DOBLES Y ACABADO)', 20.00, 20, '2024-04-16 11:39:52', 9, 19, 1, 1, 'SEGURO_CON_DOBLES_Y_ACABADO__10.png'),
(490, 'MARC001-4Z', 'LIGA (LIGA DE NITRILO 3/32 MEDIDA ESPECIAL)', 5.50, 1000, '2024-04-16 11:55:35', 9, 23, 1, 1, 'LIGA_LIGA_DE_NITRILO_3_32_MEDIDA_ESPECIAL__1.jpg'),
(491, 'MARC001-5C-MP', 'PERNO BOTADOR 3/16\" x 10\" PARA FABRICAR PERNO DE POSICION (3/16\" x .470\")', 46.00, 35, '2024-04-16 13:18:51', 6, 24, 1, 1, 'PERNO_BOTADOR_3_16_x_10_PARA_FABRICAR_PERNO_DE_POSICION_3_16_x_470__36.jpg'),
(492, 'MARC001-4B', 'BASE SUPERIOR PARA ANALOGO', 20.00, 24, '2024-04-17 14:51:51', 9, 3, 1, 1, 'BASE_SUPERIOR_PARA_ANALOGO_0.png'),
(493, 'MARC001-4C', 'NIVEL DE ALTURA', 15.00, 22, '2024-04-17 14:56:38', 9, 3, 1, 1, 'NIVEL_DE_ALTURA_78.png'),
(494, 'MARC001-4D', 'PERNO 1 PARA SOPORTE', 10.00, 72, '2024-04-17 14:59:38', 9, 3, 1, 1, 'PERNO_1_PARA_SOPORTE_56.png'),
(495, 'MARC001-4E', 'ANALOGO DERECHO', 12.00, 27, '2024-04-17 15:02:56', 9, 3, 1, 1, 'ANALOGO_DERECHO_34.png'),
(496, 'MARC001-4F', 'PERNO 2 PARA SOPORTE', 10.00, 72, '2024-04-17 15:06:16', 9, 3, 1, 1, 'PERNO_2_PARA_SOPORTE_95.png'),
(497, 'MARC001-4G', 'CONDILO PARA ANALOGO', 6.00, 0, '2024-04-17 15:08:25', 9, 3, 1, 1, 'CONDILO_PARA_ANALOGO_25.png'),
(498, 'MARC001-4H', 'ANALOGO IZQUIERDO', 12.00, 45, '2024-04-17 15:15:17', 9, 3, 1, 1, 'ANALOGO_IZQUIERDO_97.png'),
(499, 'MARC001-4N', 'CLIP', 12.00, 116, '2024-04-17 15:23:46', 9, 26, 1, 1, 'CLIP_100.png'),
(500, 'MARC001-4P', 'POSICIONADOR DENTAL', 10.00, 0, '2024-04-17 15:37:34', 9, 3, 1, 1, 'POSICIONADOR_DENTAL_22.png'),
(501, 'MARC001-4R', 'ETIQUETA LADO IZQUIERDO', 3.00, 60, '2024-04-17 15:42:06', 9, 4, 1, 1, 'ETIQUETA_LADO_IZQUIERDO_100.png'),
(502, 'MARC001-4S', 'ETIQUETA LADO DERECHO', 3.00, 60, '2024-04-17 15:47:21', 9, 4, 1, 1, 'ETIQUETA_LADO_DERECHO_72.png'),
(503, 'MARC001-4Y', 'RESORTE', 10.00, 46, '2024-04-17 15:54:58', 9, 4, 1, 1, ''),
(504, 'MARC001-5N', 'PORTA IMAN', 5.00, 0, '2024-04-17 16:22:57', 9, 3, 1, 1, 'PORTA_IMAN_7.png'),
(505, 'MARC001-5P', 'PIN DE MARCA PARA CONDILO', 1.00, 15, '2024-04-17 16:26:50', 9, 3, 1, 1, 'PIN_DE_MARCA_PARA_CONDILO_61.png'),
(506, 'MARC001-6C', 'TORNILLO PARA NIVEL DE ALTURA', 10.00, 0, '2024-04-17 16:37:24', 9, 3, 1, 1, 'TORNILLO_PARA_NIVEL_DE_ALTURA_28.png'),
(507, 'MARC001-6K', 'TORNILLO PARA BASE INFERIOR (TORNILLO SOCKET PLANA INOXIDABLE ESTANDAR - 10-24 X 3/8\")', 1.10, 395, '2024-04-17 16:49:45', 9, 14, 1, 1, 'TORNILLO_PARA_BASE_INFERIOR_TORNILLO_SOCKET_PLANA_INOXIDABLE_ESTANDAR_10_24_X_3_8__37.png'),
(508, 'H-0236', 'Fresa de punta esférica, 2 canales, diámetro corte 1/16\", longitud decorte 1/4\", Longitud total 1-1/2\", radio completo 1/32\", zanco cilíndrico1/8\", metal duro en acabado brillante,', 19.50, 5, '2024-04-19 12:23:19', 3, 11, 1, 2, 'Fresa_de_punta_esf_rica_2_canales_di_metro_corte_1_16_longitud_decorte_1_4_Longitud_total_1_1_2_radio_completo_1_32_zanco_cil_ndrico1_8_metal_duro_en_acabado_brillante__47.jpg'),
(509, 'H-0237', 'BROCA DE CENTROS N1, 9437925KL25SW7', 6.42, 5, '2024-04-19 13:01:23', 3, 11, 1, 2, 'BROCA_DE_CENTROS_N1_9437925KL25SW7_85.jpg'),
(510, 'H-0238', 'MACHUELO HELICOIDAL 1/8-40, 3KL792579SRHG4 ', 50.82, 5, '2024-04-19 13:37:19', 3, 11, 1, 2, 'MACHUELO_HELICOIDAL_1_8_40_3KL792579SRHG4__55.jpg'),
(511, 'H-0239', 'BROCA HSS NUMERICA 37, ASRHG434343KLB ', 2.19, 18, '2024-04-19 13:54:33', 3, 11, 1, 2, 'BROCA_HSS_NUMERICA_37_ASRHG434343KLB__5.jpg'),
(512, 'H-0240', 'BROCA HSS NUMERICA 38, R79792579SRMMS ', 2.19, 18, '2024-04-19 13:57:26', 3, 11, 1, 2, 'BROCA_HSS_NUMERICA_38_R79792579SRMMS__59.jpg'),
(513, 'H-0241', 'Extensión reforzada aterrizada 8 m 3x14 AWG, Volteck', 219.82, 1, '2024-04-19 14:19:24', 5, 17, 1, 1, 'Extensi_n_reforzada_aterrizada_8_m_3x14_AWG_Volteck_48.jpg'),
(514, 'H-0242', 'Extensión reforzada aterrizada 4 m 3x14 AWG, Volteck', 107.75, 1, '2024-04-19 15:06:11', 5, 17, 1, 1, 'Extensi_n_reforzada_aterrizada_4_m_3x14_AWG_Volteck_98.jpg'),
(515, 'H-0243', 'Pinza de presión 9\", punta larga, Truper', 139.65, 1, '2024-04-19 15:20:55', 1, 17, 1, 1, 'Pinza_de_presi_n_9_punta_larga_Truper_30.jpg'),
(516, 'H-0244', 'Lima redonda muza 8\", Truper', 38.79, 2, '2024-04-19 15:26:14', 1, 17, 1, 1, 'Lima_redonda_muza_8_Truper_49.jpg'),
(517, 'H-0245', 'Lima redonda muza 10\", Truper', 53.44, 1, '2024-04-19 15:27:37', 1, 17, 1, 1, 'Lima_redonda_muza_10_Truper_12.jpg'),
(518, 'H-0246', 'Lima media caña muzas 8\", Truper', 62.06, 1, '2024-04-19 15:29:15', 1, 17, 1, 1, 'Lima_media_ca_a_muzas_8_Truper_39.jpg'),
(519, 'H-0247', 'Lima media caña muzas 10\", Truper', 111.20, 1, '2024-04-19 15:38:48', 1, 17, 1, 1, 'Lima_media_ca_a_muzas_10_Truper_42.jpg'),
(520, 'H-0248', 'Cinta de empaque 48 mm x 150 m transparente, Pretul', 37.93, 6, '2024-04-19 15:40:03', 2, 17, 1, 1, 'Cinta_de_empaque_48_mm_x_150_m_transparente_Pretul_33.jpg'),
(521, 'H-0249', 'Pinza punta recta 7\" para abrir anillos, mango de PVC', 171.55, 1, '2024-04-19 15:42:48', 1, 17, 1, 1, 'Pinza_punta_recta_7_para_abrir_anillos_mango_de_PVC_87.jpg'),
(522, 'H-0250', 'Lija de agua grano 240 de carburo de silicio, Truper', 7.32, 6, '2024-04-19 15:43:52', 2, 17, 1, 1, 'Lija_de_agua_grano_240_de_carburo_de_silicio_Truper_10.jpg'),
(523, 'H-0251', 'ACTUALIZAR', 0.00, 0, '2024-04-19 15:46:07', 10, 17, 1, 1, 'Lija_de_agua_grano_120_de_carburo_de_silicio_Truper_39.jpg'),
(524, 'H-0252', 'Lija de agua grano 280 de carburo de silicio, Truper', 7.32, 4, '2024-04-19 15:47:20', 2, 17, 1, 1, 'Lija_de_agua_grano_280_de_carburo_de_silicio_Truper_57.jpg'),
(525, 'MARC001-6Ñ', 'CAMISA 1 (1/4\"), D.I. .250\", D.E. .350\" L. .500\"  MP-VC-250-8', 0.07, 980, '2024-04-22 10:17:42', 9, 10, 1, 2, 'CAMISA_1_1_4_D_I_250_D_E_350_L_500_MP_VC_250_8_58.png'),
(526, 'MARC001-6P', 'CAMISA 2, D.I. 0.437\", D.E. 0.560\", L. 1\", MP-VC-437-16', 0.14, 2480, '2024-04-22 10:21:30', 9, 10, 1, 2, 'CAMISA_2_D_I_0_437_D_E_0_560_L_1_MP_VC_437_16_42.png'),
(527, 'MARC001-6Q', 'ORING PARA CONDILO, D.I. 0.74mm, D.E. 2.78mm', 0.50, 95, '2024-04-22 10:27:31', 9, 4, 1, 1, 'ORING_PARA_CONDILO_D_I_0_74mm_D_E_2_78mm_84.png'),
(528, 'MARC001-6R', 'SOPORTE HORIZONTAL PARA HORQUILLA', 15.00, 0, '2024-04-22 10:35:21', 9, 3, 1, 1, 'SOPORTE_HORIZONTAL_PARA_HORQUILLA_57.png'),
(529, 'MARC001-6S', 'VARILLA VERTICAL PARA NIÑOS', 15.00, 0, '2024-04-22 10:38:21', 9, 3, 1, 1, 'VARILLA_VERTICAL_PARA_NI_OS_53.png'),
(530, 'MARC001-6T', 'TORNILLO PARA VARILLA DE SOPORTE', 15.00, 0, '2024-04-22 10:40:27', 9, 3, 1, 1, 'TORNILLO_PARA_VARILLA_DE_SOPORTE_20.png'),
(531, 'MARC001-6X', 'PERNO PARA CENTRADOR ANALOGO, PERNO SOLIDO RECTIFICADO ACERO INOXIDABLE, 1/16\" x 7/16\"', 7.48, 49, '2024-04-22 10:50:48', 9, 14, 1, 1, 'PERNO_PARA_CENTRADOR_ANALOGO_0.png'),
(532, 'MARC001-6Y', 'BASE DE CALIBRACION SUPERIOR ANALOGO', 75.00, 0, '2024-04-22 10:59:55', 9, 3, 1, 1, 'BASE_DE_CALIBRACION_SUPERIOR_ANALOGO_63.png'),
(533, 'MARC001-6Z', 'BASE DE CALIBRACION INFERIOR ANALOGO', 75.00, 0, '2024-04-22 11:02:27', 9, 3, 1, 1, 'BASE_DE_CALIBRACION_INFERIOR_ANALOGO_87.png'),
(534, 'MARC001-7A', 'TRAVESAÑO PARA ARCO', 25.00, 0, '2024-04-22 11:04:26', 9, 3, 1, 1, 'TRAVESA_O_PARA_ARCO_7.png'),
(535, 'MARC001-7F', 'TORNILLO PARA TRAVESAÑO', 10.00, 0, '2024-04-22 11:07:35', 9, 3, 1, 1, 'TORNILLO_PARA_TRAVESA_O_26.png'),
(536, 'MARC001-7G', 'VARILLA VERTICAL PARA HORQUILLA', 25.00, 0, '2024-04-22 11:12:15', 9, 3, 1, 1, 'VARILLA_VERTICAL_PARA_HORQUILLA_63.png'),
(537, 'MARC001-7H', 'TORNILLO PARA APUNTADOR ORBITAL', 10.00, 0, '2024-04-22 11:15:29', 9, 3, 1, 1, 'TORNILLO_PARA_APUNTADOR_ORBITAL_12.png'),
(538, 'MARC001-7J', 'MESA DE TRANSFERENCIA', 15.00, 0, '2024-04-22 11:17:49', 9, 3, 1, 1, 'MESA_DE_TRANSFERENCIA_61.png'),
(539, 'MARC001-7N', 'VARILLA PARA POSICIONADOR NASAL', 25.00, 0, '2024-04-22 11:21:00', 9, 3, 1, 1, 'VARILLA_PARA_POSICIONADOR_NASAL_49.png'),
(540, 'MARC001-7P', 'NIVEL DE GOTA', 4.00, 85, '2024-04-22 11:23:59', 9, 4, 1, 1, 'NIVEL_DE_GOTA_70.png'),
(541, 'MARC001-7Q', 'RONDANA GROWER, RONDANA ESTRELLA EXTERIOR GALVANIZADA - #10', 0.28, 1030, '2024-04-22 11:37:02', 9, 14, 1, 1, 'RONDANA_GROWER_RONDANA_ESTRELLA_EXTERIOR_GALVANIZADA_10_52.png'),
(542, 'MARC001-7S', 'VARILLA PARA HORQUILLA', 25.00, 0, '2024-04-22 11:42:56', 9, 19, 1, 1, 'VARILLA_PARA_HORQUILLA_18.png'),
(543, 'MARC001-7X', 'PERNO AJUSTADOR CHICO', 5.00, 0, '2024-04-22 11:45:10', 9, 3, 1, 1, 'PERNO_AJUSTADOR_CHICO_18.png'),
(544, 'MARC001-7Z', 'PERNO AJUSTADOR MEDIANO', 20.00, 0, '2024-04-22 11:47:15', 9, 3, 1, 1, 'PERNO_AJUSTADOR_MEDIANO_67.png'),
(545, 'MARC001-8B', 'APOYADOR NASAL', 8.00, 0, '2024-04-22 11:49:22', 9, 3, 1, 1, 'APOYADOR_NASAL_12.png'),
(546, 'MARC001-8F', 'TORNILLO PARA POSICIONADOR NASAL', 5.00, 0, '2024-04-22 11:52:31', 9, 3, 1, 1, 'TORNILLO_PARA_POSICIONADOR_NASAL_14.png'),
(547, 'MARC001-8G', 'TORNILLO FIJACION TIJERAS', 8.00, 0, '2024-04-22 11:55:38', 9, 3, 1, 1, 'TORNILLO_FIJACION_TIJERAS_16.png'),
(548, 'MARC001-8H', 'ETIQUETA CPI', 5.00, 5000, '2024-04-22 11:59:33', 9, 4, 1, 1, 'ETIQUETA_CPI_92.png'),
(549, 'MARC001-8J', 'HOJA DE TRABAJO', 5.00, 200, '2024-04-22 12:04:49', 9, 4, 1, 1, 'HOJA_DE_TRABAJO_66.png'),
(550, 'MARC001-8K', 'MANUAL CPI', 0.00, 0, '2024-04-22 12:06:41', 9, 4, 1, 1, 'MANUAL_CPI_28.png'),
(551, 'MARC001-8M', 'MANUAL DE CALIBRACION CPI', 0.00, 0, '2024-04-22 12:08:17', 9, 4, 1, 1, 'MANUAL_DE_CALIBRACION_CPI_31.png'),
(552, 'MARC001-8N', 'MANUAL ANALOGO', 0.00, 0, '2024-04-22 12:10:06', 9, 4, 1, 1, 'MANUAL_ANALOGO_25.png'),
(553, 'MARC001-8Ñ', 'MANUAL CALIBRACION ANALOGO', 0.00, 0, '2024-04-22 12:11:40', 9, 4, 1, 1, 'MANUAL_CALIBRACION_ANALOGO_36.png'),
(554, 'MARC001-8P', 'BASE', 5.00, 0, '2024-04-22 12:12:58', 9, 3, 1, 1, 'BASE_63.png'),
(555, 'MARC001-8Q', 'BASE MOVIL', 10.00, 0, '2024-04-22 12:14:51', 9, 3, 1, 1, 'BASE_MOVIL_64.png'),
(556, 'MARC001-8R', 'VARILLA VERTICAL PA', 10.00, 0, '2024-04-22 12:16:54', 9, 3, 1, 1, 'VARILLA_VERTICAL_PA_36.png'),
(557, 'MARC001-8S', 'PERNO', 6.00, 0, '2024-04-22 12:19:23', 9, 3, 1, 1, 'PERNO_45.png'),
(558, 'MARC001-8T', 'MANUAL ARCO FACIAL', 0.00, 0, '2024-04-22 12:21:09', 9, 4, 1, 1, 'MANUAL_ARCO_FACIAL_53.png'),
(559, 'MARC001-8W', 'MANUAL CALIBRACION ARCO FACIAL', 0.00, 0, '2024-04-22 12:22:52', 9, 4, 1, 1, 'MANUAL_CALIBRACION_ARCO_FACIAL_0.png'),
(560, 'MARC001-8Z', 'HORQUILLA PARA NIÑOS', 30.00, 0, '2024-04-22 13:14:51', 9, 19, 1, 1, ''),
(561, 'MARC001-9A', 'TORNILLO PARA CONDILO, TORNILLO CABEZA BOTON ALLEN 1/8\" X 1/2\"', 1.00, 500, '2024-04-22 13:46:27', 9, 14, 1, 1, 'TORNILLO_PARA_CONDILO_TORNILLO_CABEZA_BOTON_ALLEN_1_8_X_1_2__82.jpg'),
(562, 'H-0253', 'VASTAGO MITUTOYO AM GAGE', 97.50, 2, '2024-04-24 11:47:09', 3, 11, 1, 2, 'VASTAGO_MITUTOYO_AM_GAGE_90.jpg'),
(563, 'H-0254', 'Cortador largo, 4 gavilanes, diámetro corte 3/8\", longitud de corte 1\", longitud total 4\", longitud zanco reducido 1-3/8\", CARBURO, hélice 30°, para fresado profundo.', 124.50, 4, '2024-04-24 11:49:45', 3, 11, 1, 2, 'Cortador_largo_4_gavilanes_di_metro_corte_3_8_longitud_de_corte_1_longitud_total_4_longitud_zanco_reducido_1_3_8_CARBURO_h_lice_30_para_fresado_profundo__94.jpg'),
(564, 'H-0255', 'Cortador largo, 4 gavilanes, diámetro corte 1/4\", longitud de corte 1\", longitud total 4\", longitud zanco reducido 1-1/4\", CARBURO, hélice 30°, para fresado profundo.', 89.50, 4, '2024-04-24 11:52:01', 3, 11, 1, 2, 'Cortador_largo_4_gavilanes_di_metro_corte_1_4_longitud_de_corte_1_longitud_total_4_longitud_zanco_reducido_1_1_4_CARBURO_h_lice_30_para_fresado_profundo__99.jpg'),
(565, 'H-0256', 'MACHUELO HELICOIDAL 5-40', 764.10, 4, '2024-04-24 14:30:27', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_5_40_97.jpg'),
(566, 'H-0257', 'RIMA RECTA 1/8\"', 675.00, 2, '2024-04-24 14:36:11', 3, 2, 1, 1, 'RIMA_RECTA_1_8__29.jpg'),
(567, 'H-0258', 'MACHUELO HELICOIDAL 3/8\" - 24 ', 680.00, 1, '2024-04-24 14:38:09', 3, 2, 1, 1, 'MACHUELO_HELICOIDAL_3_8_24__34.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_cpi_art_af`
--

CREATE TABLE `productos_cpi_art_af` (
  `id_producto` int(11) NOT NULL,
  `id_cpi_art_af` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_cpi_art_af`
--

INSERT INTO `productos_cpi_art_af` (`id_producto`, `id_cpi_art_af`) VALUES
(340, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `RFC_proveedor` varchar(13) NOT NULL,
  `email_proveedor` varchar(255) DEFAULT NULL,
  `telefono_proveedor` varchar(50) DEFAULT NULL,
  `direccion_proveedor` text DEFAULT NULL,
  `contacto_proveedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `RFC_proveedor`, `email_proveedor`, `telefono_proveedor`, `direccion_proveedor`, `contacto_proveedor`) VALUES
(1, 'MAPI', 'LOMG900317UX8', 'mapiventas@outlook.com, mapifacturas@outlook.com', '5516579866, 5511629508', 'Torre Ladera, Lt 19/Mz 202, Santa María Guadalupe las Torres 1a Sección, 54743,\nCuautitlán Izcalli, Cuautitlán Izcalli, Estado de México, México', 'David Castro Monroy'),
(2, 'HIGHER-TOOLS', 'HTO150907A20', 'ventas1@higher-tools.com, facturacion@higher-tools.com', '5545022954, 5556087437', '5 DE MAYO, MANZANA 28 LOTE 8, LOS REYES CULHUACAN, 09840, ENTRE CALLE\nTIZOC Y ATZAYACATL, IZTAPALAPA, CIUDAD DE MÉXICO, México', 'Andres Tello Hurtado'),
(3, 'MAQUINADOS', '', 'sup_maquinados@borgatta.com.mx', 'ext. 418', NULL, 'Luis Antonio'),
(4, 'COMPRAS EXTERNAS', '', NULL, NULL, NULL, ''),
(5, 'TONY PAPELERIA', '', NULL, NULL, NULL, ''),
(10, 'MICRO PARTES', 'MPM060610BR1', ' aramirez@micropartes.com.mx', '8127453490', 'Calle: NUEVA YORK No. 4003, Col. INDUSTRIAL HABITACIONAL ABRAHAM LINCOLN, CP: 64310, MONTERREY , NUEVO LEON, MEXICO', 'Azeneth Ramirez '),
(11, 'DISTRIBUIDORA DE HERRAMIENTAS INGHECO S DE RL DE CV', 'DHI160120JA1', 'francisco.gonzalez@ingheco.com.mx', '5519531412', 'Calle y número: Avenida Hacienda El Roble Mz. 5 Lt. 31 Cond. 70 Int. 297\r\nColonia: Hacienda Cuautitlán Delegación y Municipio: Cuautitlán México\r\nCódigo postal: 54803 Entidad Federativa: Estado de México', 'Francisco Gonzalez Gutierrez'),
(12, 'Quantum', 'PMI190325T31', 'thalia.zilch@gpoquantum.com', '5574615084', 'Jorge Washington No 2 PB Col Moderna CP 03510 Ciudad de Mexico Benito Juarez Ciudad de Mexico Mexico', 'Thalia M Zilch Cruz'),
(13, 'FIJATEC CITY', 'FCI110511SV8', 'city@fijatec.com', '5555617279', 'Av Azcapotzalco No 742  local A', 'Edgar Medina'),
(14, 'TORNILLOS TOREC FRANCISCO JOEL CELIS MORALES', 'CEMF971008948', 'ventas1@torec.mx', '3323940278', 'AV. ADOLFO LOPEZ MATEOS SUR 1310 CP. 44500 CHAPALITA GUADALAJARA JALISCO', 'DIEGO ALBERTO BARAJAS MARTINEZ'),
(15, 'INDUSTRIA ANODIZADORA NACIONAL', 'rfc', 'electropintarq@gmail.com', '5572580254', 'San Francisco 3 col San Francisco Tlaltenco Tlahuac 13400 CDMX Mexico', 'Sergio Hernandez'),
(16, 'FRANCISCO PAEZ RAMIREZ', 'PARF710917AZ1', 'paez.francisco@gmail.com', '5614303630', 'Sin direccion', 'Francisco Paez Ramirez'),
(17, 'FIX FERRETERIA 95 94 MEXICO', 'NMQ050902HW8', 'comprasonline@fixferreterias.com', '5516723590', 'Direccion: Lago Alberto Exterior: 442 T A, Interior: Nivel 7\r\nCol: Anáhuac I Sección\r\nDelegación:Miguel Hidalgo\r\nMéxico, Ciudad de México\r\nC.P.: 54170', 'COMPRAS POR INTERNET'),
(18, 'Marco Antonio Garcia Chavez', 'GACM690326AA5', 'garciachavezmarcoantonio69@gmail.com', '5546744164', 'No definida', 'Marco Antonio Garcia Chavez'),
(19, 'METAL ARTS (ISRAEL EDMUNDO AÑVAREZ ALVAREZ)', 'AAAI8001235ZA', 'PORDEFINIR@GMAIL.COM', '55555555', 'IZTAPALAPA', 'ISRAEL EDMUNDO ALVEREZ ALVAREZ'),
(23, 'CAJAS Y SERVICIOS MELGAR', 'MERP850326HY2', 'PORDEFINIR2@GMAIL.COM', '558862538', 'AV. INDEPENDENCIA 1 CERRO DEL TEJOLOTE CD 56567 IXTAPALUCA ESTADO DE MEXICO', 'PEDRO MEJIA RAMIREZ'),
(24, 'CPACSA COMERCIALIZADORA DE PORTATROQUELES Y ACCESORIOS', 'CPT840820M37', 'daniel@cpacsa.com', '5557524551', 'AV 45 METROS N.651 SAN BARTOLO ATEPEHUACAN CP. 07730 GUSTAVO A MADERO CIUDAD DE MEXICO', 'DANIEL'),
(25, 'INNOVATEC', 'IPR910118NJ5', 'ventas@imanesdemexico.com', '018183330709', 'WASHINGTON 2712 PTE. COL. DEPORTOVP OBISPADO MONTERREY, N.L. 64040 MEXICO', 'MAURICIO BOLADO'),
(26, 'FERNANDO SAUL VALERO ARIAS', 'VAAF700813PWA', 'saul.valero@hotmail.com', '5593132882', 'Circuito Hacienda de San Pablo N° Ext.Mz 19 Lt\r\n68 A CP.50870,Temoaya,México,México', 'FERNANDO SAUL VALERO ARIAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_almacen`
--

CREATE TABLE `stock_almacen` (
  `id_producto` int(11) NOT NULL,
  `id_almacen` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock_almacen`
--

INSERT INTO `stock_almacen` (`id_producto`, `id_almacen`, `stock`) VALUES
(1, 1, 6),
(1, 2, 0),
(1, 3, 0),
(44, 1, 1),
(44, 2, 0),
(44, 3, 0),
(45, 1, 2),
(45, 2, 0),
(45, 3, 0),
(47, 1, 1),
(47, 2, 0),
(47, 3, 0),
(48, 1, 1),
(48, 2, 1),
(48, 3, 0),
(49, 1, 0),
(49, 2, 2),
(49, 3, 0),
(50, 1, 9),
(50, 2, 1),
(50, 3, 0),
(51, 1, 2),
(51, 2, 0),
(51, 3, 0),
(53, 1, 2),
(53, 2, 0),
(53, 3, 0),
(54, 1, 4),
(54, 2, 0),
(54, 3, 0),
(55, 1, 1),
(55, 2, 0),
(55, 3, 0),
(56, 1, 1),
(56, 2, 0),
(56, 3, 0),
(57, 1, 1),
(57, 2, 0),
(57, 3, 0),
(58, 1, 1),
(58, 2, 0),
(58, 3, 0),
(59, 1, 0),
(59, 2, 0),
(59, 3, 0),
(60, 1, 4),
(60, 2, 1),
(60, 3, 0),
(61, 1, 4),
(61, 2, 0),
(61, 3, 0),
(63, 1, 11),
(63, 2, 0),
(63, 3, 0),
(64, 1, 9),
(64, 2, 0),
(64, 3, 0),
(65, 1, 2),
(65, 2, 0),
(65, 3, 0),
(67, 1, 2),
(67, 2, 0),
(67, 3, 0),
(70, 1, 2),
(70, 2, 0),
(70, 3, 0),
(71, 1, 3),
(71, 2, 0),
(71, 3, 0),
(72, 1, 2),
(72, 2, 0),
(72, 3, 0),
(74, 1, 5),
(74, 2, 0),
(74, 3, 0),
(75, 1, 0),
(75, 2, 0),
(75, 3, 0),
(76, 1, 0),
(76, 2, 0),
(76, 3, 0),
(77, 1, 0),
(77, 2, 0),
(77, 3, 0),
(80, 1, 0),
(80, 2, 0),
(80, 3, 0),
(81, 1, 0),
(81, 2, 0),
(81, 3, 0),
(82, 1, 20),
(82, 2, 0),
(82, 3, 0),
(83, 1, 15),
(83, 2, 0),
(83, 3, 0),
(84, 1, 4),
(84, 2, 5),
(84, 3, 0),
(86, 1, 10),
(86, 2, 0),
(86, 3, 0),
(87, 1, 5),
(87, 2, 0),
(87, 3, 0),
(88, 1, 5),
(88, 2, 0),
(88, 3, 0),
(89, 1, 10),
(89, 2, 0),
(89, 3, 0),
(91, 1, 4),
(91, 2, 0),
(91, 3, 0),
(92, 1, 7),
(92, 2, 0),
(92, 3, 0),
(93, 1, 2),
(93, 2, 0),
(93, 3, 0),
(94, 1, 4),
(94, 2, 0),
(94, 3, 0),
(95, 1, 0),
(95, 2, 0),
(95, 3, 0),
(96, 1, 2),
(96, 2, 0),
(96, 3, 0),
(97, 1, 2),
(97, 2, 0),
(97, 3, 0),
(98, 1, 1),
(98, 2, 0),
(98, 3, 0),
(99, 1, 1),
(99, 2, 0),
(99, 3, 0),
(100, 1, 1),
(100, 2, 0),
(100, 3, 0),
(101, 1, 4),
(101, 2, 0),
(101, 3, 0),
(102, 1, 15),
(102, 2, 0),
(102, 3, 0),
(103, 1, 5),
(103, 2, 0),
(103, 3, 0),
(104, 1, 3),
(104, 2, 0),
(104, 3, 0),
(105, 1, 14),
(105, 2, 0),
(105, 3, 0),
(106, 1, 4),
(106, 2, 0),
(106, 3, 0),
(107, 1, 3),
(107, 2, 0),
(107, 3, 0),
(109, 1, 5),
(109, 2, 0),
(109, 3, 0),
(110, 1, 9),
(110, 2, 0),
(110, 3, 0),
(111, 1, 10),
(111, 2, 0),
(111, 3, 0),
(112, 1, 7),
(112, 2, 1),
(112, 3, 0),
(114, 1, 7),
(114, 2, 0),
(114, 3, 0),
(115, 1, 15),
(115, 2, 0),
(115, 3, 0),
(116, 1, 4),
(116, 2, 0),
(116, 3, 0),
(117, 1, 1),
(117, 2, 0),
(117, 3, 0),
(118, 1, 5),
(118, 2, 0),
(118, 3, 0),
(119, 1, 11),
(119, 2, 0),
(119, 3, 0),
(120, 1, 1),
(120, 2, 0),
(120, 3, 0),
(121, 1, 1),
(121, 2, 0),
(121, 3, 0),
(122, 1, 5),
(122, 2, 0),
(122, 3, 0),
(123, 1, 14),
(123, 2, 0),
(123, 3, 0),
(124, 1, 2),
(124, 2, 0),
(124, 3, 0),
(125, 1, 1),
(125, 2, 0),
(125, 3, 0),
(126, 1, 1),
(126, 2, 0),
(126, 3, 0),
(127, 1, 1),
(127, 2, 0),
(127, 3, 0),
(128, 1, 34),
(128, 2, 0),
(128, 3, 0),
(129, 1, 16),
(129, 2, 0),
(129, 3, 0),
(130, 1, 2),
(130, 2, 0),
(130, 3, 0),
(131, 1, 1),
(131, 2, 0),
(131, 3, 0),
(132, 1, 1),
(132, 2, 0),
(132, 3, 0),
(133, 1, 10),
(133, 2, 0),
(133, 3, 0),
(134, 1, 13),
(134, 2, 0),
(134, 3, 0),
(136, 1, 11),
(136, 2, 0),
(136, 3, 0),
(137, 1, 2),
(137, 2, 0),
(137, 3, 0),
(138, 1, 1),
(138, 2, 0),
(138, 3, 0),
(139, 1, 1),
(139, 2, 0),
(139, 3, 0),
(140, 1, 9),
(140, 2, 0),
(140, 3, 0),
(141, 1, 3),
(141, 2, 0),
(141, 3, 0),
(143, 1, 2),
(143, 2, 0),
(143, 3, 0),
(144, 1, 2),
(144, 2, 0),
(144, 3, 0),
(145, 1, 2),
(145, 2, 0),
(145, 3, 0),
(146, 1, 1),
(146, 2, 0),
(146, 3, 0),
(147, 1, 1),
(147, 2, 0),
(147, 3, 0),
(148, 1, 2),
(148, 2, 0),
(148, 3, 0),
(149, 1, 1),
(149, 2, 0),
(149, 3, 0),
(150, 1, 1),
(150, 2, 0),
(150, 3, 0),
(151, 1, 6),
(151, 2, 0),
(151, 3, 0),
(152, 1, 1),
(152, 2, 0),
(152, 3, 0),
(153, 1, 1),
(153, 2, 0),
(153, 3, 0),
(154, 1, 6),
(154, 2, 0),
(154, 3, 0),
(155, 1, 1),
(155, 2, 0),
(155, 3, 0),
(156, 1, 2),
(156, 2, 0),
(156, 3, 1),
(158, 1, 2),
(158, 2, 0),
(158, 3, 0),
(162, 1, 4),
(162, 2, 0),
(162, 3, 0),
(163, 1, 1),
(163, 2, 0),
(163, 3, 0),
(164, 1, 1),
(164, 2, 0),
(164, 3, 0),
(165, 1, 10),
(165, 2, 0),
(165, 3, 0),
(166, 1, 2),
(166, 2, 0),
(166, 3, 0),
(167, 1, 1),
(167, 2, 0),
(167, 3, 0),
(168, 1, 8),
(168, 2, 0),
(168, 3, 0),
(170, 1, 1),
(170, 2, 0),
(170, 3, 0),
(171, 1, 2),
(171, 2, 0),
(171, 3, 0),
(175, 1, 1),
(175, 2, 0),
(175, 3, 0),
(178, 1, 1),
(178, 2, 0),
(178, 3, 0),
(179, 1, 0),
(179, 2, 0),
(179, 3, 1),
(180, 1, 1),
(180, 2, 0),
(180, 3, 0),
(181, 1, 1),
(181, 2, 0),
(181, 3, 0),
(182, 1, 1),
(182, 2, 0),
(182, 3, 0),
(183, 1, 0),
(183, 2, 1),
(183, 3, 0),
(184, 1, 1),
(184, 2, 0),
(184, 3, 0),
(185, 1, 0),
(185, 2, 1),
(185, 3, 0),
(186, 1, 1),
(186, 2, 0),
(186, 3, 0),
(187, 1, 1),
(187, 2, 0),
(187, 3, 0),
(188, 1, 1),
(188, 2, 0),
(188, 3, 0),
(189, 1, 0),
(189, 2, 0),
(189, 3, 1),
(190, 1, 1),
(190, 2, 0),
(190, 3, 0),
(191, 1, 0),
(191, 2, 1),
(191, 3, 0),
(192, 1, 1),
(192, 2, 0),
(192, 3, 0),
(193, 1, 2),
(193, 2, 0),
(193, 3, 0),
(194, 1, 3),
(194, 2, 0),
(194, 3, 0),
(195, 1, 1),
(195, 2, 0),
(195, 3, 0),
(196, 1, 2),
(196, 2, 0),
(196, 3, 0),
(197, 1, 1),
(197, 2, 0),
(197, 3, 0),
(198, 1, 1),
(198, 2, 0),
(198, 3, 0),
(199, 1, 0),
(199, 2, 1),
(199, 3, 0),
(200, 1, 2),
(200, 2, 0),
(200, 3, 0),
(201, 1, 3),
(201, 2, 0),
(201, 3, 0),
(202, 1, 1),
(202, 2, 0),
(202, 3, 0),
(203, 1, 1),
(203, 2, 0),
(203, 3, 0),
(204, 1, 0),
(204, 2, 0),
(204, 3, 1),
(205, 1, 1),
(205, 2, 0),
(205, 3, 0),
(206, 1, 1),
(206, 2, 0),
(206, 3, 0),
(208, 1, 1),
(208, 2, 0),
(208, 3, 0),
(209, 1, 1),
(209, 2, 0),
(209, 3, 0),
(210, 1, 1),
(210, 2, 0),
(210, 3, 0),
(211, 1, 1),
(211, 2, 0),
(211, 3, 0),
(212, 1, 2),
(212, 2, 0),
(212, 3, 0),
(213, 1, 1),
(213, 2, 0),
(213, 3, 0),
(214, 1, 1),
(214, 2, 0),
(214, 3, 0),
(216, 1, 0),
(216, 2, 1),
(216, 3, 0),
(218, 1, 2),
(218, 2, 0),
(218, 3, 0),
(219, 1, 2),
(219, 2, 0),
(219, 3, 0),
(220, 1, 3),
(220, 2, 0),
(220, 3, 0),
(221, 1, 6),
(221, 2, 0),
(221, 3, 0),
(222, 1, 1),
(222, 2, 0),
(222, 3, 0),
(223, 1, 13),
(223, 2, 0),
(223, 3, 0),
(224, 1, 9),
(224, 2, 0),
(224, 3, 0),
(225, 1, 4),
(225, 2, 0),
(225, 3, 0),
(226, 1, 4),
(226, 2, 0),
(226, 3, 0),
(227, 1, 2),
(227, 2, 0),
(227, 3, 0),
(228, 1, 2),
(228, 2, 0),
(228, 3, 0),
(229, 1, 1),
(229, 2, 0),
(229, 3, 0),
(230, 1, 1),
(230, 2, 0),
(230, 3, 0),
(232, 1, 4),
(232, 2, 0),
(232, 3, 0),
(233, 1, 2),
(233, 2, 0),
(233, 3, 0),
(234, 1, 1),
(234, 2, 0),
(234, 3, 0),
(235, 1, 2),
(235, 2, 0),
(235, 3, 0),
(236, 1, 11),
(236, 2, 0),
(236, 3, 0),
(238, 1, 1),
(238, 2, 0),
(238, 3, 0),
(239, 1, 6),
(239, 2, 0),
(239, 3, 0),
(240, 1, 1),
(240, 2, 0),
(240, 3, 0),
(241, 1, 2),
(241, 2, 0),
(241, 3, 0),
(242, 1, 1),
(242, 2, 0),
(242, 3, 0),
(243, 1, 5),
(243, 2, 0),
(243, 3, 0),
(245, 1, 0),
(245, 2, 0),
(245, 3, 6),
(246, 1, 10),
(246, 2, 0),
(246, 3, 0),
(247, 1, 0),
(247, 2, 0),
(247, 3, 0),
(248, 1, 0),
(248, 2, 0),
(248, 3, 0),
(253, 1, 2),
(253, 2, 0),
(253, 3, 0),
(254, 1, 0),
(254, 2, 0),
(254, 3, 0),
(255, 1, 3),
(255, 2, 0),
(255, 3, 0),
(256, 1, 3),
(256, 2, 0),
(256, 3, 0),
(257, 1, 2),
(257, 2, 0),
(257, 3, 0),
(258, 1, 5),
(258, 2, 0),
(258, 3, 0),
(259, 1, 0),
(259, 2, 0),
(259, 3, 82),
(260, 1, 0),
(260, 2, 0),
(260, 3, 0),
(261, 1, 0),
(261, 2, 0),
(261, 3, 0),
(262, 1, 0),
(262, 2, 0),
(262, 3, 0),
(263, 1, 0),
(263, 2, 0),
(263, 3, 0),
(264, 1, 74),
(264, 2, 0),
(264, 3, 176),
(265, 1, 10),
(265, 2, 0),
(265, 3, 0),
(266, 1, 3),
(266, 2, 0),
(266, 3, 0),
(267, 1, 3),
(267, 2, 0),
(267, 3, 0),
(268, 1, 4),
(268, 2, 0),
(268, 3, 0),
(269, 1, 2),
(269, 2, 0),
(269, 3, 0),
(270, 1, 5),
(270, 2, 0),
(270, 3, 0),
(271, 1, 150),
(271, 2, 0),
(271, 3, 0),
(272, 1, 60),
(272, 2, 0),
(272, 3, 0),
(273, 1, 70),
(273, 2, 0),
(273, 3, 0),
(274, 1, 1),
(274, 2, 0),
(274, 3, 0),
(275, 1, 1),
(275, 2, 0),
(275, 3, 0),
(276, 1, 7),
(276, 2, 0),
(276, 3, 0),
(277, 1, 12),
(277, 2, 0),
(277, 3, 0),
(278, 1, 8),
(278, 2, 0),
(278, 3, 0),
(279, 1, 6),
(279, 2, 0),
(279, 3, 0),
(280, 1, 8),
(280, 2, 0),
(280, 3, 0),
(281, 1, 8),
(281, 2, 0),
(281, 3, 0),
(282, 1, 6),
(282, 2, 0),
(282, 3, 0),
(283, 1, 6),
(283, 2, 0),
(283, 3, 0),
(284, 1, 4),
(284, 2, 0),
(284, 3, 0),
(285, 1, 3),
(285, 2, 1),
(285, 3, 0),
(286, 1, 2),
(286, 2, 0),
(286, 3, 0),
(287, 1, 4),
(287, 2, 0),
(287, 3, 0),
(288, 1, 5),
(288, 2, 0),
(288, 3, 0),
(289, 1, 12),
(289, 2, 0),
(289, 3, 0),
(290, 1, 2),
(290, 2, 0),
(290, 3, 0),
(291, 1, 5),
(291, 2, 0),
(291, 3, 0),
(292, 1, 4),
(292, 2, 0),
(292, 3, 0),
(293, 1, 4),
(293, 2, 0),
(293, 3, 0),
(294, 1, 6),
(294, 2, 0),
(294, 3, 0),
(295, 1, 4),
(295, 2, 0),
(295, 3, 1),
(296, 1, 2),
(296, 2, 0),
(296, 3, 0),
(297, 1, 0),
(297, 2, 0),
(297, 3, 0),
(298, 1, 0),
(298, 2, 0),
(298, 3, 0),
(299, 1, 1),
(299, 2, 0),
(299, 3, 0),
(300, 1, 10),
(300, 2, 0),
(300, 3, 0),
(301, 1, 0),
(301, 2, 0),
(301, 3, 0),
(302, 1, 6),
(302, 2, 0),
(302, 3, 0),
(303, 1, 5),
(303, 2, 0),
(303, 3, 0),
(304, 1, 0),
(304, 2, 2),
(304, 3, 0),
(305, 1, 2),
(305, 2, 0),
(305, 3, 0),
(306, 1, 0),
(306, 2, 0),
(306, 3, 0),
(307, 1, 0),
(307, 2, 0),
(307, 3, 16),
(308, 1, 0),
(308, 2, 0),
(308, 3, 23),
(309, 1, 0),
(309, 2, 0),
(309, 3, 24),
(310, 1, 0),
(310, 2, 0),
(310, 3, 41),
(311, 1, 0),
(311, 2, 0),
(311, 3, 15),
(312, 1, 100),
(312, 2, 0),
(312, 3, 0),
(313, 1, 20),
(313, 2, 0),
(313, 3, 0),
(314, 1, 20),
(314, 2, 0),
(314, 3, 0),
(315, 1, 0),
(315, 2, 2),
(315, 3, 0),
(316, 1, 4),
(316, 2, 1),
(316, 3, 0),
(317, 1, 10),
(317, 2, 0),
(317, 3, 0),
(318, 1, 0),
(318, 2, 2),
(318, 3, 0),
(319, 1, 11),
(319, 2, 0),
(319, 3, 9),
(320, 1, 5),
(320, 2, 0),
(320, 3, 0),
(321, 1, 0),
(321, 2, 0),
(321, 3, 0),
(322, 1, 0),
(322, 2, 0),
(322, 3, 0),
(323, 1, 17),
(323, 2, 0),
(323, 3, 0),
(324, 1, 2),
(324, 2, 0),
(324, 3, 0),
(325, 1, 0),
(325, 2, 0),
(325, 3, 1),
(326, 1, 5),
(326, 2, 0),
(326, 3, 0),
(327, 1, 5),
(327, 2, 0),
(327, 3, 0),
(328, 1, 2),
(328, 2, 0),
(328, 3, 0),
(329, 1, 6),
(329, 2, 0),
(329, 3, 0),
(330, 1, 6),
(330, 2, 0),
(330, 3, 0),
(331, 1, 0),
(331, 2, 0),
(331, 3, 1),
(332, 1, 1),
(332, 2, 0),
(332, 3, 0),
(338, 1, 2),
(338, 2, 0),
(338, 3, 0),
(339, 1, 4),
(339, 2, 0),
(339, 3, 0),
(340, 1, 92),
(340, 2, 0),
(340, 3, 0),
(341, 1, 0),
(341, 2, 10),
(341, 3, 0),
(342, 1, 0),
(342, 2, 1),
(342, 3, 0),
(343, 1, 4),
(343, 2, 1),
(343, 3, 0),
(344, 1, 0),
(344, 2, 0),
(344, 3, 0),
(345, 1, 5),
(345, 2, 0),
(345, 3, 0),
(346, 1, 4),
(346, 2, 1),
(346, 3, 0),
(347, 1, 2),
(347, 2, 1),
(347, 3, 0),
(350, 1, 51),
(350, 2, 0),
(350, 3, 16),
(351, 1, 0),
(351, 2, 0),
(351, 3, 19),
(352, 1, 48),
(352, 2, 0),
(352, 3, 2),
(353, 1, 89),
(353, 2, 0),
(353, 3, 11),
(354, 1, 0),
(354, 2, 0),
(354, 3, 37),
(355, 1, 0),
(355, 2, 0),
(355, 3, 20),
(356, 1, 0),
(356, 2, 0),
(356, 3, 25),
(358, 1, 89),
(358, 2, 1),
(358, 3, 10),
(359, 1, 39),
(359, 2, 0),
(359, 3, 12),
(360, 1, 0),
(360, 2, 0),
(360, 3, 0),
(361, 1, 0),
(361, 2, 0),
(361, 3, 0),
(362, 1, 0),
(362, 2, 0),
(362, 3, 0),
(363, 1, 0),
(363, 2, 0),
(363, 3, 0),
(364, 1, 0),
(364, 2, 0),
(364, 3, 0),
(365, 1, 0),
(365, 2, 0),
(365, 3, 0),
(366, 1, 0),
(366, 2, 2),
(366, 3, 0),
(367, 1, 3),
(367, 2, 6),
(367, 3, 0),
(368, 1, 2),
(368, 2, 2),
(368, 3, 0),
(369, 1, 2),
(369, 2, 6),
(369, 3, 0),
(370, 1, 4),
(371, 1, 1),
(371, 2, 1),
(372, 1, 1),
(372, 2, 2),
(373, 1, 6),
(373, 2, 1),
(373, 3, 0),
(374, 1, 2),
(374, 2, 2),
(374, 3, 0),
(375, 1, 2),
(375, 2, 2),
(375, 3, 0),
(376, 1, 0),
(376, 2, 0),
(376, 3, 0),
(377, 1, 0),
(377, 2, 0),
(377, 3, 20),
(378, 1, 0),
(378, 2, 0),
(378, 3, 20),
(379, 1, 0),
(379, 2, 0),
(379, 3, 24),
(380, 1, 0),
(380, 2, 3),
(380, 3, 0),
(381, 1, 0),
(381, 2, 1),
(381, 3, 0),
(382, 1, 0),
(382, 2, 4),
(382, 3, 0),
(383, 1, 0),
(383, 2, 1),
(383, 3, 0),
(384, 1, 0),
(384, 2, 2),
(384, 3, 0),
(385, 1, 0),
(385, 2, 1),
(385, 3, 0),
(386, 1, 0),
(386, 2, 1),
(386, 3, 0),
(387, 1, 1),
(387, 2, 0),
(387, 3, 0),
(388, 1, 10),
(388, 2, 0),
(389, 1, 0),
(389, 2, 10),
(389, 3, 0),
(390, 1, 0),
(390, 2, 6),
(390, 3, 0),
(391, 1, 0),
(391, 2, 6),
(391, 3, 0),
(392, 1, 0),
(392, 2, 6),
(392, 3, 0),
(393, 1, 0),
(393, 2, 6),
(393, 3, 0),
(394, 1, 1000),
(394, 2, 0),
(394, 3, 0),
(395, 1, 2500),
(395, 2, 0),
(395, 3, 0),
(396, 1, 962),
(396, 2, 0),
(396, 3, 38),
(397, 1, 968),
(397, 2, 0),
(397, 3, 32),
(398, 1, 985),
(398, 2, 0),
(398, 3, 15),
(399, 1, 10),
(399, 2, 0),
(399, 3, 0),
(400, 1, 1),
(400, 2, 1),
(400, 3, 0),
(401, 1, 3),
(401, 2, 3),
(401, 3, 0),
(402, 1, 1),
(402, 2, 0),
(402, 3, 0),
(404, 1, 1),
(404, 2, 1),
(404, 3, 0),
(405, 1, 2),
(405, 2, 0),
(405, 3, 0),
(406, 1, 2),
(406, 2, 0),
(406, 3, 0),
(407, 1, 1),
(407, 2, 1),
(407, 3, 0),
(408, 1, 0),
(408, 2, 1),
(408, 3, 0),
(409, 1, 0),
(409, 2, 1),
(409, 3, 0),
(410, 1, 4),
(410, 2, 1),
(410, 3, 0),
(411, 1, 1),
(411, 2, 0),
(411, 3, 0),
(412, 1, 6),
(412, 2, 0),
(412, 3, 0),
(413, 1, 0),
(413, 2, 1),
(413, 3, 0),
(414, 1, 0),
(414, 2, 1),
(414, 3, 0),
(416, 1, 1),
(416, 2, 0),
(416, 3, 0),
(417, 1, 5),
(417, 2, 0),
(417, 3, 0),
(418, 1, 6),
(418, 2, 0),
(418, 3, 0),
(419, 1, 0),
(419, 2, 2),
(419, 3, 0),
(420, 1, 0),
(420, 2, 2),
(420, 3, 0),
(421, 1, 64),
(421, 2, 0),
(421, 3, 1),
(422, 1, 96),
(422, 2, 0),
(422, 3, 4),
(423, 1, 140),
(423, 2, 0),
(423, 3, 10),
(424, 1, 150),
(424, 2, 0),
(424, 3, 2),
(425, 1, 2),
(425, 2, 0),
(425, 3, 0),
(426, 1, 0),
(426, 2, 1),
(426, 3, 0),
(427, 1, 2),
(427, 2, 0),
(427, 3, 0),
(428, 1, 2),
(428, 2, 0),
(428, 3, 0),
(429, 1, 2),
(429, 2, 0),
(429, 3, 0),
(430, 1, 2),
(430, 2, 1),
(430, 3, 0),
(431, 1, 6),
(431, 2, 0),
(431, 3, 0),
(432, 1, 0),
(432, 2, 1),
(432, 3, 0),
(433, 1, 0),
(433, 2, 1),
(433, 3, 0),
(434, 1, 0),
(434, 2, 1),
(434, 3, 0),
(435, 1, 0),
(435, 2, 1),
(435, 3, 0),
(436, 1, 23),
(436, 2, 0),
(436, 3, 0),
(437, 1, 20),
(437, 2, 0),
(437, 3, 0),
(438, 1, 20),
(438, 2, 0),
(438, 3, 0),
(439, 1, 20),
(439, 2, 0),
(439, 3, 0),
(440, 1, 0),
(440, 2, 1),
(440, 3, 0),
(441, 1, 0),
(441, 2, 10),
(441, 3, 0),
(442, 1, 0),
(442, 2, 10),
(442, 3, 0),
(443, 1, 2),
(443, 2, 0),
(443, 3, 0),
(444, 1, 2),
(445, 1, 1),
(445, 2, 0),
(446, 1, 1),
(446, 2, 0),
(446, 3, 0),
(447, 1, 1),
(447, 2, 0),
(447, 3, 0),
(448, 1, 1),
(448, 2, 0),
(448, 3, 0),
(449, 1, 1),
(449, 2, 0),
(449, 3, 0),
(450, 1, 4),
(450, 2, 1),
(450, 3, 0),
(451, 1, 5),
(451, 2, 0),
(451, 3, 0),
(452, 1, 5),
(452, 2, 0),
(452, 3, 0),
(453, 1, 1),
(453, 2, 0),
(453, 3, 0),
(454, 1, 1),
(454, 2, 0),
(454, 3, 0),
(455, 1, 1),
(455, 2, 0),
(455, 3, 0),
(456, 1, 1),
(456, 2, 0),
(456, 3, 0),
(457, 1, 1),
(457, 2, 0),
(457, 3, 0),
(458, 1, 0),
(458, 2, 0),
(458, 3, 1),
(459, 1, 2),
(459, 2, 0),
(459, 3, 0),
(460, 1, 4),
(460, 2, 0),
(460, 3, 0),
(461, 1, 10),
(461, 2, 0),
(461, 3, 0),
(462, 1, 4),
(462, 2, 0),
(462, 3, 0),
(463, 1, 11),
(463, 2, 0),
(463, 3, 0),
(464, 1, 5),
(464, 2, 0),
(464, 3, 0),
(465, 1, 7),
(465, 2, 0),
(465, 3, 0),
(466, 1, 7),
(466, 2, 0),
(466, 3, 1),
(467, 1, 8),
(467, 2, 0),
(467, 3, 0),
(468, 1, 7),
(468, 2, 0),
(468, 3, 0),
(469, 1, 5),
(469, 2, 0),
(469, 3, 0),
(470, 1, 10),
(470, 2, 0),
(470, 3, 0),
(471, 1, 9),
(471, 2, 0),
(471, 3, 0),
(472, 1, 44),
(472, 2, 0),
(472, 3, 6),
(473, 1, 88),
(473, 2, 0),
(473, 3, 12),
(474, 1, 47),
(474, 2, 0),
(474, 3, 3),
(475, 1, 438),
(475, 2, 0),
(475, 3, 12),
(476, 1, 192),
(476, 2, 0),
(476, 3, 8),
(477, 1, 49),
(477, 2, 0),
(477, 3, 1),
(478, 1, 39),
(478, 2, 0),
(478, 3, 1),
(479, 1, 2),
(479, 2, 0),
(479, 3, 0),
(480, 1, 1),
(480, 2, 0),
(480, 3, 0),
(481, 1, 1),
(481, 2, 0),
(481, 3, 0),
(482, 1, 0),
(482, 2, 0),
(482, 3, 1),
(483, 1, 1),
(483, 2, 0),
(483, 3, 19),
(484, 1, 19),
(484, 2, 0),
(484, 3, 1),
(485, 1, 19),
(485, 2, 1),
(485, 3, 0),
(486, 1, 19),
(486, 2, 1),
(486, 3, 0),
(487, 1, 0),
(487, 2, 0),
(487, 3, 20),
(488, 1, 20),
(488, 2, 0),
(488, 3, 0),
(489, 1, 19),
(489, 2, 0),
(489, 3, 1),
(490, 1, 996),
(490, 2, 0),
(490, 3, 2),
(491, 1, 27),
(491, 2, 8),
(491, 3, 0),
(492, 1, 0),
(492, 2, 0),
(492, 3, 24),
(493, 1, 0),
(493, 2, 0),
(493, 3, 22),
(494, 1, 0),
(494, 2, 0),
(494, 3, 72),
(495, 1, 0),
(495, 2, 0),
(495, 3, 27),
(496, 1, 0),
(496, 2, 0),
(496, 3, 72),
(497, 1, 0),
(497, 2, 0),
(497, 3, 0),
(498, 1, 0),
(498, 2, 0),
(498, 3, 45),
(499, 1, 110),
(499, 2, 0),
(499, 3, 6),
(500, 1, 0),
(500, 2, 0),
(500, 3, 0),
(501, 1, 0),
(501, 2, 0),
(501, 3, 60),
(502, 1, 0),
(502, 2, 0),
(502, 3, 60),
(503, 1, 40),
(503, 2, 0),
(503, 3, 6),
(504, 1, 0),
(504, 2, 0),
(504, 3, 0),
(505, 1, 13),
(505, 2, 0),
(505, 3, 2),
(506, 1, 0),
(506, 2, 0),
(506, 3, 0),
(507, 1, 391),
(507, 2, 0),
(507, 3, 4),
(508, 1, 4),
(508, 2, 1),
(508, 3, 0),
(509, 1, 5),
(509, 2, 0),
(509, 3, 0),
(510, 1, 1),
(510, 2, 4),
(510, 3, 0),
(511, 1, 18),
(511, 2, 0),
(511, 3, 0),
(512, 1, 18),
(512, 2, 0),
(512, 3, 0),
(513, 1, 1),
(513, 2, 0),
(513, 3, 0),
(514, 1, 1),
(514, 2, 0),
(514, 3, 0),
(515, 1, 1),
(515, 2, 0),
(515, 3, 0),
(516, 1, 2),
(516, 2, 0),
(516, 3, 0),
(517, 1, 1),
(517, 2, 0),
(517, 3, 0),
(518, 1, 0),
(518, 2, 1),
(518, 3, 0),
(519, 1, 1),
(519, 2, 0),
(519, 3, 0),
(520, 1, 6),
(520, 2, 0),
(520, 3, 0),
(521, 1, 1),
(521, 2, 0),
(521, 3, 0),
(522, 1, 6),
(522, 2, 0),
(522, 3, 0),
(523, 1, 5),
(523, 2, 0),
(523, 3, 0),
(524, 1, 4),
(524, 2, 0),
(524, 3, 0),
(525, 1, 963),
(525, 2, 0),
(525, 3, 37),
(526, 1, 2492),
(526, 2, 0),
(526, 3, 8),
(527, 1, 93),
(527, 2, 0),
(527, 3, 2),
(528, 1, 0),
(528, 2, 0),
(528, 3, 0),
(529, 1, 0),
(529, 2, 0),
(529, 3, 0),
(530, 1, 0),
(530, 2, 0),
(530, 3, 0),
(531, 1, 47),
(531, 2, 0),
(531, 3, 2),
(532, 1, 0),
(532, 2, 0),
(532, 3, 0),
(533, 1, 0),
(533, 2, 0),
(533, 3, 0),
(534, 1, 0),
(534, 2, 0),
(534, 3, 0),
(535, 1, 0),
(535, 2, 0),
(535, 3, 0),
(536, 1, 0),
(536, 2, 0),
(536, 3, 0),
(537, 1, 0),
(537, 2, 0),
(537, 3, 0),
(538, 1, 0),
(538, 2, 0),
(538, 3, 0),
(539, 1, 0),
(539, 2, 0),
(539, 3, 0),
(540, 1, 88),
(540, 2, 0),
(540, 3, 12),
(541, 1, 1028),
(541, 2, 0),
(541, 3, 2),
(542, 1, 0),
(542, 2, 0),
(542, 3, 0),
(543, 1, 0),
(543, 2, 0),
(543, 3, 0),
(544, 1, 0),
(544, 2, 0),
(544, 3, 0),
(545, 1, 0),
(545, 2, 0),
(545, 3, 0),
(546, 1, 0),
(546, 2, 0),
(546, 3, 0),
(547, 1, 0),
(547, 2, 0),
(547, 3, 0),
(548, 1, 5000),
(548, 2, 0),
(548, 3, 0),
(549, 1, 200),
(549, 2, 0),
(549, 3, 0),
(550, 1, 0),
(550, 2, 0),
(550, 3, 0),
(551, 1, 0),
(551, 2, 0),
(551, 3, 0),
(552, 1, 0),
(552, 2, 0),
(552, 3, 0),
(553, 1, 0),
(553, 2, 0),
(553, 3, 0),
(554, 1, 0),
(554, 2, 0),
(554, 3, 0),
(555, 1, 0),
(555, 2, 0),
(555, 3, 0),
(556, 1, 0),
(556, 2, 0),
(556, 3, 0),
(557, 1, 0),
(557, 2, 0),
(557, 3, 0),
(558, 1, 0),
(558, 2, 0),
(558, 3, 0),
(559, 1, 0),
(559, 2, 0),
(559, 3, 0),
(560, 1, 0),
(560, 2, 0),
(560, 3, 0),
(561, 1, 500),
(561, 2, 0),
(561, 3, 0),
(562, 1, 2),
(562, 2, 0),
(562, 3, 0),
(563, 1, 3),
(563, 2, 1),
(563, 3, 0),
(564, 1, 3),
(564, 2, 1),
(564, 3, 0),
(565, 1, 4),
(565, 2, 0),
(565, 3, 0),
(566, 1, 2),
(566, 2, 0),
(566, 3, 0),
(567, 1, 0),
(567, 2, 1),
(567, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_moneda`
--

CREATE TABLE `tipos_moneda` (
  `id_moneda` int(11) NOT NULL,
  `nombre_moneda` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_moneda`
--

INSERT INTO `tipos_moneda` (`id_moneda`, `nombre_moneda`) VALUES
(1, 'MXN'),
(2, 'USD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

CREATE TABLE `unidades_medida` (
  `id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades_medida`
--

INSERT INTO `unidades_medida` (`id_unidad`, `nombre_unidad`) VALUES
(1, 'Pieza'),
(2, 'Kilo'),
(3, 'Metro'),
(4, 'Centímetro'),
(5, 'Pulgadas'),
(6, 'Milímetro'),
(7, 'Litros'),
(8, 'PAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_usuario` varchar(50) NOT NULL,
  `usuario_clave` varchar(255) NOT NULL,
  `usuario_foto` varchar(535) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_creado` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_actualizado` timestamp NOT NULL DEFAULT current_timestamp(),
  `permiso` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_creado`, `usuario_actualizado`, `permiso`) VALUES
(1, 'Administrador', '$2y$10$uJv3jCCQKn20CMWiYjw6sOh81jCmUoEN8YJMLASs30kbTa6g6/Fuq', 'Administrador_95.jpg', '2023-11-06 21:45:33', '2023-11-10 22:33:51', 1),
(11, 'admin1111', '$2y$10$hXlCprGNBDDBzrRzxRYvOu5OAt7bNce1O/LS2SRTUjiNgfSAn4LCS', '', '2023-11-21 05:48:31', '2024-01-22 00:25:59', 2),
(14, 'usuario', '$2y$10$eOVgAY6MlZFBmzmedLaSN.iKHIxAt2y3yzwKNii9wkmYlM/9/vmqq', '', '2023-12-03 01:13:04', '2024-01-22 00:26:13', 2),
(15, 'tercero', '$2y$10$1z.FPyW4Nn3t4rN1hMmsxO2W/uoScQLBmINnUkIiUtGeL.nH6NlfW', 'tercero_54.jpg', '2024-01-22 00:25:45', '2024-01-22 00:25:45', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cpi_art_af`
--
ALTER TABLE `cpi_art_af`
  ADD PRIMARY KEY (`id_cpi_art_af`);

--
-- Indices de la tabla `detalle_orden_compra`
--
ALTER TABLE `detalle_orden_compra`
  ADD PRIMARY KEY (`id_detalle_orden`),
  ADD KEY `id_orden_compra` (`id_orden_compra`),
  ADD KEY `detalleorden-unidades` (`id_unidad`);

--
-- Indices de la tabla `detalle_orden_gasto`
--
ALTER TABLE `detalle_orden_gasto`
  ADD PRIMARY KEY (`id_detalle_orden`),
  ADD KEY `id_orden_gasto` (`id_orden_gasto`),
  ADD KEY `id_unidad` (`id_unidad`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `emplead- area` (`area`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_almacen_origen` (`id_almacen_origen`),
  ADD KEY `id_almacen_destino` (`id_almacen_destino`),
  ADD KEY `empleado-movimiento` (`id_empleado`);

--
-- Indices de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  ADD PRIMARY KEY (`id_orden_compra`),
  ADD UNIQUE KEY `numero_orden` (`numero_orden`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_moneda` (`id_moneda`),
  ADD KEY `empleado` (`id_empleado`);

--
-- Indices de la tabla `ordenes_gasto`
--
ALTER TABLE `ordenes_gasto`
  ADD PRIMARY KEY (`id_orden_gasto`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `empleado-orden` (`id_empleado`),
  ADD KEY `moneda-orden` (`id_moneda`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_unidad` (`id_unidad`),
  ADD KEY `id_moneda` (`id_moneda`);

--
-- Indices de la tabla `productos_cpi_art_af`
--
ALTER TABLE `productos_cpi_art_af`
  ADD KEY `id_producto` (`id_producto`,`id_cpi_art_af`),
  ADD KEY `cpi_art_af_producto` (`id_cpi_art_af`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `email_proveedor` (`email_proveedor`);

--
-- Indices de la tabla `stock_almacen`
--
ALTER TABLE `stock_almacen`
  ADD PRIMARY KEY (`id_producto`,`id_almacen`),
  ADD KEY `id_almacen` (`id_almacen`);

--
-- Indices de la tabla `tipos_moneda`
--
ALTER TABLE `tipos_moneda`
  ADD PRIMARY KEY (`id_moneda`);

--
-- Indices de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `permiso` (`permiso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cpi_art_af`
--
ALTER TABLE `cpi_art_af`
  MODIFY `id_cpi_art_af` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_compra`
--
ALTER TABLE `detalle_orden_compra`
  MODIFY `id_detalle_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_gasto`
--
ALTER TABLE `detalle_orden_gasto`
  MODIFY `id_detalle_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  MODIFY `id_orden_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `ordenes_gasto`
--
ALTER TABLE `ordenes_gasto`
  MODIFY `id_orden_gasto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=568;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tipos_moneda`
--
ALTER TABLE `tipos_moneda`
  MODIFY `id_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_orden_compra`
--
ALTER TABLE `detalle_orden_compra`
  ADD CONSTRAINT `detalle_orden_compra_ibfk_1` FOREIGN KEY (`id_orden_compra`) REFERENCES `ordenes_compra` (`id_orden_compra`),
  ADD CONSTRAINT `detalleorden-unidades` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`);

--
-- Filtros para la tabla `detalle_orden_gasto`
--
ALTER TABLE `detalle_orden_gasto`
  ADD CONSTRAINT `detalle-unidades` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalleorden-orden` FOREIGN KEY (`id_orden_gasto`) REFERENCES `ordenes_gasto` (`id_orden_gasto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `emplead- area` FOREIGN KEY (`area`) REFERENCES `areas` (`id_area`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `empleado-movimiento` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_almacen_origen`) REFERENCES `almacenes` (`id_almacen`),
  ADD CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`id_almacen_destino`) REFERENCES `almacenes` (`id_almacen`);

--
-- Filtros para la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  ADD CONSTRAINT `empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moneda` FOREIGN KEY (`id_moneda`) REFERENCES `tipos_moneda` (`id_moneda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_compra_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes_gasto`
--
ALTER TABLE `ordenes_gasto`
  ADD CONSTRAINT `empleado-orden` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moneda-orden` FOREIGN KEY (`id_moneda`) REFERENCES `tipos_moneda` (`id_moneda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orden-provedores` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`),
  ADD CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`id_moneda`) REFERENCES `tipos_moneda` (`id_moneda`);

--
-- Filtros para la tabla `productos_cpi_art_af`
--
ALTER TABLE `productos_cpi_art_af`
  ADD CONSTRAINT `cpi_art_af_producto` FOREIGN KEY (`id_cpi_art_af`) REFERENCES `cpi_art_af` (`id_cpi_art_af`),
  ADD CONSTRAINT `producto_cpi_art_ar` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `stock_almacen`
--
ALTER TABLE `stock_almacen`
  ADD CONSTRAINT `stock_almacen_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `stock_almacen_ibfk_2` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `permiso` FOREIGN KEY (`permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
