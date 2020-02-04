-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-01-2020 a las 20:32:14
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `forum`
--
CREATE DATABASE IF NOT EXISTS forum CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'forum'@'localhost' IDENTIFIED BY PASSWORD '*D741B9CBA88F99274F71CB62FE633C00AF973DBC';
USE `forum`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `title`, `description`, `image`, `date_add`, `active`, `id_user`) VALUES
(1, 'Php', 'Categoría para php.', NULL, '2019-09-10 12:40:26', 1, 1),
(4, 'prueba', 'prueba', 'icon-folder.png', '2019-11-16 20:38:00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum`
--

CREATE TABLE `forum` (
  `id_forum` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `id_category` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forum`
--

INSERT INTO `forum` (`id_forum`, `title`, `description`, `image`, `date_add`, `active`, `id_category`, `id_user`) VALUES
(1, 'Clases', 'Categoría para php.', '', '2019-09-10 12:40:26', 1, 1, 1),
(2, 'Bases de Datos', 'Foro para las dudas que se puedan tener sobre la Base de Datos en php.', 'icon-folder.png', '2019-09-21 08:00:15', 1, 1, 1),
(3, 'prueba', 'prueba', NULL, '2019-11-15 08:00:15', 1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL,
  `id_topic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id_post`, `title`, `text`, `image`, `date_add`, `active`, `id_user`, `id_topic`) VALUES
(1, 'Cuando se debe utilizar herencia.', 'Hola me gustaría que alguien me pudiese explicar cuando es correcto utilizar herencia en php.', NULL, '2019-09-17 18:35:10', 1, 1, 1),
(2, 'Ayuda con guardar registros en BD', 'Hola, he estado intentando crear un formulario para guardar registros en una base de datos, pero me sale constantemente este error.\r\n\r\nParse error: syntax error, unexpected \'$conexion\' (T_VARIABLE) in C:\\xampp\\htdocs\\Formulario\\guardar.php on line 7\r\n\r\nPor más que miro no logro descubrir cuál es el susodicho error, ¿alguno me podría hechar una mano? por favor.\r\n\r\nLa base de datos se llama uniforme, tiene una tabla llamada uniformes y la tabla tiene 3 campos: tipo - general - talla\r\nLos tres campos son de tipo CHAR\r\n', NULL, '2019-09-21 08:05:12', 1, 1, 2),
(3, 'No se ordenan las tablas mysql en php.', 'Hola, el problema que tengo es simple tengo una base de datos en mysql, al poner la consulta en php funciona correctamente el problema es que los datos en vez de aparecer en columnas como se supone que tiene que ser con <td> y <tr> aparecen amontonados uno abajo del otro.\r\n', NULL, '2019-09-23 12:33:45', 1, 1, 3),
(4, 'clase PDO no encontrada', 'Hola a todos estoy tratando que conectarme a una base de datos mysql y me aparece un fatal error que dice básicamente que no se ha encontrado la clase PDO, estoy usando la version 7 de php y creo que no debiera tener problemas ya que la extensión pdo esta predeterminada habilitada.\r\n\r\ncualquier ayuda u orientacion de donde podría estar el problema es bienvenida muchas gracias.', NULL, '2019-09-21 16:02:25', 1, 1, 4),
(5, 'usar o no set_atribute(PDO::ATTR_ARRMODE, PDO::ERRMODE_EXCEPTION', 'Hola chicos muy buenas tardes. tengo una pequeña duda que no he podido resolver y es que he estado revisando varios codigos de como se realiza una conexión con PDO. en algunos códigos aparece\r\nset_atribute(PDO::ATTR_ARRMODE, PDO::ERRMODE_EXCEPTION, dentro del try y en el catch PDOException $e.\r\n\r\npero en otros códigos solo utilizan en el catch (PDOException $e).\r\n\r\ny he aquí mi duda, ¿cual seria la diferencia entre usar no usar set_atribute(PDO::ATTR_ARRMODE, PDO::ERRMODE_EXCEPTION? ya que lo he probado con algunas fallos a propósito y me aparece lo mismo.', NULL, '2019-09-22 10:20:51', 1, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topic`
--

CREATE TABLE `topic` (
  `id_topic` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `id_user` int(11) NOT NULL,
  `id_forum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `topic`
--

INSERT INTO `topic` (`id_topic`, `title`, `description`, `image`, `date_add`, `views`, `active`, `id_user`, `id_forum`) VALUES
(1, 'Cuando se debe utilizar herencia.', 'Cuando se debe utilizar herencia.', NULL, '2019-09-17 18:02:42', NULL, 1, 1, 1),
(2, 'Ayuda con guardar registros en BD', 'Hola, he estado intentando crear un formulario para guardar registros en una base de datos, pero me sale constantemente este error.', NULL, '2019-09-21 08:02:46', NULL, 1, 1, 2),
(3, 'No se ordenan las tablas mysql en php', 'Hola, el problema que tengo es simple tengo una base de datos en mysql.', NULL, '2019-09-23 12:30:59', NULL, 1, 1, 2),
(4, 'clase PDO no encontrada', 'Hola a todos estoy tratando que conectarme a una base de datos mysq.', NULL, '2019-09-21 15:53:04', NULL, 1, 1, 2),
(5, 'usar o no set_atribute(PDO::ATTR_ARRMODE, PDO::ERRMODE_EXCEPTION', 'Hola chicos muy buenas tardes. tengo una pequeña duda que no he podido resolver sobre PDO.', NULL, '2019-09-22 10:18:14', NULL, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(125) NOT NULL,
  `surnames` varchar(255) NOT NULL,
  `province` varchar(125) NOT NULL,
  `lang` varchar(30) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `id_user_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `name`, `surnames`, `province`, `lang`, `avatar`, `date_add`, `active`, `id_user_group`) VALUES
(1, 'admin', '$2y$10$jsDHNACAbEabtr7Dcin2uOvFrTskpjykOPzBqiU1eklve88rgYn86', 'admin@admin.org', '', '', '', 'es', 'user_default.png', '2019-09-10 12:26:26', 1, 1),
(2, 'user', '$2y$10$Bo4hoLCi9Mi.PouqA4jS7OsVIA.n88VtjhXrxzW4aVhhcA9PqBujy', 'user@user.com', '', '', '', 'es', 'user_default.png', '2019-12-27 17:31:14', 1, 2),
(6, 'a', '$2y$10$PGeJ3fGDNjuB4TuLzrj5OeFlPYj4hpGIO6rCBn17nivOgMnTXo.be', 'useer@user.com', 'a', 'a', 'a', 'es', 'user_default.png', '2020-01-12 20:29:36', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group`
--

CREATE TABLE `user_group` (
  `id_user_group` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `date_add` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_group`
--

INSERT INTO `user_group` (`id_user_group`, `name`, `description`, `avatar`, `date_add`) VALUES
(1, 'admin', 'admin', NULL, '2019-09-10 12:13:26'),
(2, 'user', 'normal user', NULL, '2019-12-17 17:16:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `fk_Category_User1_idx` (`id_user`);

--
-- Indices de la tabla `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id_forum`),
  ADD KEY `fk_Forum_User1_idx` (`id_user`),
  ADD KEY `fk_Forum_Category1_idx` (`id_category`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `fk_Post_Topic1_idx` (`id_topic`),
  ADD KEY `fk_Post_User1_idx` (`id_user`);

--
-- Indices de la tabla `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id_topic`),
  ADD KEY `fk_Topic_User1_idx` (`id_user`),
  ADD KEY `fk_Topic_Forum1_idx` (`id_forum`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_User_User_Group1_idx` (`id_user_group`);

--
-- Indices de la tabla `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id_user_group`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `forum`
--
ALTER TABLE `forum`
  MODIFY `id_forum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `topic`
--
ALTER TABLE `topic`
  MODIFY `id_topic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id_user_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `fk_Category_User1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Filtros para la tabla `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `fk_Forum_Category1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Forum_User1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_Post_Topic1` FOREIGN KEY (`id_topic`) REFERENCES `topic` (`id_topic`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Post_User1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `fk_Topic_Forum1` FOREIGN KEY (`id_forum`) REFERENCES `forum` (`id_forum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Topic_User1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_User_User_Group1` FOREIGN KEY (`id_user_group`) REFERENCES `user_group` (`id_user_group`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
