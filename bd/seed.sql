INSERT INTO usuarios (id, nombre, email, usuario, contrasena, fecha_creacion, ultimo_acceso, pais, tipo, estado, foto)
VALUES
(1, 'John', 'john.bezzos@pear.com', 'jbezzos', '$2y$10$5GasDG4s5tbUlXCAGsPox.YI4Fk.psiORWLalQqwBB7sTaNVa', '2024-11-20 12:42:15', NULL, 'Spain', 'usuario', 'activo', NULL),
(2, 'Maria', 'maria.blanchard@pear.com', 'mblanchard', '$2y$10$FQXPSYPiVX7v5NS22z.TQMLZ7sF46b.qYmM5cXpMEtxc/G', '2024-11-20 21:52:30', NULL, 'Spain', 'usuario', 'activo', NULL),
(3, 'Luis', 'luis.prueba@prueba.com', 'lprueba', '$2y$10$Om.ua/lmYE91dNUx8ue4zja.WyGoRokH9BDWD26/3RCDXsYa', '2024-11-20 21:53:58', NULL, 'Peru', 'usuario', 'activo', NULL),
(4, 'Emerson', 'emerson.prueba@prueba.com', 'eprueba', '$2y$10$A3QSF509Ewg4aYkOYgSOF57VeusGn8rCTCAD.9oTNeCyGpqBk', '2024-11-20 21:55:01', NULL, 'Peru', 'usuario', 'activo', NULL),
(5, 'Jazmin', 'jrios@emprexsa.com', 'jrios', '$2y$10$/phbXHKk6JU5ifQKCEAyejlpSbIlUMtxJ3ud45bR.ZTU30jAyVu', '2024-11-20 21:56:22', NULL, 'Spain', 'usuario', 'activo', NULL),
(6, 'Mariano', 'mariano.test@test.com', 'mtest', '$2y$10$rdT0GAZyoGxNjJJURa.vpTypts3H1k26mm0k12BtpfDlZw4ha', '2024-11-20 21:57:23', NULL, 'Peru', 'usuario', 'activo', NULL),
(8, 'Luis', 'anghel912@gmail.com', 'lescobar', '$2y$10$3ZhKGMyzHA9Aj3eiudFGejJUANGowansHCAXf9rig3rbU5Oea.jXy', '2024-11-20 22:20:21', NULL, 'Spain', 'usuario', 'activo', NULL);

INSERT INTO habilidades (id, nombre)
VALUES
(1, 'HTML'),
(2, 'CSS'),
(3, 'JavaScript'),
(4, 'PHP'),
(5, 'MySQL'),
(6, 'Node.js'),
(7, 'React'),
(8, 'Python'),
(9, 'Git'),
(10, 'Docker'),
(11, 'Marketing Digital'),
(12, 'Gestión de Proyectos'),
(13, 'Redes Sociales'),
(14, 'Diseño UX/UI'),
(15, 'Data Science'),
(16, 'Consultoría Empresarial'),
(17, 'Estrategia Financiera'),
(18, 'Desarrollo de Producto');

INSERT INTO usuario_habilidades (usuario_id, habilidad_id)
VALUES
-- John (Multidisciplinar)
(1, 1), (1, 2), (1, 3), -- HTML, CSS, JavaScript
(1, 9), (1, 12),        -- Git, Gestión de Proyectos
(1, 11), (1, 13),       -- Marketing Digital, Redes Sociales

-- Maria (Multidisciplinar)
(2, 8), (2, 15),        -- Python, Data Science
(2, 11), (2, 12),       -- Marketing Digital, Gestión de Proyectos
(2, 14),                -- Diseño UX/UI

-- Luis Prueba (Developer)
(3, 6), (3, 7), (3, 9), -- Node.js, React, Git
(3, 10),                -- Docker

-- Emerson Prueba (Developer)
(4, 1), (4, 2), (4, 3), -- HTML, CSS, JavaScript
(4, 4), (4, 9),         -- PHP, Git

-- Jazmin (Multidisciplinar)
(5, 5), (5, 12),        -- MySQL, Gestión de Proyectos
(5, 14), (5, 16),       -- Diseño UX/UI, Consultoría Empresarial
(5, 18),                -- Desarrollo de Producto

-- Mariano (Multidisciplinar)
(6, 4), (6, 5),         -- PHP, MySQL
(6, 13), (6, 17),       -- Redes Sociales, Estrategia Financiera
(6, 12),                -- Gestión de Proyectos

-- Luis Escobar (Multidisciplinar, con enfoque DevOps)
(8, 6), (8, 9), (8, 10), -- Node.js, Git, Docker
(8, 15), (8, 16),        -- Data Science, Consultoría Empresarial
(8, 18);                 -- Desarrollo de Producto

INSERT INTO proyectos (id, nombre, descripcion, creador_id, estado, pais, horas_dedicacion)
VALUES
(1, 'E-Commerce Global', 'Desarrollo de un sitio global de comercio electrónico.', 1, 'activo', 'Spain', 50),
(2, 'API RESTful Avanzada', 'Creación de una API avanzada para sistema interno.', 3, 'activo', 'Peru', 40),
(3, 'Plataforma de Marketing', 'Herramienta para gestionar campañas de marketing.', 2, 'activo', 'France', 35),
(4, 'Sistema de Gestión Educativa', 'Software para colegios.', 5, 'activo', 'Mexico', 40),
(5, 'Optimización de Servidores', 'Proyecto de mejora en infraestructura.', 8, 'activo', 'Spain', 60),
(6, 'Aplicación de Redes Sociales', 'Desarrollo de una nueva app social.', 6, 'activo', 'Italy', 45);

INSERT INTO proyecto_habilidades (proyecto_id, habilidad_id)
VALUES
(1, 1), (1, 2), (1, 3), -- HTML, CSS, JavaScript (Frontend)
(1, 12), (1, 18),       -- Gestión de Proyectos, Desarrollo de Producto

(2, 4), (2, 6), (2, 9), -- PHP, Node.js, Git (Backend)
(2, 10),                -- Docker (DevOps)

(3, 11), (3, 13),       -- Marketing Digital, Redes Sociales
(3, 14),                -- Diseño UX/UI

(4, 5), (4, 8),         -- MySQL, Python
(4, 12), (4, 16),       -- Gestión de Proyectos, Consultoría Empresarial

(5, 6), (5, 9), (5, 10), -- Node.js, Git, Docker (DevOps)
(5, 15),                -- Data Science

(6, 1), (6, 3),         -- HTML, JavaScript
(6, 13), (6, 17);       -- Redes Sociales, Estrategia Financiera

INSERT INTO participantes_proyecto (proyecto_id, usuario_id, rol)
VALUES
(1, 1, 'Fullstack Developer'), -- John
(2, 3, 'Backend Developer'),   -- Luis Prueba
(2, 4, 'Frontend Developer'),  -- Emerson Prueba
(3, 2, 'Marketing Manager'),   -- Maria
(4, 5, 'Project Manager'),     -- Jazmin
(5, 8, 'DevOps Engineer'),     -- Luis Escobar
(6, 6, 'Product Manager');     -- Mariano

INSERT INTO mentores (usuario_id, especialidad, experiencia, calificaciones, pais, tipo_servicio, estado_aprobacion)
VALUES
(1, 'E-Commerce Development', '5 años de experiencia en comercio electrónico.', '⭐⭐⭐⭐', 'Spain', 'consultoria', 'aprobado'),
(2, 'Marketing Digital', 'Especialista en marketing con 7 años de experiencia.', '⭐⭐⭐⭐⭐', 'France', 'formacion', 'aprobado'),
(3, 'Backend Development', 'Experto en APIs RESTful.', '⭐⭐⭐⭐', 'Peru', 'formacion', 'aprobado'),
(4, 'Frontend Development', '4 años de experiencia en HTML/CSS/JS.', '⭐⭐⭐⭐', 'Spain', 'formacion', 'aprobado'),
(8, 'DevOps & Infrastructure', 'Experto en Docker y optimización de servidores.', '⭐⭐⭐⭐⭐', 'Spain', 'consultoria', 'aprobado');
