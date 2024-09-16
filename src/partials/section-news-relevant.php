<?php
require_once __DIR__ . '/../api/news/functions.php';

$dep = $dep ?? 'all';
$limit = $limit ?? 5;
$linkAdd = $linkAdd ?? '../novedades/';
$result = getNews($dep, $page, $limit);
$news = $result['news'];

?>
<section class='container max-w-screen-md my-10 mx-auto'>
  <?php
  foreach ($news as $new) {
  ?>
    <a href='<?= $linkAdd . '?id=' . $new["id"]; ?>' class='flex flex-row my-3 shadow-xl rounded-2xl overflow-hidden'>
      <div class='max-w-32 w-1/3 aspect-square bg-cover bg-center' style='background-image: url("<?= $new["imagen"]; ?>");'>
      </div>
      <div class='flex flex-col grow p-3 gap-1'>
        <span class='rounded-full bg-red-mary text-white w-fit px-2'><?= $new["departamento"]; ?></span>
        <h3 class='text-2xl font-bold'><?= $new["titulo"]; ?></h3>
      </div>
    </a>
  <?php
  }
  ?>
  <a href='<?= $linkAdd; ?>' class='text-2xl mx-auto block rounded-full bg-red-mary text-white w-fit px-5 py-3 mt-7'>Ver todas las novedades</a>
</section>