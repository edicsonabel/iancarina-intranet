<?php
/*
  Variable `$view`

  Nombre de la carpeta de la vista (`/src/views/$view`) a la que deseamos ingresar.

  Ejemplo: $view = 'inicio';
  Resultado: /src/views/inicio/

  Ejemplo: $view = 'login';
  Resultado: /src/views/login/
*/
$view = 'recursos-tecnologia';

/*
  Variable `$displayName`

  Nombre a mostrar en el título (<title>) del `/src/partials/head.php` de la vista.

  Ejemplo: $displayName = '';
  Resultado: Project Template

  Ejemplo: $displayName = 'Inicio';
  Resultado: Inicio | Project Template
*/
$displayName = 'Recursos de Tecnología';

require_once __DIR__ . '/../../src/partials/layout.php';
