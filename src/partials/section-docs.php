<?php
require_once __DIR__ . '/../api/docs/functions.php';

if (!$dep) {
  $dep = 'all';
}
if (!$sort) {
  $sort = 'id';
}
if (!$title) {
  $title = 'Documentos';
}

$docs = getDocs($dep);

if ($docs) { ?>
  <section class='min-h-[20vh] px-2 py-4 grid grid-cols-1 bg-blue-400'>
    <h2 class='text-center text-2xl text-white'><?= $title ?></h2>
    <ul class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3'>
      <?php
      foreach ($docs as $doc) {
      ?>
        <li class='text-white text-center'>
          <a target='_blank' href='<?= $doc['ubicacion'] ?>'><i class="fa-regular fa-file"></i> <?= $doc['titulo'] ?></a>
        </li>
      <?php
      }
      ?>
    </ul>
  </section>
<?php
}
?>