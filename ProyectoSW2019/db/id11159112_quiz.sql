-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-10-2019 a las 14:04:35
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id11159112_quiz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `Identificador` int(11) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Pregunta` text NOT NULL,
  `Respuesta_correcta` text NOT NULL,
  `R_Erronea_1` text NOT NULL,
  `R_Erronea_2` text NOT NULL,
  `R_Erronea_3` text NOT NULL,
  `Complejidad` varchar(5) NOT NULL,
  `Tema` varchar(50) NOT NULL,
  `Imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Almacena las preguntas introducidas por el usuario';

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`Identificador`, `Correo`, `Pregunta`, `Respuesta_correcta`, `R_Erronea_1`, `R_Erronea_2`, `R_Erronea_3`, `Complejidad`, `Tema`, `Imagen`) VALUES
(56, 'ulizarralde004@ikasle.ehu.eus', '¿HTML5 con que atributo puede validar automaticamente los formularios?', 'Con el tag required', 'No se puede', 'EHay que aprender a utilizar JavaScript', 'No aparece en el manual', 'Media', 'Validación obligatoria en HTML5', NULL),
(60, 'ulizarralde004@ikasle.ehu.eus', '¿Funciona bien la base de datos en la nube?', 'Quiero creer que lo hará', 'No', 'Todo reside en la confianza que se tiene', 'Cuanto antes lo prueba mejor va a ser', 'Media', 'Prueba en la nube', NULL),
(62, 'ulizarralde004@ikasle.ehu.eus', '¿Javascript es lo mismo que JQuery?', 'No, Javascript es el lenguaje, JQuery es una librería para dicho lenguaje', 'Son exactamente lo mismo', 'Depende tipo de servidor', 'JQuery tiene eventos, Javascript no', 'Baja', 'Igualdad entre JavaScript y JQuery', 'JavaScript-vs-JQuery.png'),
(63, 'ulizarralde004@ikasle.ehu.eus', '¿Donde se ejectuta PHP?', 'En el servidor', 'En el cliente', 'En la palestra', 'PHP es un sistema de gestión de base de datos, no necesita nada más', 'Media', 'PHP entorno de ejecución', '1200px-PHP-logo.svg.png'),
(64, 'ulizarralde004@ikasle.ehu.eus', '¿Cuales son los lenguajes predominantes en el lado del cliente?', 'HTML, CSS y JavaScript', 'PHP y JQuery', 'HTTP y HTML', 'ASP.net y ASP', 'Media', 'Lenguajes front-end', 'image.axd.png'),
(65, 'ulizarralde004@ikasle.ehu.eus', '¿Como se denomina a un ingeniero del software que domina tanto el front-end como el backend?', 'Full-stack developer', 'All-stack developer', 'Front-back-developer', 'All-sides developer', 'Media', 'Desarrollador de ambos lados', 'Full-Stack-Developer.jpg'),
(66, 'ulizarralde004@ikasle.ehu.eus', '¿Es la seguridad importante para un sistema web?', 'Garantizan el ecosistema y la integridad del sistema web', 'No no hace falta tomar medidas de seguridad', 'No, ya lo hace HTML5 automáticamente', 'Basta con utilizar JavaScript para a validación', 'Media', 'Seguridad en sistemas web', '1501-seguridad-sistemas-web-1030x1030.jpg'),
(67, 'ulizarralde004@ikasle.ehu.eus', '¿Cual es la estructura de un tag en HTML?', '&lt;tag&gt;&lt;/tag&gt;', '&lt;script&gt;tag&lt;/script&gt;', '&lt;/tag&gt;&lt;/tag&gt;', 'tag() {}', 'Baja', 'Estructura de un tag', '1200px-HTML5_logo_and_wordmark.svg.png'),
(68, 'ulizarralde004@ikasle.ehu.eus', '¿Como crear un elemento imagen en JS?', 'createElement(&quot;IMG&quot;);', 'createTag(&quot;IMG&quot;);', 'addElement(&quot;IMG&quot;);', 'setElement(&quot;IMG&quot;);', 'Media', 'Crear un elemento con JavaScript', NULL),
(69, 'ulizarralde004@ikasle.ehu.eus', '¿Como se activa un script al cargar el DOM en jQuery?', '$(&quot;document&quot;).ready(function(){});', '$(&quot;window&quot;).load(function(){});)', 'Hay que esperar hasta que se cargue la ventana antes de poder hacer nada', 'Solo se puede hacer con JavaScript', 'Media', 'Activar eventos al cargar el DOM', '1200px-DOM-model.svg.png'),
(70, 'vadillo@ehu.eus', 'aaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'asdas', 'a', 'asdsa', 'Baja', 'a', '319.png'),
(71, 'ulizarralde004@ikasle.ehu.eus', '¿La seguridad es importante en un sistema web?', 'Asi es', 'No', 'Depende de las caracteristicas particulares surgidas en el desarrollo y el entorno en el que se vaya a ofrecer', 'La seguridad no es estrictamente necesaria para un sistema web robusto', 'Media', 'Importancia de la seguridad', NULL),
(72, 'ulizarralde004@ikasle.ehu.eus', 'jrhjkerhbvjesbp', 'hbhbhipvuhuob', 'hbhbvhbvhuo', 'bhbhojvou', 'bhjbjho', 'Baja', 'hjvhjvvououv', 'BDPrueba.png'),
(73, 'ulizarralde004@ikasle.ehu.eus', '¿Funciona bien la base de datos en la nube?', 'Quiero creer que lo hará', 'No', 'Todo reside en la confianza que se tiene', 'Cuanto antes lo prueba mejor va a ser', 'Baja', 'Prueba en la nube', 'MLNN_BNExample.png'),
(74, 'vadillo@ehu.es', 'aaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaa', 'aaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Baja', 'aaaaaaaaaaaaaaaaa', 'xml1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Correo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Nombre_Apellidos` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Contrasena` text COLLATE utf8_unicode_ci NOT NULL,
  `Imagen` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Correo`, `Nombre_Apellidos`, `Contrasena`, `Imagen`) VALUES
('ulizarralde004@ikasle.ehu.eus', 'Unai Lizarralde Imaz', 'unaielmejor', 'IMG-20180102-WA00172.jpg'),
('jnafarrate002@ikasle.ehu.eus', 'Juli Nafarrate', '1234567', NULL),
('vadillo@ehu.es', 'Jose Vadillo', 'qazxsw', 'yo.gif'),
('jj001@ikasle.ehu.eus', 'jo jo', '1234567', 'descarga.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`Identificador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `Identificador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
