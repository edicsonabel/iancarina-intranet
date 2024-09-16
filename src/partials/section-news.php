<?php
require_once __DIR__ . '/../api/news/functions.php';

$dep = $dep ?? 'all';
$limit = $limit ?? 9;
$new = $new ?? false;

if ($id) {
  $new = getNewByID($id, $dep);
}
if ($new) {
?>

  <article class='my-5 mb-28 max-w-4xl mx-auto px-5'>
    <img class='rounded-lg mx-auto' src='<?= $new['imagen'] ?>' alt={description} />
    <h1 class='my-4 text-4xl text-center font-bold'><?= $new['titulo'] ?></h1>
    <div class='text-center'>
      <span><?= $new["autor"] ?></span> -
      <span><?= date("d/m/o", strtotime($new['fecha'])); ?></span>
    </div>
    <div class='text-center mt-3'>
      <span class='rounded-full bg-red-mary text-white w-fit px-2 py-1'><?= $new["departamento"]; ?></span>
    </div>
    <div class='[&>p]:my-5 text-lg lg:mx-0 [&>ol]:ms-5 [&>ol]:list-decimal [&>ol]:ps-5 [&>ul]:ms-5 [&>ul]:list-disc
 [&>ul]:ps-5'>
      <?= $new['contenido'] ?>
      <nav class='pt-5'>
        <ul class='grid grid-cols-2'>
          <li>
            <?php
            $prev = $new['prev'];
            if ($prev) {
            ?>
              <a href='./?id=<?= $prev ?>' class='bg-red-mary hover:bg-red-700 text-white font-bold py-3 px-5 rounded-full'> <i class='fa-solid fa-chevron-left pr-2'></i> Anterior</a>
            <?php
            } ?>
          </li>
          <li class='text-end'>
            <?php
            $next = $new['next'];
            if ($next) {
            ?>
              <a href='./?id=<?= $next ?>' class='bg-red-mary hover:bg-red-700 text-white font-bold py-3 px-5 rounded-full'> Siguiente <i class='fa-solid fa-chevron-right pl-2'></i></a>
            <?php
            } ?>
          </li>
        </ul>
      </nav>
    </div>
  </article>

<?php } else if ($id) {
?>
  <h2 class="text-4xl text-center font-bold py-10">No existe esta novedad</h2>
<?php
} else {
  $result = getNews($dep, $page, $limit);
  $news = $result['news'];
?>
  <div class='lg:px-16'>
    <section class='w-full lg:w-8/12 gap-5 py-5 px-5 mb-28'>
      <?php
      foreach ($news as $new) {
      ?>
        <a href='<?= '?id=' . $new["id"]; ?>' class='flex flex-row my-3 shadow-xl rounded-2xl overflow-hidden'>
          <div class='max-w-48 w-full aspect-square bg-cover bg-center' style='background-image: url("<?= $new["imagen"]; ?>");'>
          </div>
          <div class='flex flex-col grow p-3 gap-1'>
            <span>
              <span class='rounded-full bg-red-mary text-white w-fit px-2 py-1'><?= $new["departamento"]; ?></span>
              <span class='ms-2'><?= $new["autor"] ?></span>
              <span class='ms-2'><?= date("d/m/o", strtotime($new['fecha'])); ?></span>
            </span>
            <h3 class='text-2xl font-bold mt-3'><?= $new["titulo"]; ?></h3>
            <p class='text-lg'><?= trim(substr(strip_tags($new["contenido"]), 0, 150)); ?>...</p>
          </div>
        </a>
      <?php
      }
      ?>
  </div>
  </section>
  <nav class='my-5 max-w-4xl mx-auto text-center'>
    <?php
    $pagination = $result['pagination'];
    if ($pagination > 1) {
      for ($i = 1; $i <= $pagination; $i++) {
        $href = "./?page=$i";
        if ($i === 1) {
          $href = "./";
        }
        $bgCurrent = 'bg-gray-500';
        if ($i == $page) {
          $bgCurrent = 'bg-red-mary';
        }
    ?>
        <a href='<?= $href ?>' class='<?= $bgCurrent ?> hover:bg-red-mary text-white text-sm py-2 px-4 rounded mx-1'><?= $i ?></a>
  <?php
      }
    }
  } ?>
  </nav>