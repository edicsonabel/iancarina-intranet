<?php
require_once __DIR__ . '/../api/news/functions.php';

if (!$dep) {
  $dep = 'all';
}
if (!$limit) {
  $limit = 9;
}

if ($id) {
  $new = getNewByID($id);
}
if ($new) {
?>

  <article class='my-5 mb-28 max-w-4xl mx-auto px-5'>
    <img class='rounded-lg mx-auto' src='../admin/<?= $new['Imagen'] ?>' alt={description} />
    <h1 class='my-4 text-4xl text-center font-bold'><?= $new['Titulo'] ?></h1>
    <div class='text-center'>
      <!-- <FormattedDate date={pubDate} /> -->
    </div>
    <div class='[&>p]:my-5 text-lg lg:mx-0'>
      <?= $new['Contenido'] ?>
      <nav class='pt-5'>
        <ul class='grid grid-cols-2'>
          <li>
            <?php
            $next = $new['next'];
            if ($next) {
              echo "<a href='./?id=$next' class='bg-red-mary hover:bg-red-700 text-white font-bold py-3 px-5 rounded-full'> <i class='fa-solid fa-chevron-left pr-2'></i> Siguiente</a>";
            } ?>
          </li>
          <li class='text-end'>
            <?php
            $prev = $new['prev'];
            if ($prev) {
              echo "<a href='./?id=$prev' class='bg-red-mary hover:bg-red-700 text-white font-bold py-3 px-5 rounded-full'>Anterior <i class='fa-solid fa-chevron-right pl-2'></i></a>";
            } ?>
          </li>
        </ul>
      </nav>
    </div>
  </article>


<?php } else if ($id) {
  echo '<span>No existe esta noticia</span>';
} else {
  $result = getNews($dep, $page, $limit);
  $news = $result['news'];
?>

  <section class='grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 my-5 mb-28'>
    <?php
    foreach ($news as $new) {
      echo '
    <div  class="max-w-sm bg-white border border-gray-200 rounded-lg shadow mx-auto">
      <a href="?id=' . $new['ID'] . '">
        <img class="rounded-t-lg" src="../admin/' . $new['Imagen'] . '" alt="' . $new['Titulo'] . '" />
      </a>
    <div class="p-5">
    <a href="?id=' . $new['ID'] . '">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
      ' . $new['Titulo'] . '
      </h5>
    </a>
    <a
      href="?id=' . $new['ID'] . '"
      class="inline-flex
      items-center
      px-3
      py-2
      text-sm
      font-medium
      text-center
      text-white
      bg-red-mary
      rounded-lg
      focus:outline-none"
    >
      Leer más
      <svg
        class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 14 10"
      >
        <path
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M1 5h12m0 0L9 1m4 4L9 9"
        ></path>
      </svg>
    </a>
  </div>
</div>
';
    }
    ?>
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
      echo "<a href='$href' class='$bgCurrent hover:bg-red-mary text-white text-sm py-2 px-4 rounded mx-1'>$i</a>";
    }
  }
} ?>
  </nav>