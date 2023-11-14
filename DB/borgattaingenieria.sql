-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2023 a las 06:10:23
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
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id_cotizacion` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_cotizacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_factura`
--

CREATE TABLE `detalles_factura` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden`
--

CREATE TABLE `detalle_orden` (
  `id_detalle` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_factura`
--

CREATE TABLE `estatus_factura` (
  `id_estatus` int(11) NOT NULL,
  `nombre_estatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatus_factura`
--

INSERT INTO `estatus_factura` (`id_estatus`, `nombre_estatus`) VALUES
(1, 'Pendiente'),
(2, 'Pagada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_orden`
--

CREATE TABLE `estatus_orden` (
  `id_estatus` int(11) NOT NULL,
  `nombre_estatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatus_orden`
--

INSERT INTO `estatus_orden` (`id_estatus`, `nombre_estatus`) VALUES
(1, 'En proceso'),
(2, 'Completada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `estatus_factura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `ordenes_compra`
--

CREATE TABLE `ordenes_compra` (
  `id_orden` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_orden` date NOT NULL,
  `estatus_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_moneda` int(11) NOT NULL,
  `url_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, `descripcion`, `precio`, `stock`, `id_categoria`, `id_proveedor`, `id_unidad`, `id_moneda`, `url_imagen`) VALUES
(1, 'H-0001', 'Avellanador 1/4\"', '1/4\"', 150.00, 6, 1, 2, 1, 1, 'img/avellanador1_4.jpg'),
(2, 'H-0001', 'Avellanador 1/4\"', '1/4\"', 150.00, 6, 1, 2, 1, 1, 'img/avellanador1_4.jpg'),
(44, 'H-0002', 'Avellanador', '1/2\" 3FLT 82', 1.00, 1, 1, 2, 1, 1, 'img/652459c468854_IMG_20231009_134859_398[1].jpg'),
(45, 'H-0003', 'Boquilla', 'ER-32', 1.00, 2, 1, 2, 1, 1, 'img/65245e5e4adc8_IMG_20231009_135742_685[1].jpg'),
(47, 'H-0004', 'Cortador 211-270', '3/4 4FL SQ EM', 1.00, 1, 1, 2, 1, 1, 'img/65245f668b348_IMG_20231009_140439_159.jpg'),
(48, 'H-0005', 'Cortador Carbice AADF \"KENNAMETAL\"', '3/8 x 3/8 x 1 x 3', 1.00, 2, 1, 2, 1, 1, 'img/65245fd9ed077_IMG_20231009_135542_237.jpg'),
(49, 'H-0006', 'Cortador SA-1FM', '1/4 CYL', 1.00, 2, 1, 2, 1, 1, 'img/CORTADOR.jpg'),
(50, 'H-0007', 'Cuchilla', 'E100 P7ACERO Y ALUMINIO', 1.00, 10, 1, 2, 1, 1, 'img/652460811aecd_IMG_20231009_140404_883.jpg'),
(51, 'H-0008', 'Fresa de carburo de tungsteno clave 125', '12,7 x 22,2 x 6,4 mm(1/2x7/8x1/4\")', 1.00, 2, 1, 2, 1, 1, 'img/FRESA.jpg'),
(53, 'H-0009', 'Fresa de carburo de tungsteno', 'SH-5', 1.00, 2, 1, 2, 1, 1, 'img/652461bd30ddf_IMG_20231009_140548_946.jpg'),
(54, 'H-0010', 'Punta cortador para dremel', 'SC-42 Double cut burr', 1.00, 4, 1, 2, 1, 1, 'img/6524621ebb627_IMG_20231009_140321_551.jpg'),
(55, 'H-0011', 'Tarraja', '1\" M6X1', 1.00, 1, 1, 2, 1, 1, 'img/65246c8bd5430_IMG_20231009_140019_434.jpg'),
(56, 'H-0012', 'Tarraja', '1\" M5X.8', 1.00, 1, 1, 2, 1, 1, 'img/65246df03f3d9_IMG_20231009_140039_500.jpg'),
(57, 'H-0013', 'Tarraja', '1\" M4X7', 1.00, 1, 1, 2, 1, 1, 'img/65246e42c629b_IMG_20231009_140058_020.jpg'),
(58, 'H-0014', 'Tarraja', '1\" M3X.5', 1.00, 1, 1, 2, 1, 1, 'img/65246e9854526_IMG_20231009_140118_450.jpg'),
(59, 'H-0015', 'Machuelo Hy-Pro Helicoidal', '\"5303F 1/8 - 40 2B 3FL SEMICONICO', 0.00, 0, 0, 0, 0, 0, ''),
(60, 'H-0016', 'Machuelo OSG ROYCO', '5303F 1/8 - 40 2B 3FL SEMICONICO', 1.00, 4, 1, 2, 1, 1, 'img/652475de427e8_IMG_20231009_153018_560.jpg'),
(61, 'H-0017', 'Machuelo OSG ROYCO', '5303F 3/16-24 2B 4FL SEMICONICO', 1.00, 4, 1, 2, 1, 1, 'img/65247686b6266_IMG_20231009_152858_760.jpg'),
(63, 'H-0018', 'Machuelo OSG ROYCO', '142 M3X0.5 D3 2S/P PLUG', 1.00, 11, 1, 2, 1, 1, 'img/6524776535649_IMG_20231009_152807_827.jpg'),
(64, 'H-0019', 'Machuelo OSG ROYCO', '5305N 10-24 2B 4FL SEMICONICO', 1.00, 9, 1, 2, 1, 1, 'img/652478ecd5372_IMG_20231009_152338_555.jpg'),
(65, 'H-0020', 'Machuelo OSG ROYCO', '5301N 10-24 2B 2S/P SEMICONICO', 1.00, 2, 1, 2, 1, 1, 'img/65247a0aa1a16_IMG_20231009_152338_555.jpg'),
(67, 'H-0021', 'Machuelo OSG ROYCO', '5303F 1/4-20 2B 4FL SEMICONICO', 1.00, 2, 1, 2, 1, 1, 'img/65247a86be014_IMG_20231009_152858_760.jpg'),
(70, 'H-0022', 'Machuelo OSG ROYCO', '5303F 3/8-16 2B 4FL SEMICONICO', 1.00, 2, 1, 2, 1, 1, 'img/65247b763dce8_IMG_20231009_152442_711.jpg'),
(71, 'H-0023', 'Machuelo OSG ROYCO', 'M5X0.8 6H', 1.00, 3, 1, 2, 1, 1, 'img/65247bc62733f_IMG_20231009_152701_683.jpg'),
(72, 'H-0024', 'Machuelo OSG ROYCO', 'M6 X1 6H', 1.00, 3, 1, 2, 1, 1, 'img/65247c3f9dfa5_IMG_20231009_152645_816.jpg'),
(74, 'H-0025', 'Machuelo OSG ROYCO', 'M4 X 0.7 6H', 1.00, 5, 1, 2, 1, 1, 'img/65247cc3dc7f0_IMG_20231009_152544_434.jpg'),
(75, 'H-0026', 'Cortador', 'R1.5X6X4X50L', 1.00, 0, 1, 2, 1, 1, 'img/65247f7a95089_IMG-20231009-WA0001.jpg'),
(76, 'H-0027', 'Cortador', 'R1.0X4X4X50L', 1.00, 0, 1, 2, 1, 1, 'img/65247f8f4de19_IMG-20231009-WA0001.jpg'),
(77, 'H-0028', 'Cortador', 'R0.75X3X4X50L', 1.00, 0, 1, 2, 1, 1, 'img/65247fa445d75_IMG-20231009-WA0001.jpg'),
(80, 'H-0029', 'Cortador', 'R2.0X8X4X50L', 1.00, 0, 1, 2, 1, 1, 'img/65247fda7de63_IMG-20231009-WA0001.jpg'),
(81, 'H-0030', 'Cortador', 'R0.5X2X4X50L', 1.00, 0, 1, 2, 1, 1, 'img/6524800c28db9_IMG-20231009-WA0001.jpg'),
(82, 'H-0031', 'Inserto', 'DFT05T308HP / KC7140 / 1804829', 1.00, 20, 1, 2, 1, 1, 'img/652480ee9141e_IMG_20231009_161518_511.jpg'),
(83, 'H-0032', 'Inserto', 'KC410M / 2984054', 1.00, 15, 1, 2, 1, 1, 'img/652481525eae6_IMG_20231009_161612_513.jpg'),
(84, 'H-0033', 'Inserto', 'NT2R / KCU10 / 4175911', 1.00, 9, 1, 2, 1, 1, 'img/652481907eff1_IMG_20231009_161713_523.jpg'),
(86, 'H-0034', 'Inserto', 'NT3RK / KC5025 / 1795787', 1.00, 10, 1, 2, 1, 1, 'img/652481dc39e07_IMG_20231009_161307_339.jpg'),
(87, 'H-0035', 'Inserto', 'NG2031RK / KC5025', 1.00, 5, 1, 2, 1, 1, 'img/6524831fba5b4_IMG_20231009_164537_426.jpg'),
(88, 'H-0036', 'Inserto', 'CNMG090308MP / CNMG322MP / KC5010', 1.00, 5, 1, 2, 1, 1, 'img/6524835def208_IMG_20231009_161822_013.jpg'),
(89, 'H-0037', 'Inserto', 'A4G0205M02U02GMN / KC5025', 1.00, 10, 1, 2, 1, 1, 'img/652483a716952_IMG_20231009_161742_020.jpg'),
(91, 'H-0038', 'Inserto', 'NT3R / KC5010', 1.00, 4, 1, 2, 1, 1, 'img/652484445d5e1_IMG_20231009_165123_369.jpg'),
(92, 'H-0039', 'Broca para metal', '10.00 MM', 1.00, 7, 1, 2, 1, 1, 'img/6525779ebfad1_IMG_20231010_100001_599.jpg'),
(93, 'H-0040', 'Broca para metal', '17/64\"', 1.00, 2, 1, 2, 1, 1, 'img/6525785db67f9_IMG_20231010_100116_298.jpg'),
(94, 'H-0041', 'Broca para metal', '1/4\"', 1.00, 2, 1, 2, 1, 1, 'img/652578cf4aa14_IMG_20231010_100201_147.jpg'),
(95, 'H-0042', 'Broca para metal', '6.35 MM', 1.00, 2, 1, 2, 1, 1, 'img/6525791b1534f_IMG_20231010_100354_485.jpg'),
(96, 'H-0043', 'Broca para metal', '1/2\"', 1.00, 2, 1, 2, 1, 1, 'img/652579aa0c56d_IMG_20231010_100433_527.jpg'),
(97, 'H-0044', 'Broca para metal', '3/8\" HSS', 1.00, 2, 1, 2, 1, 1, 'img/652579edc8504_IMG_20231010_100541_401.jpg'),
(98, 'H-0045', 'Broca para concreto', '3/8\" (10)', 1.00, 1, 1, 2, 1, 1, 'img/65257a28469e7_IMG_20231010_100557_681.jpg'),
(99, 'H-0046', 'Broca para metal', '9/16\"', 1.00, 1, 1, 2, 1, 1, 'img/65257bf5b93cc_IMG_20231010_102027_731.jpg'),
(100, 'H-0047', 'Broca para metal', '31/64\"', 1.00, 1, 1, 2, 1, 1, 'img/65257c3e19dfe_IMG_20231010_102050_437.jpg'),
(101, 'H-0048', 'Broca para metal', '7/16\"', 1.00, 4, 1, 2, 1, 1, 'img/65257cbf1b672_IMG_20231010_102116_322.jpg'),
(102, 'H-0049', 'Broca para metal CLEVELAND', '1/8\"', 1.00, 15, 1, 2, 1, 1, 'img/65257d245682b_IMG_20231010_102147_476.jpg'),
(103, 'H-0050', 'Broca para metal', '2.50 MM 0.0984\"', 1.00, 5, 1, 2, 1, 1, 'img/65257d6c28af3_IMG_20231010_102225_747.jpg'),
(104, 'H-0051', 'Broca para metal', '15/64\"', 1.00, 4, 1, 2, 1, 1, 'img/65257db2b948b_IMG_20231010_102246_630.jpg'),
(105, 'H-0052', 'Broca para metal', '7/64\" 0.1094\"', 1.00, 14, 1, 2, 1, 1, 'img/65257e53c347f_IMG_20231010_102607_366.jpg'),
(106, 'H-0053', 'Broca para metal', '3/32\"', 1.00, 4, 1, 2, 1, 1, 'img/65257e9c98e90_IMG_20231010_102330_517.jpg'),
(107, 'H-0054', 'Broca para metal', '3/16\"', 1.00, 4, 1, 2, 1, 1, 'img/65257ed86fba6_IMG_20231010_102408_714.jpg'),
(109, 'H-0055', 'Broca para metal', '4.00 MM', 1.00, 5, 1, 2, 1, 1, 'img/65257f7bdf85b_IMG_20231010_102424_168.jpg'),
(110, 'H-0056', 'Broca para metal', '11/64\" 0.1719\"', 1.00, 9, 1, 2, 1, 1, 'img/65257fbd8eebc_IMG_20231010_102534_809.jpg'),
(111, 'H-0057', 'Broca para metal', '9/64\" 0.01406\"', 1.00, 10, 1, 2, 1, 1, 'img/65258003de85c_IMG_20231010_102552_755.jpg'),
(112, 'H-0058', 'Broca para metal', '1/8\"', 1.00, 8, 1, 2, 1, 1, 'img/65258044d9a12_IMG_20231010_102623_674.jpg'),
(114, 'H-0059', 'Broca para metal', '5/32\" 0.1562\"', 1.00, 7, 1, 2, 1, 1, 'img/652580db7f955_IMG_20231010_102641_410.jpg'),
(115, 'H-0060', 'Broca para metal', '5/64\" 0.0781\"', 1.00, 13, 1, 2, 1, 1, 'img/652581b01de30_IMG_20231010_102650_179.jpg'),
(116, 'H-0061', 'Broca para metal', '27  0.1440\"  ', 1.00, 4, 1, 2, 1, 1, 'img/652581ffc15c7_IMG_20231010_102659_658.jpg'),
(117, 'H-0062', 'Broca para concreto', '5/8\"', 1.00, 1, 1, 2, 1, 1, 'img/65258353be987_IMG_20231010_105534_251.jpg'),
(118, 'H-0063', 'Broca para metal', '5/16\"', 1.00, 5, 1, 2, 1, 1, 'img/652583a12c1bc_IMG_20231010_105604_565.jpg'),
(119, 'H-0064', 'Broca para metal', '13/64', 1.00, 11, 1, 2, 1, 1, 'img/652583e7491b3_IMG_20231010_105626_665.jpg'),
(120, 'H-0065', 'Broca para metal', '7/8\"', 1.00, 1, 1, 2, 1, 1, 'img/6525842fa53a5_IMG_20231010_105659_302.jpg'),
(121, 'H-0066', 'Broca para metal', '3/4\"', 1.00, 1, 1, 2, 1, 1, 'img/652584603c277_IMG_20231010_105722_077.jpg'),
(122, 'H-0067', 'Broca para metal', '12.50 MM', 1.00, 5, 1, 2, 1, 1, 'img/652584a152913_IMG_20231010_105753_757.jpg'),
(123, 'H-0068', 'Pernos para torno', '5/16\"', 1.00, 14, 1, 2, 1, 1, 'img/6525889da04c5_IMG_20231010_111900_825.jpg'),
(124, 'H-0069', 'Rima CLEVELAND', '3/8\"', 1.00, 2, 1, 2, 1, 1, 'img/65258909e297e_IMG_20231010_111931_604.jpg'),
(125, 'H-0070', 'Rima Fenes', '3/8\"', 1.00, 1, 1, 2, 1, 1, 'img/65258952c5e06_IMG_20231010_112035_863.jpg'),
(126, 'H-0071', 'Rima Fenes', '1/2\"', 1.00, 1, 1, 2, 1, 1, 'img/65258999e1c99_IMG_20231010_112058_508.jpg'),
(127, 'H-0072', 'Pistola de silicón', 'Grande', 1.00, 1, 1, 2, 1, 1, 'img/65258d9f1b792_IMG_20231010_113034_246.jpg'),
(128, 'I-0001', 'Barras de silicón', '1/2\"', 1.00, 34, 2, 2, 1, 1, 'img/65258df2a32fc_IMG_20231010_113138_143.jpg'),
(129, 'I-0002', 'Lentes  de seguridad FOY', 'Ambar', 1.00, 16, 2, 2, 1, 1, 'img/65258e42dfb13_IMG_20231010_113233_881.jpg'),
(130, 'I-0003', 'Lentes de seguridad PRETUL', 'Transparentes', 1.00, 2, 2, 2, 1, 1, 'img/65258e9d97d1d_IMG_20231010_113315_252.jpg'),
(131, 'I-0004', 'Lentes de seguridad FOY', 'Transparentes', 1.00, 1, 2, 2, 1, 1, 'img/65258faddecd5_IMG_20231010_113429_054.jpg'),
(132, 'I-0005', 'Plasti acero', '25 ml', 1.00, 1, 2, 2, 1, 1, 'img/6525913f69a16_IMG_20231010_113453_281.jpg'),
(133, 'I-0006', 'Cinta sella roscas', '1/2\" X 7 m', 1.00, 10, 2, 2, 1, 1, 'img/6525920b640f5_IMG_20231010_113514_174.jpg'),
(134, 'I-0007', 'Disco de lija', 'Grano 120 fino 5\"', 1.00, 13, 2, 2, 1, 1, 'img/6525933e1bb8b_IMG_20231010_113546_500.jpg'),
(136, 'I-0008', 'Disco de lija', 'Grano 80 medio 5\"', 1.00, 11, 2, 2, 1, 1, 'img/652593d8eea6c_IMG_20231010_113617_638.jpg'),
(137, 'I-0009', 'Cinta de montaje doble cara', '19 mm X 5 m', 1.00, 4, 2, 2, 1, 1, 'img/6525944472efc_IMG_20231010_113631_678.jpg'),
(138, 'I-0010', 'Cinta masking', '18 mm X 50 m', 1.00, 1, 2, 2, 1, 1, 'img/6525948a58bdf_IMG_20231010_113650_761.jpg'),
(139, 'I-0011', 'Pistola de silicón', 'Chica', 1.00, 1, 2, 2, 1, 1, 'img/652594c2942b8_IMG_20231010_113711_071.jpg'),
(140, 'I-0012', 'Tapones auditivos con triple barrera', '25 db', 1.00, 9, 2, 2, 1, 1, 'img/6525951016b48_IMG_20231010_113734_333.jpg'),
(141, 'I-0013', 'Guantes de nitrilo', 'Grandes', 1.00, 3, 2, 2, 1, 1, 'img/652595508a04e_IMG_20231010_113750_383.jpg'),
(143, 'I-0014', 'Guantes de carnaza', 'Unitalla (trabajo ligero)', 1.00, 2, 2, 2, 1, 1, 'img/652595ca65d46_IMG_20231010_113804_572.jpg'),
(144, 'I-0015', 'Portalámpara para tubo flourescente', 'FA8', 1.00, 2, 2, 2, 1, 1, 'img/65259615af253_IMG_20231010_113819_730.jpg'),
(145, 'I-0016', 'Manguera para aire tipo resorte', '7.6 m', 1.00, 2, 2, 2, 1, 1, 'img/652596833170a_IMG_20231010_115933_963.jpg'),
(146, 'I-0017', 'Fumigador doméstico', '1 LT.', 1.00, 1, 2, 2, 1, 1, 'img/652596c7cc55c_IMG_20231010_120000_943.jpg'),
(147, 'H-0073', 'Martillo de hojalatero', '11 OZ.', 1.00, 1, 1, 2, 1, 1, 'img/65259736a23ab_IMG_20231010_120022_666.jpg'),
(148, 'H-0074', 'Mango para martillo', 'Mango', 1.00, 2, 1, 2, 1, 1, 'img/6525980f04ad2_IMG_20231010_120039_303.jpg'),
(149, 'H-0075', 'Maceta de goma', '606', 1.00, 1, 1, 2, 1, 1, 'img/65259960a900f_IMG_20231010_120105_237.jpg'),
(150, 'H-0076', 'Maceta de goma', '808', 1.00, 1, 1, 2, 1, 1, 'img/65259995d501c_IMG_20231010_120116_822.jpg'),
(151, 'H-0077', 'Extensión eléctrica de uso rudo', '16 AWG X 6 MTS', 1.00, 6, 1, 2, 1, 1, 'img/65259a2423a75_IMG_20231010_120145_934.jpg'),
(152, 'H-0078', 'Cautín Weller', '221-NM-146', 1.00, 1, 1, 2, 1, 1, 'img/65259c45890f4_IMG_20231010_120456_039.jpg'),
(153, 'H-0079', 'Puntas para multimetro', 'Fluke', 1.00, 1, 1, 2, 1, 1, 'img/65259ddad49cb_IMG_20231010_120509_094.jpg'),
(154, 'H-0080', 'Punta para cautín', 'CT5A7MX', 1.00, 6, 1, 2, 1, 1, 'img/65259ee66b32b_IMG_20231010_120636_659.jpg'),
(155, 'H-0081', 'Punta para cautín', 'PTA7MX', 1.00, 1, 1, 2, 1, 1, 'img/65259f71740bd_IMG_20231010_120624_780.jpg'),
(156, 'H-0082', 'Resistencia', 'HEW60PMX', 1.00, 3, 1, 2, 1, 1, 'img/65259fcaca494_IMG_20231010_120721_513.jpg'),
(158, 'I-0018', 'Disco', '40 grano, 115mm, 22mm', 1.00, 2, 2, 2, 1, 1, 'img/6525a7a179664_IMG_20231010_120346_523.jpg'),
(162, 'I-0019', 'Esponja para cautín', 'Esponja', 1.00, 4, 2, 2, 1, 1, 'img/6525af2672d9e_IMG_20231010_120529_238.jpg'),
(163, 'I-0020', 'Rollo de lija N. 100', '1 1/2\" X 148 Ft.', 1.00, 1, 2, 2, 1, 1, 'img/6525b0191cc09_IMG_20231010_122251_179.jpg'),
(164, 'I-0021', 'Rollo de lija grano 120', '38 mm X 45 m', 1.00, 1, 2, 2, 1, 1, 'img/6525b06eba83a_IMG_20231010_122323_456.jpg'),
(165, 'I-0022', 'Mini cepillo de alambre', 'Surtido', 1.00, 10, 2, 2, 1, 1, 'img/6525b0fa58367_IMG_20231010_122411_264.jpg'),
(166, 'H-0083', 'Navaja retráctil', '18 mm', 1.00, 2, 1, 2, 1, 1, 'img/6525b1918b595_IMG_20231010_122514_553.jpg'),
(167, 'H-0084', 'Navaja retráctil', 'Pequeña', 1.00, 1, 1, 2, 1, 1, 'img/6525b2121263e_IMG_20231010_122537_660.jpg'),
(168, 'I-0023', 'Repuesto para navajas', 'Repuesto', 1.00, 8, 2, 2, 1, 1, 'img/6525b2c625380_IMG_20231010_122544_491.jpg'),
(170, 'H-0085', 'Cuchilla para linóleo', '7\"', 1.00, 1, 1, 2, 1, 1, 'img/6525b34f832e0_IMG_20231010_122619_684.jpg'),
(171, 'I-0024', 'Pila alcalina', 'A76/LR44', 1.00, 2, 2, 2, 1, 1, 'img/6525b3ea55aef_IMG_20231010_135502_790.jpg'),
(175, 'H-0086', 'Lima redonda bastarda', '10\"', 1.00, 1, 1, 2, 1, 1, 'img/6525b8f888bd8_IMG_20231010_140631_205.jpg'),
(178, 'H-0087', 'Maneral tipo garrote', '5/32\" a 3/4\"', 1.00, 1, 1, 2, 1, 1, 'img/6525bbfaa970d_IMG_20231010_140616_249.jpg'),
(179, 'H-0088', 'Lima bastarda de media caña escofina', '4\"', 1.00, 1, 1, 2, 1, 1, 'img/6525bf2c397c0_IMG_20231010_140059_679.jpg'),
(180, 'H-0089', 'Lima triangular de uso regular', '5\"', 1.00, 1, 1, 1, 1, 1, 'img/6525bfc39a576_IMG_20231010_140110_037.jpg'),
(181, 'H-0090', 'Lima plana', '5\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c0e41ba0b_IMG_20231010_140231_563.jpg'),
(182, 'H-0091', 'Bomba desoldadora', 'Extractor', 1.00, 1, 1, 2, 1, 1, 'img/6525c13eddb97_IMG_20231010_140308_697.jpg'),
(183, 'H-0092', 'Maneral ajustable', '1/16\" X 1/4\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c1d3111fa_IMG_20231010_140321_313.jpg'),
(184, 'H-0093', 'Lima bastarda de media caña', '5\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c259c5ab7_IMG_20231010_140403_929.jpg'),
(185, 'H-0094', 'Broca para concreto', '1/4\" X 12', 1.00, 1, 1, 2, 1, 1, 'img/6525c2e3e549b_IMG_20231010_140424_912.jpg'),
(186, 'H-0095', 'Segueta', 'Diente fino', 1.00, 1, 1, 2, 1, 1, 'img/6525c36f1b8b4_IMG_20231010_140447_425.jpg'),
(187, 'H-0096', 'Broca para concreto', 'Longitud 12\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c3eab5029_IMG_20231010_140603_518.jpg'),
(188, 'H-0097', 'Maneral tipo garrote', '5/32\" X 3/4\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c46a46249_IMG_20231010_140616_249.jpg'),
(189, 'H-0098', 'Tijera', '8\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c520ab147_IMG_20231010_152301_159.jpg'),
(190, 'I-0025', 'Rueda flap con vástago grano 80', 'Ø 2\"', 1.00, 1, 1, 2, 1, 1, 'img/6525c5fd16336_IMG_20231010_152326_826.jpg'),
(191, 'I-0026', 'Rueda flap con vástago grano 120', 'Ø 2\"', 1.00, 1, 2, 2, 1, 1, 'img/6525c65f73832_IMG_20231010_152326_826.jpg'),
(192, 'I-0027', 'Cuchillas de repuesto para cortador de tubo', '18 mm', 1.00, 1, 2, 2, 1, 1, 'img/6525c82ab8050_IMG_20231010_152338_762.jpg'),
(193, 'H-0099', 'Destornillador de caja', '3/8\" X 3\"', 1.00, 2, 1, 2, 1, 1, 'img/6525c945b5da9_IMG_20231010_152358_564.jpg'),
(194, 'H-0100', 'Desarmador Comfort Grip', '75 mm x 3\"', 1.00, 3, 1, 2, 1, 1, 'img/6525ca43c0e7c_IMG_20231010_152435_828.jpg'),
(195, 'H-0101', 'Desarmador Screwdriver', '7\"', 1.00, 1, 1, 2, 1, 1, 'img/6525cbc6b03b5_IMG_20231010_152502_653.jpg'),
(196, 'H-0102', 'Desarmador Phillips', 'PH0 x 4\"', 1.00, 2, 1, 2, 1, 1, 'img/6525cc468391d_IMG_20231010_152543_607.jpg'),
(197, 'H-0103', 'Desarmador de cruz', '1/4\" x 4', 1.00, 1, 1, 2, 1, 1, 'img/6525ccd6a8bec_IMG_20231010_152631_435.jpg'),
(198, 'H-0104', 'Dado corto', '9/16\"', 1.00, 1, 1, 2, 1, 1, 'img/6525cd5485220_IMG_20231010_152650_260.jpg'),
(199, 'H-0105', 'Desarmador', 'Plano', 1.00, 1, 1, 2, 1, 1, 'img/6525cda71bafc_IMG_20231010_152722_888.jpg'),
(200, 'H-0106', 'Punzón para barrenar', '3/8\"', 1.00, 2, 1, 2, 1, 1, 'img/6525cf9cb1b93_IMG_20231010_152809_144.jpg'),
(201, 'H-0107', 'Punzón', '5/16\" X 1/8\"', 1.00, 3, 1, 2, 1, 1, 'img/6525cfd0b2658_IMG_20231010_152923_737.jpg'),
(202, 'H-0108', 'Destornillador de caja', '7 mm', 1.00, 1, 1, 2, 1, 1, 'img/6525d0405cc72_IMG_20231010_152942_826.jpg'),
(203, 'H-0109', 'llave ajustable', '6\" marca: FOY', 1.00, 1, 1, 2, 1, 1, 'img/652874bb6fa72_IMG_20231010_154434_712.jpg'),
(204, 'H-0110', 'Llave de presión', '10\"', 1.00, 1, 1, 2, 1, 1, 'img/6528751b2fbb0_IMG_20231010_154521_868.jpg'),
(205, 'H-0111', 'pinzas para anillos de retención.', 'desde 65mm hasta 12mm', 1.00, 1, 1, 2, 1, 1, 'img/6528758810807_IMG_20231010_154539_966.jpg'),
(206, 'H-0112', 'Pinzas de presión', 'Tipo prensa', 1.00, 1, 1, 2, 1, 1, 'img/65287606afac3_IMG_20231010_154605_145.jpg'),
(208, 'H-0113', 'pinzas de punta', 'medianas', 1.00, 1, 1, 2, 1, 1, 'img/652876a891028_IMG_20231010_154616_619.jpg'),
(209, 'H-0114', 'Pinzas para anillo de retención', 'de 90grados', 1.00, 1, 1, 2, 1, 1, 'img/652876fc979d2_IMG_20231010_154629_828.jpg'),
(210, 'H-0115', 'Matraca', '3/8\"', 1.00, 1, 1, 2, 1, 1, 'img/6528775b9ea45_IMG_20231010_154639_333.jpg'),
(211, 'H-0116', 'juego de llaves Allen tipo navaja', 'estándar', 1.00, 1, 1, 2, 1, 1, 'img/6528781895bd7_IMG_20231010_154720_527.jpg'),
(212, 'H-0117', 'llave combinada.', '3/8\" X 16cm', 1.00, 2, 1, 2, 1, 1, 'img/6529acbf18aa1_IMG_20231010_154821_267.jpg'),
(213, 'H-0118', 'Llave combinada', '9/16\"', 1.00, 1, 1, 2, 1, 1, 'img/6529b93ac3c8c_IMG_20231010_155051_770.jpg'),
(214, 'H-0119', 'Dado Corto 9/16\"', '9/16\" marca SURTEK', 30.00, 1, 1, 2, 1, 1, 'img/6532f3afa9ab7_IMG_20231020_153551_656_hdr.jpg'),
(216, 'I-0028', 'Brocha 1\"', '1\" Marca Comex', 1.00, 1, 2, 2, 1, 1, 'img/6532f541a667b_IMG_20231020_153607_481_hdr.jpg'),
(218, 'H-0120', 'Llave Mixta 1/2\"', '1/2\" Marca Urrea', 1.00, 2, 1, 2, 1, 1, 'img/6536ea0dc3f5e_IMG_20231010_155121_905.jpg'),
(219, 'H-0121', 'Llave Mixta 3/8\"', '3/8\" Marca Urrea', 1.00, 2, 1, 2, 1, 1, 'img/6536ea8d57ef4_IMG_20231010_155144_754.jpg'),
(220, 'H-0122', 'Llave Allen 3/16\"', 'Llave Allen 3/16\"', 1.00, 3, 1, 2, 1, 1, 'img/6536eba15e073_IMG_20231010_155208_965.jpg'),
(221, 'H-0123', 'Llave Allen 3.0mm', 'Llave Allen 3.0mm', 1.00, 6, 1, 2, 1, 1, 'img/6536ec2182e0e_IMG_20231010_155230_884.jpg'),
(222, 'H-0124', 'Llave Allen 5/32\"', 'Llave Allen 5/32\"', 1.00, 1, 1, 2, 1, 1, 'img/6536ec7417827_IMG_20231010_155305_259.jpg'),
(223, 'H-0125', 'Llave Allen 5/64\"', 'Llave Allen 5/64\"', 1.00, 13, 1, 2, 1, 1, 'img/6536ecbd71cce_IMG_20231010_155322_039.jpg'),
(224, 'H-0126', 'Llave Allen 1/8\"', 'Llave Allen 1/8\"', 1.00, 9, 1, 2, 1, 1, 'img/6536ed14c3b40_IMG_20231010_155448_355.jpg'),
(225, 'H-0127', 'Llave Allen tipo T 3/32\"', 'Llave Allen tipo T 3/32\"', 1.00, 4, 1, 2, 1, 1, 'img/6536ed6bb7880_IMG_20231010_155505_574.jpg'),
(226, 'H-0128', 'Llave Allen Tipo T 1/8\"', 'Llave Allen Tipo T 1/8\" ', 1.00, 4, 1, 2, 1, 1, 'img/6536eea290400_IMG_20231010_155516_199.jpg'),
(227, 'H-0129', 'Maneral ajustable tipo T 1/2\"', 'Maneral ajustable tipo T 1/2\" marca truper', 1.00, 2, 1, 2, 1, 1, 'img/6536efa239bbb_IMG_20231010_155708_862.jpg'),
(228, 'H-0130', 'Maneral Tipo T ajustable 3/16\"', 'Maneral Tipo T ajustable 3/16\" marca Surtek', 1.00, 2, 1, 2, 1, 1, 'img/6536effe5e1b3_IMG_20231010_155730_317.jpg'),
(229, 'H-0131', 'Manera Tipo T ajustable 1/4\"', 'Manera Tipo T ajustable 1/4\" marca truper', 1.00, 1, 1, 2, 1, 1, 'img/6536f05aef38d_IMG_20231010_155813_643.jpg'),
(230, 'H-0132', 'Broquero 1/2\"', 'Broquero 1/2\" marca truper', 1.00, 1, 1, 2, 1, 1, 'img/6536f0b0bc6f6_IMG_20231010_155800_670.jpg'),
(232, 'I-0029', 'Cople Rápido Macho', 'Cople Rápido Macho', 1.00, 4, 2, 2, 1, 1, 'img/6536f2171b4fa_IMG_20231010_155836_005.jpg'),
(233, 'I-0030', 'Cople rápido hembra', 'Cople rápido hembra surtek', 1.00, 2, 2, 2, 1, 1, 'img/6536f287a1b0f_IMG_20231010_155848_071.jpg'),
(234, 'I-0031', 'Cople rápido hembra', 'Cople rápido hembra marca truper', 1.00, 1, 2, 2, 1, 1, 'img/6536f2bec2c4d_IMG_20231010_155903_289.jpg'),
(235, 'H-0133', 'Flexometro 5m x 16\"', 'Flexometro 5m x 16\" truper', 1.00, 2, 1, 2, 1, 1, 'img/6536f34d60237_IMG_20231010_155922_495.jpg'),
(236, 'I-0032', 'Pila 2016 de 3V', 'Pila 2016 de 3V marca steren', 1.00, 11, 2, 2, 1, 1, 'img/6536f46a4b3ac_IMG_20231010_160102_979.jpg'),
(238, 'I-0033', 'Pila AA 1.5V', 'Pila AA 1.5V marca RadioShack', 1.00, 6, 1, 2, 1, 1, 'img/6536f64d64536_IMG_20231010_160316_111.jpg'),
(239, 'I-0034', 'Pila AAA', 'Pila AAA marca duracel', 1.00, 6, 2, 2, 1, 1, 'img/6536f6af551d7_IMG_20231010_160547_272.jpg'),
(240, 'I-0035', 'Pila 9V', 'Pila 9V marca Duracell', 1.00, 1, 2, 2, 1, 1, 'img/6536f736d0c06_IMG_20231010_160446_493.jpg'),
(241, 'I-0036', 'Gas butano', 'Gas butano Pretul', 1.00, 2, 2, 2, 1, 1, 'img/6536f76a9dc4b_IMG_20231010_160737_064.jpg'),
(242, 'I-0037', 'WD40', 'WD40', 1.00, 1, 2, 2, 1, 1, 'img/6536f79498c77_IMG_20231010_160757_880.jpg'),
(243, 'MPM-001', 'Barra redonda INOX 1/8\" X 1.20cm', 'Barra redonda INOX 1/8\" X 1.20cm', 80.00, 5, 7, 1, 1, 1, 'img/6536f804ad445_IMG-20231016-WA0001.jpg'),
(245, 'MARC001-5B S/P', 'Tornillo mesa incisal', 'Tornillo mesa incisal sin pintar', 20.00, 3, 4, 3, 1, 1, 'img/653ad8eb74bfc_IMG_20231010_16081.jpg'),
(246, 'I-0038', 'Bolsas para basura.', 'Bolsas para basura, para desperdicio de maquinado.', 50.00, 10, 2, 4, 1, 1, 'img/653ad8eb74bfc_IMG_20231010_160813_434.jpg'),
(247, 'MARC001-5Ñ S/P', 'Cóndilo', 'Cóndilo sin pulir.', 20.00, 16, 4, 3, 1, 1, 'img/653ada08abb5c_condilo.jpg'),
(248, 'MARC001-4J S/P', 'Tornillo para elastómero', 'Tornillo para elastómero sin pulir.', 20.00, 4, 4, 3, 1, 1, 'img/653ade70bc6c0_dhjasdkjadljAFKADADKADLKahjkdahdkahd12651.jpg'),
(253, 'H-0134', 'Boquilla ER25 1/2\"', 'ER25 1/2\"', 532.50, 2, 1, 2, 1, 1, 'img/20231027_162509.jpg'),
(254, 'H-0135', 'Cortador 5/8\" HSS', '5/8\" HSS', 1032.40, 0, 1, 2, 1, 1, 'img/20231027_162528.jpg'),
(255, 'H-0136', 'Broca 28', 'Broca 28', 50.75, 3, 1, 2, 1, 1, 'img/20231027_162546.jpg'),
(256, 'H-0137', 'Broca 29', 'Broca 29', 50.75, 3, 1, 2, 1, 1, 'img/20231027_162601.jpg'),
(257, 'H-0138', 'Broca 30', 'Broca 30', 50.75, 2, 1, 2, 1, 1, 'img/20231027_162608.jpg'),
(258, 'H-0139', 'Broca para metal 7/32\"', 'Broca para metal 7/32\"', 80.75, 5, 1, 2, 1, 1, 'img/IMG_20231030_132125_501_hdr.jpg'),
(259, 'MARC001-5X', 'Porta platina', 'Porta platina MARC001-5X ', 40.00, 8, 4, 3, 1, 1, 'img/IMG_20231031_085206_665_hdr.jpg'),
(260, 'MARC001-5Q', 'Tornillo para varilla de soporte', 'Tornillo para varilla de soporte MARC001-5Q', 8.00, 1, 4, 3, 1, 1, 'img/IMG_20231031_085129_359_hdr.jpg'),
(261, 'MARC001-6D', 'Tornillo para retención de base superior.', 'Tornillo para retención de base superior. (TORNILLO SUJECION 3) MARC001-6D', 8.00, 2, 4, 3, 1, 1, 'img/IMG_20231031_085117_602_hdr.jpg'),
(262, 'MARC001-4ñ', 'VARILLA DE SOPORTE', 'VARILLA DE SOPORTE MARC001-4ñ', 40.00, 1, 4, 3, 1, 1, 'img/IMG_20231031_085158_182_hdr.jpg'),
(263, 'MARC001-BR', 'Tornillo para varilla niveladora', 'Tornillo para varilla niveladora, MARC001-BR (área de nivel de altura)', 35.00, 1, 4, 3, 1, 1, 'img/IMG_20231031_085140_134_hdr.jpg'),
(264, 'MARC001-5C', 'Pernos para sujeción de porta platina', 'Pernos para sujeción de porta platina, MARC001-5C', 10.00, 12, 4, 3, 1, 1, 'img/pernos.jpg'),
(265, 'I-0039', 'Kola loka', 'Pegamento kola loka', 20.00, 10, 11, 4, 1, 1, 'img/IMG_20231101_080204_317_hdr.jpg'),
(266, 'I-0040', 'Disco para esmeriladora angular para corte de metal 4 1/2\"', 'Disco para esmeriladora angular para corte de metal 4 1/2\"  marca maxtool', 50.00, 3, 11, 4, 1, 1, 'img/IMG_20231101_120033_192_hdr.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`) VALUES
(1, 'MAPI'),
(2, 'HIGHER-TOOLS'),
(3, 'MAQUINADOS'),
(4, 'COMPRAS FUERA.');

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
(1, 'Administrador', '$2y$10$uJv3jCCQKn20CMWiYjw6sOh81jCmUoEN8YJMLASs30kbTa6g6/Fuq', 'Administrador_95.jpg', '2023-11-06 21:45:33', '2023-11-10 22:33:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id_cotizacion`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_factura` (`id_factura`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_orden` (`id_orden`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `estatus_factura`
--
ALTER TABLE `estatus_factura`
  ADD PRIMARY KEY (`id_estatus`);

--
-- Indices de la tabla `estatus_orden`
--
ALTER TABLE `estatus_orden`
  ADD PRIMARY KEY (`id_estatus`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `estatus_factura` (`estatus_factura`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `estatus_orden` (`estatus_orden`);

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
  ADD PRIMARY KEY (`id_proveedor`);

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
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id_cotizacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estatus_factura`
--
ALTER TABLE `estatus_factura`
  MODIFY `id_estatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estatus_orden`
--
ALTER TABLE `estatus_orden`
  MODIFY `id_estatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `detalles_factura`
--
ALTER TABLE `detalles_factura`
  ADD CONSTRAINT `detalles_factura_ibfk_1` FOREIGN KEY (`id_factura`) REFERENCES `facturas` (`id_factura`),
  ADD CONSTRAINT `detalles_factura_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD CONSTRAINT `detalle_orden_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes_compra` (`id_orden`),
  ADD CONSTRAINT `detalle_orden_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`estatus_factura`) REFERENCES `estatus_factura` (`id_estatus`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  ADD CONSTRAINT `ordenes_compra_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `ordenes_compra_ibfk_2` FOREIGN KEY (`estatus_orden`) REFERENCES `estatus_orden` (`id_estatus`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`),
  ADD CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`id_moneda`) REFERENCES `tipos_moneda` (`id_moneda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
