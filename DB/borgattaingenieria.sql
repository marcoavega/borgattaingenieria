-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2024 a las 23:17:37
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
(1, 'Herramientas'),
(2, 'Insumos'),
(3, 'Materiales'),
(4, 'Piezas articulador sin pintar'),
(5, 'Articulador CPI'),
(6, 'Papelería'),
(7, 'Materia prima maquinado articulador'),
(8, 'Piezas articulador pintadas.'),
(9, 'Articulador Análogo'),
(10, 'Tlapaleria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nota` text NOT NULL,
  `referencia` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `fecha_movimiento` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre_empleado` varchar(100) NOT NULL,
  `nota_movimiento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_movimiento`, `id_producto`, `id_almacen_origen`, `id_almacen_destino`, `cantidad`, `fecha_movimiento`, `nombre_empleado`, `nota_movimiento`) VALUES
(27, 342, 1, 2, 1, '2024-01-18 14:31:48', 'Abraham', 'Herramienta requerida'),
(28, 341, 1, 2, 10, '2024-01-18 14:31:48', 'Abraham', 'Herramienta requerida'),
(29, 366, 1, 2, 1, '2024-01-18 14:31:48', 'Abraham', 'Herramienta requerida'),
(30, 369, 1, 1, 1, '2024-01-18 15:42:46', 'Abraham', 'Herramienta requerida'),
(31, 369, 1, 2, 1, '2024-01-18 21:04:59', 'Abraham', 'Se requiere en maquinados'),
(32, 359, 1, 2, 2, '2024-01-18 21:16:17', 'Abraham', 'Se requirió en maquinados'),
(33, 352, 1, 2, 2, '2024-01-18 21:30:45', 'Abraham', 'Se requiere en maquinados'),
(34, 179, 1, 3, 1, '2024-01-18 21:37:55', 'Francisco Villegas', 'Se requiere en ensable'),
(35, 376, 2, 1, 15, '2024-01-18 22:04:30', 'Abraham', 'Abraham entrega al almacen general'),
(36, 377, 2, 3, 21, '2024-01-18 22:11:34', 'Abraham', 'Abraham entrega a francisco'),
(37, 311, 2, 1, 15, '2024-01-18 22:15:11', 'Abraham', 'Abraham entrega al almacen general');

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
  `nombre_producto` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp(),
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
(1, 'H-0001', 'Avellanador 1/4\" 1/4\"', 150.00, 6, '2024-01-08', 1, 2, 1, 1, 'avellanador1_4.jpg'),
(44, 'H-0002', 'Avellanador 1/2\" 3FLT 82', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '652459c468854_IMG_20231009_134859_398[1].jpg'),
(45, 'H-0003', 'Boquilla ER-32', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '65245e5e4adc8_IMG_20231009_135742_685[1].jpg'),
(47, 'H-0004', 'Cortador 211-270 3/4 4FL SQ EM', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65245f668b348_IMG_20231009_140439_159.jpg'),
(48, 'H-0005', 'Cortador Carbice AADF \"KENNAMETAL\" 3/8 x 3/8 x 1 x 3', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '65245fd9ed077_IMG_20231009_135542_237.jpg'),
(49, 'H-0006', 'Cortador SA-1FM 1/4 CYL', 1.00, 2, '2024-01-08', 1, 2, 1, 1, 'CORTADOR.jpg'),
(50, 'H-0007', 'Cuchilla E100 P7ACERO Y ALUMINIO', 1.00, 10, '2024-01-08', 1, 2, 1, 1, '652460811aecd_IMG_20231009_140404_883.jpg'),
(51, 'H-0008', 'Fresa de carburo de tungsteno clave 125 12,7 x 22,2 x 6,4 mm(1/2x7/8x1/4\")', 1.00, 2, '2024-01-08', 1, 2, 1, 1, 'FRESA.jpg'),
(53, 'H-0009', 'Fresa de carburo de tungsteno SH-5', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '652461bd30ddf_IMG_20231009_140548_946.jpg'),
(54, 'H-0010', 'Punta cortador para dremel SC-42 Double cut burr', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '6524621ebb627_IMG_20231009_140321_551.jpg'),
(55, 'H-0011', 'Tarraja 1\" M6X1', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65246c8bd5430_IMG_20231009_140019_434.jpg'),
(56, 'H-0012', 'Tarraja 1\" M5X.8', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65246df03f3d9_IMG_20231009_140039_500.jpg'),
(57, 'H-0013', 'Tarraja 1\" M4X7', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65246e42c629b_IMG_20231009_140058_020.jpg'),
(58, 'H-0014', 'Tarraja 1\" M3X.5', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65246e9854526_IMG_20231009_140118_450.jpg'),
(59, 'H-0015', 'Machuelo Hy-Pro Helicoidal \"5303F 1/8 - 40 2B 3FL SEMICONICO', 0.00, 0, '2024-01-08', 0, 0, 0, 0, ''),
(60, 'H-0016', 'Machuelo OSG ROYCO 5303F 1/8 - 40 2B 3FL SEMICONICO', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '652475de427e8_IMG_20231009_153018_560.jpg'),
(61, 'H-0017', 'Machuelo OSG ROYCO 5303F 3/16-24 2B 4FL SEMICONICO', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '65247686b6266_IMG_20231009_152858_760.jpg'),
(63, 'H-0018', 'Machuelo OSG ROYCO 142 M3X0.5 D3 2S/P PLUG', 1.00, 11, '2024-01-08', 1, 2, 1, 1, '6524776535649_IMG_20231009_152807_827.jpg'),
(64, 'H-0019', 'Machuelo OSG ROYCO 5305N 10-24 2B 4FL SEMICONICO', 1.00, 9, '2024-01-08', 1, 2, 1, 1, '652478ecd5372_IMG_20231009_152338_555.jpg'),
(65, 'H-0020', 'Machuelo OSG ROYCO 5301N 10-24 2B 2S/P SEMICONICO', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '65247a0aa1a16_IMG_20231009_152338_555.jpg'),
(67, 'H-0021', 'Machuelo OSG ROYCO 5303F 1/4-20 2B 4FL SEMICONICO', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '65247a86be014_IMG_20231009_152858_760.jpg'),
(70, 'H-0022', 'Machuelo OSG ROYCO 5303F 3/8-16 2B 4FL SEMICONICO', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '65247b763dce8_IMG_20231009_152442_711.jpg'),
(71, 'H-0023', 'Machuelo OSG ROYCO M5X0.8 6H', 1.00, 3, '2024-01-08', 1, 2, 1, 1, '65247bc62733f_IMG_20231009_152701_683.jpg'),
(72, 'H-0024', 'Machuelo OSG ROYCO M6 X1 6H', 1.00, 3, '2024-01-08', 1, 2, 1, 1, '65247c3f9dfa5_IMG_20231009_152645_816.jpg'),
(74, 'H-0025', 'Machuelo OSG ROYCO M4 X 0.7 6H', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '65247cc3dc7f0_IMG_20231009_152544_434.jpg'),
(75, 'H-0026', 'Cortador R1.5X6X4X50L', 1.00, 0, '2024-01-08', 1, 2, 1, 1, '65247f7a95089_IMG-20231009-WA0001.jpg'),
(76, 'H-0027', 'Cortador R1.0X4X4X50L', 1.00, 0, '2024-01-08', 1, 2, 1, 1, '65247f8f4de19_IMG-20231009-WA0001.jpg'),
(77, 'H-0028', 'Cortador R0.75X3X4X50L', 1.00, 0, '2024-01-08', 1, 2, 1, 1, '65247fa445d75_IMG-20231009-WA0001.jpg'),
(80, 'H-0029', 'Cortador R2.0X8X4X50L', 1.00, 0, '2024-01-08', 1, 2, 1, 1, '65247fda7de63_IMG-20231009-WA0001.jpg'),
(81, 'H-0030', 'Cortador R0.5X2X4X50L', 1.00, 0, '2024-01-08', 1, 2, 1, 1, '6524800c28db9_IMG-20231009-WA0001.jpg'),
(82, 'H-0031', 'Inserto DFT05T308HP / KC7140 / 1804829', 1.00, 20, '2024-01-08', 1, 2, 1, 1, '652480ee9141e_IMG_20231009_161518_511.jpg'),
(83, 'H-0032', 'Inserto KC410M / 2984054', 1.00, 15, '2024-01-08', 1, 2, 1, 1, '652481525eae6_IMG_20231009_161612_513.jpg'),
(84, 'H-0033', 'Inserto NT2R / KCU10 / 4175911', 1.00, 9, '2024-01-08', 1, 2, 1, 1, '652481907eff1_IMG_20231009_161713_523.jpg'),
(86, 'H-0034', 'Inserto NT3RK / KC5025 / 1795787', 1.00, 10, '2024-01-08', 1, 2, 1, 1, '652481dc39e07_IMG_20231009_161307_339.jpg'),
(87, 'H-0035', 'Inserto CNMG090308MP / KC5010 / CNMG322MP', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '6524831fba5b4_IMG_20231009_164537_426.jpg'),
(88, 'H-0036', 'Inserto CNMG090308MP / CNMG322MP / KC5010', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '6524835def208_IMG_20231009_161822_013.jpg'),
(89, 'H-0037', 'Inserto A4G0205M02U02GMN / KC5025', 500.00, 10, '2024-01-08', 1, 2, 1, 1, '652483a716952_IMG_20231009_161742_020.jpg'),
(91, 'H-0038', 'Inserto NT3R / KC5010', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '652484445d5e1_IMG_20231009_165123_369.jpg'),
(92, 'H-0039', 'Broca para metal 10.00 MM', 1.00, 7, '2024-01-08', 1, 2, 1, 1, '6525779ebfad1_IMG_20231010_100001_599.jpg'),
(93, 'H-0040', 'Broca para metal 17/64\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525785db67f9_IMG_20231010_100116_298.jpg'),
(94, 'H-0041', 'Broca para metal 1/4\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '652578cf4aa14_IMG_20231010_100201_147.jpg'),
(95, 'H-0042', 'Broca para metal 6.35 MM', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525791b1534f_IMG_20231010_100354_485.jpg'),
(96, 'H-0043', 'Broca para metal 1/2\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '652579aa0c56d_IMG_20231010_100433_527.jpg'),
(97, 'H-0044', 'Broca para metal 3/8\" HSS', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '652579edc8504_IMG_20231010_100541_401.jpg'),
(98, 'H-0045', 'Broca para concreto 3/8\" (10)', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65257a28469e7_IMG_20231010_100557_681.jpg'),
(99, 'H-0046', 'Broca para metal 9/16\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65257bf5b93cc_IMG_20231010_102027_731.jpg'),
(100, 'H-0047', 'Broca para metal 31/64\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65257c3e19dfe_IMG_20231010_102050_437.jpg'),
(101, 'H-0048', 'Broca para metal 7/16\"', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '65257cbf1b672_IMG_20231010_102116_322.jpg'),
(102, 'H-0049', 'Broca para metal CLEVELAND 1/8\"', 1.00, 15, '2024-01-08', 1, 2, 1, 1, '65257d245682b_IMG_20231010_102147_476.jpg'),
(103, 'H-0050', 'Broca para metal 2.50 MM 0.0984\"', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '65257d6c28af3_IMG_20231010_102225_747.jpg'),
(104, 'H-0051', 'Broca para metal 15/64\"', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '65257db2b948b_IMG_20231010_102246_630.jpg'),
(105, 'H-0052', 'Broca para metal 7/64\" 0.1094\"', 1.00, 14, '2024-01-08', 1, 2, 1, 1, '65257e53c347f_IMG_20231010_102607_366.jpg'),
(106, 'H-0053', 'Broca para metal 3/32\"', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '65257e9c98e90_IMG_20231010_102330_517.jpg'),
(107, 'H-0054', 'Broca para metal 3/16\"', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '65257ed86fba6_IMG_20231010_102408_714.jpg'),
(109, 'H-0055', 'Broca para metal 4.00 MM', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '65257f7bdf85b_IMG_20231010_102424_168.jpg'),
(110, 'H-0056', 'Broca para metal 11/64\" 0.1719\"', 1.00, 9, '2024-01-08', 1, 2, 1, 1, '65257fbd8eebc_IMG_20231010_102534_809.jpg'),
(111, 'H-0057', 'Broca para metal 9/64\" 0.01406\"', 1.00, 10, '2024-01-08', 1, 2, 1, 1, '65258003de85c_IMG_20231010_102552_755.jpg'),
(112, 'H-0058', 'Broca para metal 1/8\"', 1.00, 8, '2024-01-08', 1, 2, 1, 1, '65258044d9a12_IMG_20231010_102623_674.jpg'),
(114, 'H-0059', 'Broca para metal 5/32\" 0.1562\"', 1.00, 7, '2024-01-08', 1, 2, 1, 1, '652580db7f955_IMG_20231010_102641_410.jpg'),
(115, 'H-0060', 'Broca para metal 5/64\" 0.0781\"', 1.00, 13, '2024-01-08', 1, 2, 1, 1, '652581b01de30_IMG_20231010_102650_179.jpg'),
(116, 'H-0061', 'Broca para metal 27  0.1440\"  ', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '652581ffc15c7_IMG_20231010_102659_658.jpg'),
(117, 'H-0062', 'Broca para concreto 5/8\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65258353be987_IMG_20231010_105534_251.jpg'),
(118, 'H-0063', 'Broca para metal 5/16\"', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '652583a12c1bc_IMG_20231010_105604_565.jpg'),
(119, 'H-0064', 'Broca para metal 13/64', 1.00, 11, '2024-01-08', 1, 2, 1, 1, '652583e7491b3_IMG_20231010_105626_665.jpg'),
(120, 'H-0065', 'Broca para metal 7/8\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525842fa53a5_IMG_20231010_105659_302.jpg'),
(121, 'H-0066', 'Broca para metal 3/4\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '652584603c277_IMG_20231010_105722_077.jpg'),
(122, 'H-0067', 'Broca para metal 12.50 MM', 1.00, 5, '2024-01-08', 1, 2, 1, 1, '652584a152913_IMG_20231010_105753_757.jpg'),
(123, 'H-0068', 'Pernos para torno 5/16\"', 1.00, 14, '2024-01-08', 1, 2, 1, 1, '6525889da04c5_IMG_20231010_111900_825.jpg'),
(124, 'H-0069', 'Rima CLEVELAND 3/8\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '65258909e297e_IMG_20231010_111931_604.jpg'),
(125, 'H-0070', 'Rima Fenes 3/8\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65258952c5e06_IMG_20231010_112035_863.jpg'),
(126, 'H-0071', 'Rima Fenes 1/2\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65258999e1c99_IMG_20231010_112058_508.jpg'),
(127, 'H-0072', 'Pistola de silicón Grande', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65258d9f1b792_IMG_20231010_113034_246.jpg'),
(128, 'I-0001', 'Barras de silicón 1/2\"', 1.00, 34, '2024-01-08', 2, 2, 1, 1, '65258df2a32fc_IMG_20231010_113138_143.jpg'),
(129, 'I-0002', 'Lentes  de seguridad FOY Ambar', 1.00, 16, '2024-01-08', 2, 2, 1, 1, '65258e42dfb13_IMG_20231010_113233_881.jpg'),
(130, 'I-0003', 'Lentes de seguridad PRETUL Transparentes', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '65258e9d97d1d_IMG_20231010_113315_252.jpg'),
(131, 'I-0004', 'Lentes de seguridad FOY Transparentes', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '65258faddecd5_IMG_20231010_113429_054.jpg'),
(132, 'I-0005', 'Plasti acero 25 ml', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6525913f69a16_IMG_20231010_113453_281.jpg'),
(133, 'I-0006', 'Cinta sella roscas 1/2\" X 7 m', 1.00, 10, '2024-01-08', 2, 2, 1, 1, '6525920b640f5_IMG_20231010_113514_174.jpg'),
(134, 'I-0007', 'Disco de lija Grano 120 fino 5\"', 1.00, 13, '2024-01-08', 2, 2, 1, 1, '6525933e1bb8b_IMG_20231010_113546_500.jpg'),
(136, 'I-0008', 'Disco de lija Grano 80 medio 5\"', 1.00, 11, '2024-01-08', 2, 2, 1, 1, '652593d8eea6c_IMG_20231010_113617_638.jpg'),
(137, 'I-0009', 'Cinta de montaje doble cara 19 mm X 5 m', 1.00, 4, '2024-01-08', 2, 2, 1, 1, '6525944472efc_IMG_20231010_113631_678.jpg'),
(138, 'I-0010', 'Cinta masking 18 mm X 50 m', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6525948a58bdf_IMG_20231010_113650_761.jpg'),
(139, 'I-0011', 'Pistola de silicón Chica', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '652594c2942b8_IMG_20231010_113711_071.jpg'),
(140, 'I-0012', 'Tapones auditivos con triple barrera 25 db', 1.00, 9, '2024-01-08', 2, 2, 1, 1, '6525951016b48_IMG_20231010_113734_333.jpg'),
(141, 'I-0013', 'Guantes de nitrilo Grandes', 1.00, 3, '2024-01-08', 2, 2, 1, 1, '652595508a04e_IMG_20231010_113750_383.jpg'),
(143, 'I-0014', 'Guantes de carnaza Unitalla (trabajo ligero)', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '652595ca65d46_IMG_20231010_113804_572.jpg'),
(144, 'I-0015', 'Portalámpara para tubo flourescente FA8', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '65259615af253_IMG_20231010_113819_730.jpg'),
(145, 'I-0016', 'Manguera para aire tipo resorte 7.6 m', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '652596833170a_IMG_20231010_115933_963.jpg'),
(146, 'I-0017', 'Fumigador doméstico 1 LT.', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '652596c7cc55c_IMG_20231010_120000_943.jpg'),
(147, 'H-0073', 'Martillo de hojalatero 11 OZ.', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65259736a23ab_IMG_20231010_120022_666.jpg'),
(148, 'H-0074', 'Mango para martillo Mango', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525980f04ad2_IMG_20231010_120039_303.jpg'),
(149, 'H-0075', 'Maceta de goma 606', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65259960a900f_IMG_20231010_120105_237.jpg'),
(150, 'H-0076', 'Maceta de goma 808', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65259995d501c_IMG_20231010_120116_822.jpg'),
(151, 'H-0077', 'Extensión eléctrica de uso rudo 16 AWG X 6 MTS', 1.00, 6, '2024-01-08', 1, 2, 1, 1, '65259a2423a75_IMG_20231010_120145_934.jpg'),
(152, 'H-0078', 'Cautín Weller 221-NM-146', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65259c45890f4_IMG_20231010_120456_039.jpg'),
(153, 'H-0079', 'Puntas para multimetro Fluke', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65259ddad49cb_IMG_20231010_120509_094.jpg'),
(154, 'H-0080', 'Punta para cautín CT5A7MX', 1.00, 6, '2024-01-08', 1, 2, 1, 1, '65259ee66b32b_IMG_20231010_120636_659.jpg'),
(155, 'H-0081', 'Punta para cautín PTA7MX', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65259f71740bd_IMG_20231010_120624_780.jpg'),
(156, 'H-0082', 'Resistencia HEW60PMX', 1.00, 3, '2024-01-08', 1, 2, 1, 1, '65259fcaca494_IMG_20231010_120721_513.jpg'),
(158, 'I-0018', 'Disco 40 grano, 115mm, 22mm', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '6525a7a179664_IMG_20231010_120346_523.jpg'),
(162, 'I-0019', 'Esponja para cautín Esponja', 1.00, 4, '2024-01-08', 2, 2, 1, 1, '6525af2672d9e_IMG_20231010_120529_238.jpg'),
(163, 'I-0020', 'Rollo de lija N. 100 1 1/2\" X 148 Ft.', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6525b0191cc09_IMG_20231010_122251_179.jpg'),
(164, 'I-0021', 'Rollo de lija grano 120 38 mm X 45 m', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6525b06eba83a_IMG_20231010_122323_456.jpg'),
(165, 'I-0022', 'Mini cepillo de alambre Surtido', 1.00, 10, '2024-01-08', 2, 2, 1, 1, '6525b0fa58367_IMG_20231010_122411_264.jpg'),
(166, 'H-0083', 'Navaja retráctil 18 mm', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525b1918b595_IMG_20231010_122514_553.jpg'),
(167, 'H-0084', 'Navaja retráctil Pequeña', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525b2121263e_IMG_20231010_122537_660.jpg'),
(168, 'I-0023', 'Repuesto para navajas Repuesto', 1.00, 8, '2024-01-08', 2, 2, 1, 1, '6525b2c625380_IMG_20231010_122544_491.jpg'),
(170, 'H-0085', 'Cuchilla para linóleo 7\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525b34f832e0_IMG_20231010_122619_684.jpg'),
(171, 'I-0024', 'Pila alcalina A76/LR44', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '6525b3ea55aef_IMG_20231010_135502_790.jpg'),
(175, 'H-0086', 'Lima redonda bastarda 10\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525b8f888bd8_IMG_20231010_140631_205.jpg'),
(178, 'H-0087', 'Maneral tipo garrote 5/32\" a 3/4\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525bbfaa970d_IMG_20231010_140616_249.jpg'),
(179, 'H-0088', 'Lima bastarda de media caña escofina 4\"', 70.00, 0, '2024-01-08', 1, 4, 1, 1, '6525bf2c397c0_IMG_20231010_140059_679.jpg'),
(180, 'H-0089', 'Lima triangular de uso regular 5\"', 1.00, 1, '2024-01-08', 1, 1, 1, 1, '6525bfc39a576_IMG_20231010_140110_037.jpg'),
(181, 'H-0090', 'Lima plana 5\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c0e41ba0b_IMG_20231010_140231_563.jpg'),
(182, 'H-0091', 'Bomba desoldadora Extractor', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c13eddb97_IMG_20231010_140308_697.jpg'),
(183, 'H-0092', 'Maneral ajustable 1/16\" X 1/4\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c1d3111fa_IMG_20231010_140321_313.jpg'),
(184, 'H-0093', 'Lima bastarda de media caña 5\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c259c5ab7_IMG_20231010_140403_929.jpg'),
(185, 'H-0094', 'Broca para concreto 1/4\" X 12', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c2e3e549b_IMG_20231010_140424_912.jpg'),
(186, 'H-0095', 'Segueta Diente fino', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c36f1b8b4_IMG_20231010_140447_425.jpg'),
(187, 'H-0096', 'Broca para concreto Longitud 12\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c3eab5029_IMG_20231010_140603_518.jpg'),
(188, 'H-0097', 'Maneral tipo garrote 5/32\" X 3/4\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c46a46249_IMG_20231010_140616_249.jpg'),
(189, 'H-0098', 'Tijera 8\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c520ab147_IMG_20231010_152301_159.jpg'),
(190, 'I-0025', 'Rueda flap con vástago grano 80 Ø 2\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525c5fd16336_IMG_20231010_152326_826.jpg'),
(191, 'I-0026', 'Rueda flap con vástago grano 120 Ø 2\"', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6525c65f73832_IMG_20231010_152326_826.jpg'),
(192, 'I-0027', 'Cuchillas de repuesto para cortador de tubo 18 mm', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6525c82ab8050_IMG_20231010_152338_762.jpg'),
(193, 'H-0099', 'Destornillador de caja 3/8\" X 3\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525c945b5da9_IMG_20231010_152358_564.jpg'),
(194, 'H-0100', 'Desarmador Comfort Grip 75 mm x 3\"', 1.00, 3, '2024-01-08', 1, 2, 1, 1, '6525ca43c0e7c_IMG_20231010_152435_828.jpg'),
(195, 'H-0101', 'Desarmador Screwdriver 7\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525cbc6b03b5_IMG_20231010_152502_653.jpg'),
(196, 'H-0102', 'Desarmador Phillips PH0 x 4\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525cc468391d_IMG_20231010_152543_607.jpg'),
(197, 'H-0103', 'Desarmador de cruz 1/4\" x 4', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525ccd6a8bec_IMG_20231010_152631_435.jpg'),
(198, 'H-0104', 'Dado corto 9/16\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525cd5485220_IMG_20231010_152650_260.jpg'),
(199, 'H-0105', 'Desarmador Plano', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525cda71bafc_IMG_20231010_152722_888.jpg'),
(200, 'H-0106', 'Punzón para barrenar 3/8\"', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6525cf9cb1b93_IMG_20231010_152809_144.jpg'),
(201, 'H-0107', 'Punzón 5/16\" X 1/8\"', 1.00, 3, '2024-01-08', 1, 2, 1, 1, '6525cfd0b2658_IMG_20231010_152923_737.jpg'),
(202, 'H-0108', 'Destornillador de caja 7 mm', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6525d0405cc72_IMG_20231010_152942_826.jpg'),
(203, 'H-0109', 'llave ajustable 6\" marca: FOY', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '652874bb6fa72_IMG_20231010_154434_712.jpg'),
(204, 'H-0110', 'Llave de presión 10\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6528751b2fbb0_IMG_20231010_154521_868.jpg'),
(205, 'H-0111', 'pinzas para anillos de retención. desde 65mm hasta 12mm', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6528758810807_IMG_20231010_154539_966.jpg'),
(206, 'H-0112', 'Pinzas de presión Tipo prensa', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '65287606afac3_IMG_20231010_154605_145.jpg'),
(208, 'H-0113', 'pinzas de punta medianas', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '652876a891028_IMG_20231010_154616_619.jpg'),
(209, 'H-0114', 'Pinzas para anillo de retención de 90grados', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '652876fc979d2_IMG_20231010_154629_828.jpg'),
(210, 'H-0115', 'Matraca 3/8\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6528775b9ea45_IMG_20231010_154639_333.jpg'),
(211, 'H-0116', 'juego de llaves Allen tipo navaja estándar', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6528781895bd7_IMG_20231010_154720_527.jpg'),
(212, 'H-0117', 'llave combinada. 3/8\" X 16cm', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6529acbf18aa1_IMG_20231010_154821_267.jpg'),
(213, 'H-0118', 'Llave combinada 9/16\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6529b93ac3c8c_IMG_20231010_155051_770.jpg'),
(214, 'H-0119', 'Dado Corto 9/16\" 9/16\" marca SURTEK', 30.00, 1, '2024-01-08', 1, 2, 1, 1, '6532f3afa9ab7_IMG_20231020_153551_656_hdr.jpg'),
(216, 'I-0028', 'Brocha 1\" 1\" Marca Comex', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6532f541a667b_IMG_20231020_153607_481_hdr.jpg'),
(218, 'H-0120', 'Llave Mixta 1/2\" 1/2\" Marca Urrea', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6536ea0dc3f5e_IMG_20231010_155121_905.jpg'),
(219, 'H-0121', 'Llave Mixta 3/8\" 3/8\" Marca Urrea', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6536ea8d57ef4_IMG_20231010_155144_754.jpg'),
(220, 'H-0122', 'Llave Allen 3/16\" Llave Allen 3/16\"', 1.00, 3, '2024-01-08', 1, 2, 1, 1, '6536eba15e073_IMG_20231010_155208_965.jpg'),
(221, 'H-0123', 'Llave Allen 3.0mm Llave Allen 3.0mm', 1.00, 6, '2024-01-08', 1, 2, 1, 1, '6536ec2182e0e_IMG_20231010_155230_884.jpg'),
(222, 'H-0124', 'Llave Allen 5/32\" Llave Allen 5/32\"', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6536ec7417827_IMG_20231010_155305_259.jpg'),
(223, 'H-0125', 'Llave Allen 5/64\" Llave Allen 5/64\"', 1.00, 13, '2024-01-08', 1, 2, 1, 1, '6536ecbd71cce_IMG_20231010_155322_039.jpg'),
(224, 'H-0126', 'Llave Allen 1/8\" Llave Allen 1/8\"', 1.00, 9, '2024-01-08', 1, 2, 1, 1, '6536ed14c3b40_IMG_20231010_155448_355.jpg'),
(225, 'H-0127', 'Llave Allen tipo T 3/32\" Llave Allen tipo T 3/32\"', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '6536ed6bb7880_IMG_20231010_155505_574.jpg'),
(226, 'H-0128', 'Llave Allen Tipo T 1/8\" Llave Allen Tipo T 1/8\" ', 1.00, 4, '2024-01-08', 1, 2, 1, 1, '6536eea290400_IMG_20231010_155516_199.jpg'),
(227, 'H-0129', 'Maneral ajustable tipo T 1/2\" Maneral ajustable tipo T 1/2\" marca truper', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6536efa239bbb_IMG_20231010_155708_862.jpg'),
(228, 'H-0130', 'Maneral Tipo T ajustable 3/16\" Maneral Tipo T ajustable 3/16\" marca Surtek', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6536effe5e1b3_IMG_20231010_155730_317.jpg'),
(229, 'H-0131', 'Manera Tipo T ajustable 1/4\" Manera Tipo T ajustable 1/4\" marca truper', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6536f05aef38d_IMG_20231010_155813_643.jpg'),
(230, 'H-0132', 'Broquero 1/2\" Broquero 1/2\" marca truper', 1.00, 1, '2024-01-08', 1, 2, 1, 1, '6536f0b0bc6f6_IMG_20231010_155800_670.jpg'),
(232, 'I-0029', 'Cople Rápido Macho Cople Rápido Macho', 1.00, 4, '2024-01-08', 2, 2, 1, 1, '6536f2171b4fa_IMG_20231010_155836_005.jpg'),
(233, 'I-0030', 'Cople rápido hembra Cople rápido hembra surtek', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '6536f287a1b0f_IMG_20231010_155848_071.jpg'),
(234, 'I-0031', 'Cople rápido hembra Cople rápido hembra marca truper', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6536f2bec2c4d_IMG_20231010_155903_289.jpg'),
(235, 'H-0133', 'Flexometro 5m x 16\" Flexometro 5m x 16\" truper', 1.00, 2, '2024-01-08', 1, 2, 1, 1, '6536f34d60237_IMG_20231010_155922_495.jpg'),
(236, 'I-0032', 'Pila 2016 de 3V Pila 2016 de 3V marca steren', 1.00, 11, '2024-01-08', 2, 2, 1, 1, '6536f46a4b3ac_IMG_20231010_160102_979.jpg'),
(238, 'I-0033', 'Pila AA 1.5V Pila AA 1.5V marca RadioShack', 1.00, 6, '2024-01-08', 1, 2, 1, 1, '6536f64d64536_IMG_20231010_160316_111.jpg'),
(239, 'I-0034', 'Pila AAA Pila AAA marca duracel', 1.00, 6, '2024-01-08', 2, 2, 1, 1, '6536f6af551d7_IMG_20231010_160547_272.jpg'),
(240, 'I-0035', 'Pila 9V Pila 9V marca Duracell', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6536f736d0c06_IMG_20231010_160446_493.jpg'),
(241, 'I-0036', 'Gas butano Gas butano Pretul', 1.00, 2, '2024-01-08', 2, 2, 1, 1, '6536f76a9dc4b_IMG_20231010_160737_064.jpg'),
(242, 'I-0037', 'WD40 WD40', 1.00, 1, '2024-01-08', 2, 2, 1, 1, '6536f79498c77_IMG_20231010_160757_880.jpg'),
(243, 'MPM-001', 'Barra redonda INOX 1/8\" X 1.20cm Barra redonda INOX 1/8\" X 1.20cm', 80.00, 5, '2024-01-08', 7, 1, 1, 1, '6536f804ad445_IMG-20231016-WA0001.jpg'),
(245, 'MARC001-5B', 'Tornillo mesa incisal ', 20.00, 20, '2024-01-08', 4, 3, 1, 1, '653ad8eb74bfc_IMG_20231010_16081.jpg'),
(246, 'I-0038', 'Bolsas para basura. Bolsas para basura, para desperdicio de maquinado.', 50.00, 10, '2024-01-08', 2, 4, 1, 1, '653ad8eb74bfc_IMG_20231010_160813_434.jpg'),
(247, 'MARC001-5Ñ', 'Cóndilo Cóndilo sin pulir.', 20.00, 15, '2024-01-08', 4, 3, 1, 1, '653ada08abb5c_condilo.jpg'),
(248, 'MARC001-4J', 'Tornillo para elastómero Tornillo para elastómero sin pulir.', 20.00, 0, '2024-01-08', 4, 3, 1, 1, '653ade70bc6c0_dhjasdkjadljAFKADADKADLKahjkdahdkahd12651.jpg'),
(253, 'H-0134', 'Boquilla ER25 1/2\" ER25 1/2\"', 532.50, 2, '2024-01-08', 1, 2, 1, 1, '20231027_162509.jpg'),
(254, 'H-0135', 'Cortador 5/8\" HSS 5/8\" HSS', 1032.40, 0, '2024-01-08', 1, 2, 1, 1, '20231027_162528.jpg'),
(255, 'H-0136', 'Broca 28 Broca 28', 50.75, 3, '2024-01-08', 1, 2, 1, 1, '20231027_162546.jpg'),
(256, 'H-0137', 'Broca 29 Broca 29', 50.75, 3, '2024-01-08', 1, 2, 1, 1, '20231027_162601.jpg'),
(257, 'H-0138', 'Broca 30 Broca 30', 50.75, 2, '2024-01-08', 1, 2, 1, 1, '20231027_162608.jpg'),
(258, 'H-0139', 'Broca para metal 7/32\" Broca para metal 7/32\"', 80.75, 5, '2024-01-08', 1, 2, 1, 1, 'IMG_20231030_132125_501_hdr.jpg'),
(259, 'MARC001-5X', 'Porta platina Porta platina MARC001-5X ', 40.00, 44, '2024-01-08', 4, 3, 1, 1, 'IMG_20231031_085206_665_hdr.jpg'),
(260, 'MARC001-5Q', 'Tornillo para varilla de soporte Tornillo para varilla de soporte MARC001-5Q', 8.00, 20, '2024-01-08', 4, 3, 1, 1, 'IMG_20231031_085129_359_hdr.jpg'),
(261, 'MARC001-6D', 'Tornillo para retención de base superior. Tornillo para retención de base superior. (TORNILLO SUJECION 3) MARC001-6D', 8.00, 27, '2024-01-08', 4, 3, 1, 1, 'IMG_20231031_085117_602_hdr.jpg'),
(262, 'MARC001-4Ñ', 'VARILLA DE SOPORTE VARILLA DE SOPORTE MARC001-4ñ', 40.00, 0, '2024-01-08', 4, 3, 1, 1, 'IMG_20231031_085158_182_hdr.jpg'),
(263, 'MARC001-4W', 'Perno 4 sujecion nivel Tornillo para varilla niveladora (área de nivel de altura)', 35.00, 0, '2024-01-08', 4, 3, 1, 1, 'IMG_20231031_085140_134_hdr.jpg'),
(264, 'MARC001-5C', 'Pernos para sujeción de porta platina Pernos para sujeción de porta platina, MARC001-5C', 10.00, 0, '2024-01-08', 4, 3, 1, 1, 'pernos.jpg'),
(265, 'I-0039', 'Kola loka Pegamento kola loka', 20.00, 10, '2024-01-08', 11, 4, 1, 1, 'IMG_20231101_080204_317_hdr.jpg'),
(266, 'I-0040', 'Disco para esmeriladora angular para corte de metal 4 1/2\" Disco para esmeriladora angular para corte de metal 4 1/2\"  marca maxtool', 50.00, 3, '2024-01-08', 11, 4, 1, 1, 'IMG_20231101_120033_192_hdr.jpg'),
(267, 'P-0001', 'Hojas Blancas paquete 500 hojas Hojas Blancas paquete 500 hojas', 1.00, 3, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_124600_652_hdr.jpg'),
(268, 'P-0002', 'Etiquetas redondas dorada paquete Etiquetas redondas dorada paquete', 1.00, 4, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_124920_580_hdr.jpg'),
(269, 'P-0003', 'Grapas caja de 5000 pzas. Grapas caja de 5000 pzas.', 1.00, 2, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_125114_229_hdr.jpg'),
(270, 'P-0004', 'Libreta profesional cuadro grande Libreta profesional cuadro grande', 20.00, 5, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_125216_282_hdr.jpg'),
(271, 'P-0005', 'Hojas de colores combinadas Hojas de colores combinadas por hojas', 1.00, 150, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_125341_661_hdr.jpg'),
(272, 'P-0006', 'Protectores de hojas Protectores de hojas por pieza', 1.00, 60, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_124600_652_hdr_654c02cef14dc.jpg'),
(273, 'P-0007', 'Folder azul Folder azul', 1.00, 70, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_125216_282_hdr_654c0317801c3.jpg'),
(274, 'P-0008', 'Tinta color azul Tinta color roja', 1.00, 1, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_125834_988_hdr.jpg'),
(275, 'P-0009', 'Tinta color negro Tinta color negro', 1.00, 1, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_125841_629_hdr.jpg'),
(276, 'P-0010', 'Cinta chica transparente scotch 550 Cinta chica transparente scotch 550', 1.00, 7, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_130008_700_hdr.jpg'),
(277, 'P-0011', 'Marcador sharpie delgado punto fino color rojo. Marcador sharpie delgado punto fino color rojo.', 10.30, 12, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_130629_590_hdr.jpg'),
(278, 'P-0012', 'Marcador Sharpie delgado punto fino color negro Marcador Sharpie delgado punto fino color negro', 17.10, 8, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_130751_772_hdr.jpg'),
(279, 'P-0013', 'Marcador BIC delgado punto fino color negro Marcador BIC delgado punto fino color negro', 17.40, 6, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_130847_249_hdr.jpg'),
(280, 'P-0014', 'Marcador Baco delgado punto fino color azul Marcador Baco delgado punto fino color azul', 18.00, 8, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_130937_485_hdr.jpg'),
(281, 'p-0015', 'Bolígrafo Azor punto fino color negro Bolígrafo Azor punto fino color negro', 1.00, 8, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131122_472_hdr.jpg'),
(282, 'P-0016', 'Bolígrafo azor punto fino color rojo Bolígrafo azor punto fino color rojo', 1.00, 6, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131146_164_hdr.jpg'),
(283, 'P-0017', 'Bolígrafo Azor punto fino color azul Bolígrafo Azor punto fino color azul', 1.00, 6, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131236_084_hdr.jpg'),
(284, 'P-0018', 'Marcador Esterbrook negro Marcador Esterbrook negro', 28.12, 4, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131330_455_hdr.jpg'),
(285, 'P-0019', 'Marcador Esterbrook color azul Marcador Esterbrook color azul', 28.12, 4, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131521_459_hdr.jpg'),
(286, 'P-0020', 'Marcador Esterbrook color rojo Marcador Esterbrook color rojo', 28.12, 2, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132237_713_hdr.jpg'),
(287, 'P-0021', 'Boligrafo BIC color negro punto fino Boligrafo BIC color negro punto fino', 1.00, 4, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131634_257_hdr.jpg'),
(288, 'P-0022', 'Bolígrafo BIC color negro punto mediano Bolígrafo BIC color negro punto mediano', 1.00, 5, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_131711_565_hdr.jpg'),
(289, 'P-0023', 'Lapiz Paper Mate HB 2.5 Lapiz Paper Mate HB 2.5', 1.00, 12, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132053_648_hdr.jpg'),
(290, 'P-0024', 'Marcador Azor grueso color rojo Marcador Azor grueso color rojo', 15.24, 2, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132209_726_hdr.jpg'),
(291, 'P-0025', 'Marcador sharpie punto ultra fino color negro Marcador sharpie punto ultra fino color negro', 17.10, 5, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132331_183_hdr.jpg'),
(292, 'P-0026', 'Marcador colores surtido Marcador colores surtido', 11.20, 4, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132107_774_hdr.jpg'),
(293, 'P-0027', 'Marcador Magistral color negro Marcador Magistral color negro', 18.62, 4, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132439_110_hdr.jpg'),
(294, 'P-0028', 'Lapiz adhesivo Dixon Lapiz adhesivo Dixon', 1.00, 6, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132710_926_hdr.jpg'),
(295, 'P-0029', 'Masking Tape Janel 24mm Masking Tape Janel 24mm', 23.66, 5, '2024-01-08', 6, 5, 1, 1, 'IMG_20231108_132844_337_hdr.jpg'),
(296, 'H-0140', 'Disco para esmeril, corte de metal, delgado de 4-1/2\" marca Astromex', 50.00, 2, '2024-01-08', 11, 4, 1, 1, 'IMG20231110103057.jpg'),
(297, 'H-141', 'Boquilla ER40 1/4\" (7-6mm) Boquilla ER40 1/4\" (7-6mm)', 580.00, 0, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133250.jpg'),
(298, 'H-0142', 'Boquilla ER32 3/32\" (3-2mm) Boquilla ER32 3/32\" (3-2mm)', 539.00, 0, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133258.jpg'),
(299, 'H-0143', 'Rima recta 3/16\" clevelan Rima recta 3/16\" clevelan', 882.00, 1, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133317.jpg'),
(300, 'H-0144', 'Broca HSS 4F 3/32\" Cleveland Broca HSS 4F 3/32\" Cleveland', 28.00, 10, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133421.jpg'),
(301, 'H-0145', 'Sierra cinta classic 3/4\" X 39\" 6-10 dientes Lenox Sierra cinta classic 3/4\" X 39\" 6-10 dientes Lenox', 960.00, 0, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133636.jpg'),
(302, 'H-0146', 'Broca HSS #7 Cleveland Broca HSS #7 Cleveland', 50.75, 6, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133415.jpg'),
(303, 'H-0147', 'Broca HSS #20 Cleveland Broca HSS #20 Cleveland', 50.75, 6, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133410.jpg'),
(304, 'H-148', 'Cortador vertical de HSS 4F 1/8\" CLEV Cortador vertical de HSS 4F 1/8\" CLEV', 340.75, 2, '2024-01-08', 1, 2, 1, 1, 'IMG20231110133343.jpg'),
(305, 'I-0041', 'Plasti Loka Plasti Loka', 25.00, 2, '2024-01-08', 11, 4, 1, 1, 'IMG20231114083449.jpg'),
(306, 'MARC001-6M', 'Tornillo de sujeción 2, (tornillo para Portaplatina y base de calibración. Tornillo de sujeción 2, (tornillo para Portaplatina y base de calibración.', 10.00, 40, '2024-01-08', 4, 3, 1, 1, 'IMG_20231003_085415_568_hdr.jpg'),
(307, 'MARC001-6G', 'Soporte para pantalla central Soporte para pantalla central', 25.00, 31, '2024-01-08', 4, 3, 1, 1, 'IMG_20231027_075910_962_hdr.jpg'),
(308, 'MARC001-5J', 'Pantalla de Registro Derecha Pantalla de Registro Derecha', 15.00, 34, '2024-01-08', 4, 3, 1, 1, 'IMG_20231010_075948_466.jpg'),
(309, 'MARC001-5H', 'Pantalla de registro izquierda Pantalla de registro izquierda', 15.00, 34, '2024-01-08', 4, 3, 1, 1, 'pantallas derechas.jpg'),
(310, 'MARC001-5A', 'Mesa Incisal Mesa Incisal', 25.00, 20, '2024-01-08', 4, 3, 1, 1, 'IMG_20230913_083850_991_hdr.jpg'),
(311, 'MARC001-5T', 'Varilla para Sujeción Central Varilla para Sujeción Central', 25.00, 19, '2024-01-08', 4, 3, 1, 1, 'varillacentral.jpg'),
(312, 'S/C', '', 0.00, 100, '2024-01-08', 7, 6, 1, 1, 'IMG20231122153955.jpg'),
(313, 'I-0042', 'Gasolina Blanca Gasolina Blanca ', 90.00, 20, '2024-01-08', 2, 7, 1, 1, 'IMG20231114130100.jpg'),
(314, 'I-0043', 'Retazo de Trapo blanco Retazo de Trapo blanco', 100.00, 20, '2024-01-08', 2, 7, 1, 1, 'IMG20231114130103.jpg'),
(315, 'H-0149', 'Boquilla ER40 1/8\"(4-3) Boquilla ER40 1/8\"(4-3)', 580.00, 2, '2024-01-08', 1, 2, 1, 1, 'IMG20231122115247.jpg'),
(316, 'H-0150', 'Broca numerica #19 Cleveland Broca numerica #19 Cleveland', 50.75, 5, '2024-01-08', 1, 2, 1, 1, 'IMG20231122115311.jpg'),
(317, 'H-0151', 'Llave allen bola 3/32\" en L Llave allen bola 3/32\" en L', 38.00, 10, '2024-01-08', 1, 2, 1, 1, 'IMG20231122115332.jpg'),
(318, 'H-0152', 'Broca HSS 1/8\" larga Broca HSS 1/8\" larga', 50.75, 2, '2024-01-08', 1, 2, 1, 1, 'IMG20231122115411.jpg'),
(319, 'I-0044', 'Playo para empaque rollo chico Playo para empaque rollo chico', 40.00, 2, '2024-01-08', 2, 4, 1, 1, 'IMG20231114130404.jpg'),
(320, 'MARC001-4Q', 'SEGURO', 15.00, 0, '2024-01-08', 4, 3, 1, 1, 'IMG20231116145914.jpg'),
(321, 'MARC001-4K', 'Varilla para Nivel Varilla para Nivel', 25.00, 1, '2024-01-08', 4, 3, 1, 1, 'Captura de pantalla 2023-11-23 140637.png'),
(322, 'MARC001-5R', 'Pin de Marca Central Pin de Marca Central', 10.00, 0, '2024-01-08', 4, 3, 1, 1, 'Captura de pantalla 2023-11-23 141330.png'),
(323, 'I-0045', 'Cuchillas, Navajas de repuesto de 18mm Cuchillas, Navajas de repuesto de 18mm', 3.14, 17, '2024-01-08', 2, 4, 1, 1, '.trashed-1703363215-IMG20231123142433.jpg'),
(324, 'H-0153', 'Lima Plana Muza de 8\" con mango Lima Plana Muza de 8\" con mango', 65.52, 2, '2024-01-08', 1, 4, 1, 1, 'IMG20231123143139.jpg'),
(325, 'H-0154', 'Juego de 11 Brocas para Metal y concreto Juego de 11 Brocas para Metal y concreto', 176.00, 1, '2024-01-08', 1, 4, 1, 1, 'IMG20231123142325.jpg'),
(326, 'I-0046', 'Guantes de nylon recubiertos de poliuretano MEDIANOS Guantes de nylon recubiertos de poliuretano MEDIANOS', 42.00, 5, '2024-01-08', 2, 4, 1, 1, 'IMG20231123142300.jpg'),
(327, 'I-0047', 'Guantes de nylon recubiertos de poliuretano GRANDES Guantes de nylon recubiertos de poliuretano GRANDES', 42.24, 5, '2024-01-08', 2, 4, 1, 1, 'IMG20231123142307.jpg'),
(328, 'H-0155', 'Escuadra Para Carpintero de 8\" Escuadra Para Carpintero de 8\"', 99.00, 2, '2024-01-08', 1, 4, 1, 1, 'IMG20231123142858.jpg'),
(329, 'I-0048', 'Segueta bimetálica de 18DPP largo de 12\" Segueta bimetálica de 18DPP largo de 12\"', 20.25, 6, '2024-01-08', 2, 4, 1, 1, 'IMG20231123143300.jpg'),
(330, 'I-0049', 'Segueta Bimetálica de 24DPP, 12\" de largo Segueta Bimetálica de 24DPP, 12\" de largo', 20.25, 6, '2024-01-08', 2, 4, 1, 1, 'IMG20231123143322.jpg'),
(331, 'H-0156', 'Llave combinada de 1/2\" X 170mm. de largo Llave combinada de 1/2\" X 170mm. de largo', 25.00, 1, '2024-01-08', 1, 4, 1, 1, 'IMG20231123143227.jpg'),
(332, 'H-0157', 'Llave combinada 9/16\" X 180mm de largo Llave combinada 9/16\" X 180mm de largo', 30.17, 1, '2024-01-08', 1, 4, 1, 1, 'IMG20231123143215.jpg'),
(338, 'H-0159', 'Broca de cobalto C/ Alcrona 1/8\" X 70mm Corte 13mm largo total DORMER', 756.00, 2, '2024-01-08', 1, 2, 1, 1, 'IMG20231206152658.jpg'),
(339, 'H-0160', 'Broca HSS Alfabética Letra \"B\" CLEVELAND', 65.25, 4, '2024-01-08', 1, 2, 1, 1, 'IMG20231206152430.jpg'),
(340, 'I-0050', 'Nivel de gota para arco facial', 3.00, 92, '2024-01-08', 2, 4, 1, 1, 'IMG20231206161640.jpg'),
(341, 'H-0161', 'Inserto de carburo A4R125I03P00GMN KCU10 KENNAMETAL', 546.00, 0, '2024-01-08', 1, 2, 1, 1, 'IMG20240102133744.jpg'),
(342, 'H-0162', 'PortaHerramientas Derecho A4SMR1616K0314 KENNAMETAL', 3208.75, 0, '2024-01-08', 1, 2, 1, 1, 'IMG20240102133754.jpg'),
(343, 'H-0163', 'Broca HSS Alfabetica Letra \"D\" Clev', 65.25, 5, '2024-01-08', 1, 2, 1, 1, 'IMG20240102134457.jpg'),
(344, 'H-0164', 'BROCA HSS NUMERICA \"#30\" CLEV', 43.50, 5, '2024-01-08', 1, 2, 1, 1, 'IMG20240102133730.jpg'),
(345, 'H-0165', 'Broca HSS Alfabetica Letra \"N\" CLEV', 85.55, 5, '2024-01-08', 1, 2, 1, 1, 'IMG20240102134427.jpg'),
(346, 'H-0166', 'Broca HSS Numerica \"#15\" CLEV', 50.75, 5, '2024-01-08', 1, 2, 1, 1, 'IMG20240102133812.jpg'),
(347, 'H-0167', 'RIMA HSS 3/16\"', 913.50, 1, '2024-01-08', 1, 2, 1, 1, 'IMG20240102134304.jpg'),
(350, 'MARC001-6F', 'PERNO PARA PANTALLA CENTRAL DE 1 1/2\" x 1/4\"', 10.00, 19, '2024-01-08', 4, 3, 1, 1, 'PERNO_PARA_PANTALLA_46.jpg'),
(351, 'MARC001-6N', 'PERNO 2 DE PANTALLA CENTRAL DE 1 1/4\" x 3/16\"', 10.00, 19, '2024-01-08', 4, 4, 1, 1, 'PERNO_2_DE_PANTALLA_CENTRAL_DE_1_1_4_x_3_16_63.jpg'),
(352, 'MARC001-5W', 'PERNO 2 PARA PANTALLA DERECHA O IZQUIERDA DE 1 pulgada x 5-16 pulgadas', 10.00, 36, '2024-01-08', 4, 4, 1, 1, 'PERNO_2_PARA_PANTALLA_DERECHA_O_IZQUIERDA_DE_1_pulgada_x_5-16_pulgadas_89.jpg'),
(353, 'MARC001-4X', 'IMAN DE NEODIMIO CUADRADO DE 15X15X3MM', 14.09, 100, '2024-01-08', 4, 4, 1, 1, 'IMAN_DE_NEODIMIO_DE_15X15X3MM_96.jpg'),
(354, 'MARC001-5D', 'BASE INFERIOR', 116.17, 21, '2024-01-08', 4, 3, 1, 1, 'BASE_INFERIOR_32.png'),
(355, 'MARC001-6H', 'PANTALLA CENTRAL', 113.18, 21, '2024-01-08', 4, 3, 1, 1, 'PANTALLA_CENTRAL_28.png'),
(356, 'MARC001-5F', 'BASTIDOR MARCO CPI', 325.38, 21, '2024-01-08', 4, 3, 1, 1, 'BASTIDOR_MARCO_CPI_19.png'),
(358, 'MARC001-5M', 'IMAN DE NEODIMIO REDONDO 3/4 x 0.100', 26.68, 96, '2024-01-14', 4, 4, 1, 1, 'IMG20231122153955.jpg'),
(359, 'MARC001-5Z', 'PERNO 1 PARA PANTALLA DERECHA O IZQUIERDA DE 1\" x 1/4\"', 10.00, 38, '2024-01-15', 4, 4, 1, 1, 'perno1pantalla.png'),
(360, 'MARC001-7M', 'SOPORTE NASAL', 10.00, 1, '2024-01-16', 4, 3, 1, 1, 'SOPORTE_NASAL_77.png'),
(361, 'MARC001-7W', 'CONECTOR 2 HORQUILLA', 10.00, 2, '2024-01-16', 4, 3, 1, 1, 'CONECTOR_2_HORQUILLA_28.png'),
(362, 'MARC001-7K', 'CONECTOR 1 HORQUILLA', 10.00, 2, '2024-01-16', 4, 3, 1, 1, 'CONECTOR_1_HORQUILLA_12.png'),
(363, 'MARC001-7T', 'OLIVA', 10.00, 2, '2024-01-16', 4, 3, 1, 1, 'OLIVA_39.png'),
(364, 'MARC001-7Y', 'TRAVESAÑO PARA PERNO', 20.00, 2, '2024-01-16', 4, 3, 1, 1, 'TRAVESAÑO_PARA_PERNO_39.png'),
(365, 'MARC001-8A', 'TORNILLO GRANDE', 30.00, 1, '2024-01-16', 4, 3, 1, 1, 'TORNILLO_GRANDE_15.png'),
(366, 'H-0168', 'BOQUILLA ER32 3/16\" (5-4)', 539.00, 1, '2024-01-16', 1, 2, 1, 1, 'BOQUILLA_ER32_17.jpg'),
(367, 'H-0169', 'MACHUELO HELICOIDAL M4 x 0.7 ROYCO', 769.50, 4, '2024-01-16', 1, 2, 1, 1, 'MACHUELO_HELICOIDAL_M4_x_0.7_ROYCO_28.jpg'),
(368, 'H-0170', 'MACHUELO HELICOIDAL M5 x 0.8 ROYCO', 769.50, 4, '2024-01-16', 1, 2, 1, 1, 'MACHUELO_HELICOIDAL_M5_x_0.8_ROYCO_21.jpg'),
(369, 'H-0171', 'MACHUELO HELICOIDAL M6 x 1 ROYCO', 769.50, 2, '2024-01-16', 1, 2, 1, 1, 'MACHUELO_HELICOIDAL_M6_x_1_ROYCO_68.jpg'),
(370, 'H-0172', 'MACHUELO GUN 2F  3/16\" - 24 ROYCO', 152.25, 4, '2024-01-16', 1, 2, 1, 1, 'MACHUELO_GUN_2F__3_16_-_24_ROYCO_33.jpg'),
(371, 'H-0173', 'CORTADOR VERTICAL RECTO 1/2\" 4FL ALTIN', 1222.00, 2, '2024-01-16', 1, 2, 1, 1, 'CORTADOR_VERTICAL_RECTO_1_2_4FL_ALTIN_27.jpg'),
(372, 'H-0174', 'CORTADOR DE CARBURO LARGO 1/8\" x 4\" 4FL BRILLANTE', 504.00, 2, '2024-01-16', 1, 2, 1, 1, 'CORTADOR_DE_CARBURO_LARGO_1_8_x_4_4FL_BRILLANTE_75.jpg'),
(373, 'H-0175', 'BROCA DE CENTRO #1 CLEV', 72.50, 4, '2024-01-16', 1, 2, 1, 1, 'BROCA_DE_CENTRO_1_CLEV_0.jpg'),
(374, 'H-0176', 'CORTADOR VERTOCAL A.V. 4F 3mm GREEBFIELD', 145.00, 4, '2024-01-16', 1, 2, 1, 1, 'CORTADOR_VERTOCAL_A.V._4F_3mm_GREEBFIELD_59.jpg'),
(375, 'H-0177', 'MACHUELO HELICOIDAL N10-24 ROYCO', 540.00, 4, '2024-01-16', 1, 2, 1, 1, 'MACHUELO_HELICOIDAL_N10-24_ROYCO_95.jpg'),
(376, 'MARC001-5K', 'VARILLA DE NIVEL', 4.63, 16, '2024-01-18', 4, 3, 1, 1, 'VARILLA_DE_NIVEL_18.png'),
(377, 'MARC001-5Y', 'BASE COLUMNA DE CALIBRACION', 158.50, 21, '2024-01-18', 4, 3, 1, 1, 'BASE_COLUMNA_DE_CALIBRACION_97.png');

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
(11, 'DISTRIBUIDORA DE HERRAMIENTAS INGHECO S DE RL DE CV', 'DHI160120JA1', 'francisco.gonzalez@ingheco.com.mx', '5519531412', 'Calle y número: Avenida Hacienda El Roble Mz. 5 Lt. 31 Cond. 70 Int. 297\r\nColonia: Hacienda Cuautitlán Delegación y Municipio: Cuautitlán México\r\nCódigo postal: 54803 Entidad Federativa: Estado de México', 'Francisco Gonzalez Gutierrez');

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
(49, 1, 2),
(49, 2, 0),
(49, 3, 0),
(50, 1, 10),
(50, 2, 0),
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
(60, 2, 0),
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
(72, 1, 3),
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
(84, 1, 9),
(84, 2, 0),
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
(94, 1, 2),
(94, 2, 0),
(94, 3, 0),
(95, 1, 2),
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
(104, 1, 4),
(104, 2, 0),
(104, 3, 0),
(105, 1, 14),
(105, 2, 0),
(105, 3, 0),
(106, 1, 4),
(106, 2, 0),
(106, 3, 0),
(107, 1, 4),
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
(112, 1, 8),
(112, 2, 0),
(112, 3, 0),
(114, 1, 7),
(114, 2, 0),
(114, 3, 0),
(115, 1, 13),
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
(137, 1, 4),
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
(156, 1, 3),
(156, 2, 0),
(156, 3, 0),
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
(183, 1, 1),
(183, 2, 0),
(183, 3, 0),
(184, 1, 1),
(184, 2, 0),
(184, 3, 0),
(185, 1, 1),
(185, 2, 0),
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
(189, 1, 1),
(189, 2, 0),
(189, 3, 0),
(190, 1, 1),
(190, 2, 0),
(190, 3, 0),
(191, 1, 1),
(191, 2, 0),
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
(199, 1, 1),
(199, 2, 0),
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
(204, 1, 1),
(204, 2, 0),
(204, 3, 0),
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
(216, 1, 1),
(216, 2, 0),
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
(238, 1, 6),
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
(245, 1, 3),
(245, 2, 0),
(245, 3, 0),
(246, 1, 10),
(246, 2, 0),
(246, 3, 0),
(247, 1, 16),
(247, 2, 0),
(247, 3, 0),
(248, 1, 4),
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
(259, 1, 8),
(259, 2, 0),
(259, 3, 0),
(260, 1, 1),
(260, 2, 0),
(260, 3, 0),
(261, 1, 2),
(261, 2, 0),
(261, 3, 0),
(262, 1, 1),
(262, 2, 0),
(262, 3, 0),
(263, 1, 1),
(263, 2, 0),
(263, 3, 0),
(264, 1, 12),
(264, 2, 0),
(264, 3, 0),
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
(285, 1, 4),
(285, 2, 0),
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
(295, 1, 5),
(295, 2, 0),
(295, 3, 0),
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
(303, 1, 6),
(303, 2, 0),
(303, 3, 0),
(304, 1, 2),
(304, 2, 0),
(304, 3, 0),
(305, 1, 2),
(305, 2, 0),
(305, 3, 0),
(306, 1, 14),
(306, 2, 0),
(306, 3, 0),
(307, 1, 6),
(307, 2, 0),
(307, 3, 0),
(308, 1, 13),
(308, 2, 0),
(308, 3, 0),
(309, 1, 12),
(309, 2, 0),
(309, 3, 0),
(310, 1, 13),
(310, 2, 0),
(310, 3, 0),
(311, 1, 15),
(311, 2, 0),
(311, 3, 5),
(312, 1, 100),
(312, 2, 0),
(312, 3, 0),
(313, 1, 20),
(313, 2, 0),
(313, 3, 0),
(314, 1, 20),
(314, 2, 0),
(314, 3, 0),
(315, 1, 2),
(315, 2, 0),
(315, 3, 0),
(316, 1, 5),
(316, 2, 0),
(316, 3, 0),
(317, 1, 10),
(317, 2, 0),
(317, 3, 0),
(318, 1, 2),
(318, 2, 0),
(318, 3, 0),
(319, 1, 6),
(319, 2, 0),
(319, 3, 0),
(320, 1, 5),
(320, 2, 0),
(320, 3, 0),
(321, 1, 0),
(321, 2, 0),
(321, 3, 1),
(322, 1, 0),
(322, 2, 0),
(322, 3, 0),
(323, 1, 17),
(323, 2, 0),
(323, 3, 0),
(324, 1, 2),
(324, 2, 0),
(324, 3, 0),
(325, 1, 1),
(325, 2, 0),
(325, 3, 0),
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
(343, 1, 5),
(343, 2, 0),
(343, 3, 0),
(344, 1, 5),
(344, 2, 0),
(344, 3, 0),
(345, 1, 5),
(345, 2, 0),
(345, 3, 0),
(346, 1, 5),
(346, 2, 0),
(346, 3, 0),
(347, 1, 1),
(347, 2, 0),
(347, 3, 0),
(350, 1, 20),
(350, 2, 0),
(350, 3, 0),
(351, 1, 20),
(351, 2, 0),
(351, 3, 0),
(352, 1, 36),
(352, 2, 4),
(352, 3, 0),
(353, 1, 100),
(353, 2, 0),
(353, 3, 0),
(354, 1, 27),
(354, 2, 0),
(354, 3, 0),
(355, 1, 21),
(355, 2, 0),
(355, 3, 0),
(356, 1, 18),
(356, 2, 0),
(356, 3, 0),
(358, 1, 100),
(359, 1, 38),
(359, 2, 2),
(359, 3, 0),
(360, 1, 1),
(361, 1, 2),
(362, 1, 2),
(363, 1, 2),
(364, 1, 2),
(365, 1, 1),
(366, 1, 1),
(366, 2, 1),
(366, 3, 0),
(367, 1, 4),
(368, 1, 4),
(369, 1, 2),
(369, 2, 2),
(369, 3, 0),
(370, 1, 4),
(371, 1, 1),
(371, 2, 1),
(372, 1, 1),
(372, 2, 1),
(373, 1, 2),
(373, 3, 2),
(374, 1, 3),
(374, 2, 1),
(374, 3, 0),
(375, 1, 4),
(376, 1, 15),
(376, 2, 0),
(376, 3, 1),
(377, 1, 0),
(377, 2, 0),
(377, 3, 21);

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
(1, 'Pesos Mexicanos'),
(2, 'Dólares');

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
(7, 'Litros');

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
  `usuario_actualizado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_creado`, `usuario_actualizado`) VALUES
(1, 'Administrador', '$2y$10$uJv3jCCQKn20CMWiYjw6sOh81jCmUoEN8YJMLASs30kbTa6g6/Fuq', 'Administrador_95.jpg', '2023-11-06 21:45:33', '2023-11-10 22:33:51'),
(11, 'admin1111', '$2y$10$hXlCprGNBDDBzrRzxRYvOu5OAt7bNce1O/LS2SRTUjiNgfSAn4LCS', 'admin1111_87.png', '2023-11-21 05:48:31', '2023-12-03 00:34:31'),
(14, 'usuario', '$2y$10$eOVgAY6MlZFBmzmedLaSN.iKHIxAt2y3yzwKNii9wkmYlM/9/vmqq', 'usuario_45.jpg', '2023-12-03 01:13:04', '2023-12-03 01:13:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id_almacen`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_almacen_origen` (`id_almacen_origen`),
  ADD KEY `id_almacen_destino` (`id_almacen_destino`);

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
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tipos_moneda`
--
ALTER TABLE `tipos_moneda`
  MODIFY `id_moneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_almacen_origen`) REFERENCES `almacenes` (`id_almacen`),
  ADD CONSTRAINT `movimientos_ibfk_3` FOREIGN KEY (`id_almacen_destino`) REFERENCES `almacenes` (`id_almacen`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`),
  ADD CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`id_moneda`) REFERENCES `tipos_moneda` (`id_moneda`);

--
-- Filtros para la tabla `stock_almacen`
--
ALTER TABLE `stock_almacen`
  ADD CONSTRAINT `stock_almacen_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `stock_almacen_ibfk_2` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
