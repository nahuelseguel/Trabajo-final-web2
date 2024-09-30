<?php
class Model
{
    protected $db;
    private $adminUserPw = '$2y$10$FF6r02TU9nzHXMJwm6jEo.UpI6RWVVuNc.kFZrAh9PIcADEcp2v2u';
    private $adminApiKey = '$2y$10$w6ATQYSLhFjFPaEbCIa3UuASUAaEehwsl4msp4FrjfRAfdKZ8nS1y';
    function __construct()
    {
        $this->db = new PDO('mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8', MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }

    function deploy()
    {
        // Chequear si hay tablas
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll(); // Nos devuelve todas las tablas de la db
        if (count($tables) == 0) {
            // Si no hay crearlas
            $sql = <<<END
                
                
                --
                -- Estructura de tabla para la tabla `articulo`
                --
                
                CREATE TABLE IF NOT EXISTS `articulo` (
                    `id_articulo` int(11) NOT NULL AUTO_INCREMENT,
                    `id_categoria` tinyint(4) NOT NULL,
                    `nombre` varchar(30) NOT NULL,
                    `precio` float NOT NULL,
                    `alto` float NOT NULL,
                    `ancho` float NOT NULL,
                    `profundidad` float NOT NULL,
                    `imagePath` varchar(60) NOT NULL,
                    PRIMARY KEY (`id_articulo`),
                    KEY `id_categoria` (`id_categoria`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                
                -- --------------------------------------------------------              
                --
                -- Estructura de tabla para la tabla `usuario`
                --
                CREATE TABLE IF NOT EXISTS `usuario` (
                    `email` varchar(50) NOT NULL,
                    `nombre` varchar(50) NOT NULL,
                    `password` varchar(100) NOT NULL,
                    `apikey` varchar(100) NOT NULL,
                    PRIMARY KEY (`email`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
                --
                -- --------------------------------------------------------
                -- Estructura de tabla para la tabla `categoria`
                --               
                CREATE TABLE IF NOT EXISTS `categoria` (
                        `id_categoria` tinyint(4) NOT NULL AUTO_INCREMENT,
                        `tipo` varchar(30) NOT NULL,
                        PRIMARY KEY (`id_categoria`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
              
                --
                -- Volcado de datos para la tabla `categoria`
                --
                
                INSERT INTO `categoria` (`id_categoria`,`tipo`) VALUES
                (1, 'Mesa'),
                (2, 'Silla'),
                (3, 'Sillon'),
                (4, 'Cama'),
                (5, 'Escritorio'),
                (6, 'Comoda');
                --
                
                --
                -- Volcado de datos para la tabla `articulo`
                --
                INSERT INTO `articulo` (`id_articulo`, `id_categoria`, `nombre`, `precio`, `alto`, `ancho`, `profundidad`, `imagePath`) VALUES
                (1, 4, 'Cama Individual', 139990, 75, 90, 200, 'images/cama individual.png'),
                (2, 1, 'Mesa de roble', 97599, 100, 80, 140, 'images/mesa1.jpg'),
                (3, 2, 'Silla de pino', 14500, 127, 40, 40, 'images/silla de pino.jpg'),
                (4, 1, 'Mesa circular', 57000, 100, 130, 130, ''),
                (5, 3, 'Futón de 2 cuerpos', 127900, 78, 160, 60, ''),
                (6, 1, 'Mesa de Cristal', 172301, 75, 120, 80, ''),
                (7, 2, 'Silla de Oficina', 79999, 90, 60, 50, ''),
                (8, 3, 'Sillon Reclinable', 56500, 100, 85, 90, ''),
                (9, 4, 'Cama King Size', 247110, 40, 200, 220, ''),
                (10, 7, 'Comoda de Dormitorio', 51149.7, 80, 100, 40, ''),
                (11, 6, 'Escritorio de Estudio', 129000, 75, 120, 60, ''),
                (12, 1, 'Mesa de Centro', 347500, 45, 90, 60, ''),
                (13, 2, 'Silla de Comedor', 16905.2, 95, 50, 45, ''),
                (13, 2, 'Silla de Comedor', 16905.2, 95, 50, 45, ''),
                (14, 3, 'Sillon de Relax', 349099, 110, 75, 85, ''),
                (15, 4, 'Cama Individual', 139990, 75, 90, 200, ''),
                (36, 16, 'Mesita metalica', 99999, 105, 55, 207, ''),
                (37, 16, 'Silla metalica', 99999, 105, 55, 207, ''),
                (38, 16, 'Pergola plegable', 12346, 250, 400, 370, ''),
                (39, 16, 'Silla de piedra', 47500, 105, 55, 207, '');
                
                --
                -- Volcado de datos para la tabla `usuario`
                --
                
                INSERT INTO `usuario` (`email`, `nombre`, `password`, `apikey`) VALUES
                ('webadmin', 'Administrador', '$this->adminUserPw', '$this->adminApiKey');
                ('pablodem32@gmail.com', 'Pablo Demateo', '$this->adminUserPw', '$this->adminApiKey');
                ('nahuelseguel@gmail.com', 'Nahuel Seguel', '$this->adminUserPw', '$this->adminApiKey');
                
                --
                -- Índices para tablas volcadas
                --
                
                --
                -- Indices de la tabla `articulo`
                --
                ALTER TABLE `articulo`
                ADD CONSTRAINT `articulo_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE;
                
                COMMIT;
                END;
            $this->db->query($sql);
        }

    }
}