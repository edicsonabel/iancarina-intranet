<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../utils/php/getVersion.php';
require_once __DIR__ . '/../utils/php/importmap.php';
$version = getVersion();
?>

<head>
  <meta charset='UTF-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel='icon' type='image/png' href='../../src/assets/images/favicon-alimentos-mary.png' />
  <title>
    <?php if ($displayName) {
      echo "$displayName | ";
    }
    echo PROJECT_NAME; ?>
  </title>
  <link rel='stylesheet' href='../../src/assets/fonts/Inter/inter.css?version=<?= $version; ?>'>
  <!-- <link rel='stylesheet' href='../../src/assets/icons/style.css?version=<?= $version; ?>'> -->
  <link rel='stylesheet' href='../../src/assets/libraries/fontawesome/css/all.min.css?version=<?= $version; ?>'>
  <link rel='stylesheet' href='../../src/assets/global.css?version=<?= $version; ?>'>
  <link rel='stylesheet' href='../../src/assets/libraries/flowbite/styles.css?version=<?= $version; ?>'>
  <?php
  $jsFolder = __DIR__ . '/../utils/js/';
  $jsFolderDOM = '../../src/utils/js/';
  importmap($jsFolder, $jsFolderDOM, $version);
  ?>
  <script src='../../src/assets/libraries/tailwind/script.js?version=<?= $version; ?>'></script>
  <script>
    tailwind.config = {
      theme: {
        colors: {
          'red-mary': '#da2b1f'
        },
        extend: {
          aspectRatio: {
            '16/8': '16 / 8'
          },
          height: {
            '16/8': 'calc(95vw * 8 / 16)'
          }
        }
      },
    }
  </script>
  <script src='../../src/assets/libraries/flowbite/script.js?version=<?= $version; ?>'></script>
  <script defer type='module' src='../../src/utils/js/general.js?version=<?= $version; ?>'></script>
  <?php
  if (file_exists(__DIR__ . "/../views/$view/script.js"))
    echo "<script defer type='module' src='../../src/views/$view/script.js?version=<?= $version; ?>'></script>";
  ?>
</head>