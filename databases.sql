CREATE TABLE documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(250) NOT NULL,
    descripcion VARCHAR(250) NOT NULL,
    ubicacion VARCHAR(250) NOT NULL,
    departamento TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo TEXT NOT NULL,
    contenido TEXT NOT NULL,
    imagen TEXT NOT NULL,
    fecha DATETIME NOT NULL,
    autor TEXT NOT NULL,
    departamento TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(50) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    departamento VARCHAR(50) NOT NULL,
    nivel INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE promociones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trabajador VARCHAR(250) NOT NULL,
    descripcion VARCHAR(250) NOT NULL,
    ubicacion VARCHAR(250) NOT NULL 
) ENGINE=InnoDB;

INSERT INTO usuarios (
  usuario,
  clave,
  nombre,
  departamento,
  nivel
) VALUES (
  'admin',
  'admin',
  'Administrador',
  'Tecnologia',
  '1'
)