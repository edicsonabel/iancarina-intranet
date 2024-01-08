# Intranet | Alimentos Mary
Aplicación de la Intranet de Alimentos Mary, usando las siguientes tecnologías.

- [PHP](https://www.php.net/)
- [Inter | Google Font](https://fonts.google.com/specimen/Inter/)
- [IconMoon](https://icomoon.io/)
- [Tailwind](https://tailwindcss.com/)
- [Flowbite](https://flowbite.com/)

## Creación de vistas
Para crear vistas en la aplicación debemos crear dos rutas. La primera es `/v/<nombre-de-vista>/index.php` y la segunda en `/src/views/<nombre-de-vista>/index.php`, donde cada una tendrán las plantillas siguientes.

El primer archivo tendrá el nombre de la carpeta de vista en la variable `$view`, ya que ésta hará el llamado a la vista asignada cuando se incluya el `layout.php`. Asimismo en la variable `$displayName` debemos asignar el nombre a mostrar en el título.

```php
/* file: /v/<carpeta-de-vista>/index.php */
<?php
/*
  Variable `$view`

  Nombre de la carpeta de la vista (`/src/views/$view`) a la que deseamos ingresar.

  Ejemplo: $view = 'inicio';
  Resultado: /src/views/inicio/

  Ejemplo: $view = 'login';
  Resultado: /src/views/login/
*/
$view = 'inicio';

/*
  Variable `$displayName`

  Nombre a mostrar en el título (<title>) del `/src/partials/head.php` de la vista.

  Ejemplo: $displayName = '';
  Resultado: Intranet | Alimentos Mary

  Ejemplo: $displayName = 'Inicio';
  Resultado: Inicio | Intranet | Alimentos Mary
*/
$displayName = 'Nombre de mi vista';

require_once(__DIR__ . '/../../src/partials/layout.php');
```

El segundo archivo tendrá todo lo relacionado con vista que deseamos mostrar en la página.

```php
/* file: /src/views/<nombre-de-vista>/index.php */

<h1>Esta es mi vista con HTML</h1>

<?php
  echo 'texto con PHP';
?>
```

> Si deseas crear archivos que solo sean válidos para esa página, se sugiere tener dichos archivos en la carpeta de la vista para su posterior uso. Es decir, si queremos usar un `script.js` solo para esa vista, creamos el archivo en la ruta `/src/views/<nombre-de-vista>/script.js` y se inserta en el `switch` de que está en el archivo `/src/partials/head.php` o usa en el archivo de la vista `/src/views/<nombre-de-vista>/index.php` directamente.

## Variables de entorno
Debemos crear un archivo en la raíz del proyecto con el nombre `/config.php` y para centralizar los datos que manejara toda la aplicación. Allí debemos colocar las constantes que deseamos inicializar como configuración del proyecto.

```php
/* file: /config.php */
<?php

/* Definir en nombre del proyecto */
if (!defined('PROJECT_NAME')) {
  define('PROJECT_NAME', 'Intranet | Alimentos Mary'); // 'Intranet | Alimentos Mary'
}
```