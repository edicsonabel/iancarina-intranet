<?php
require_once __DIR__ . '/../api/promotions/functions.php';

$dep = $dep ?? 'all';
$limit = $limit ?? 9;
$promotion = $promotion ?? false;
$result = getPromotions($dep, $page, $limit);
$promotions = $result['promotions'];
?>

<section class='grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 my-5 mb-28'>
  <?php
  foreach ($promotions as $promotion) {
    echo '
<div class="max-w-sm w-full bg-white border border-gray-200 rounded-lg shadow mx-auto">
  <div class="p-5"> 
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
    ' . $promotion['trabajador'] . '
    </h5>
    <p class="mb-2" >
    ' . $promotion['descripcion'] . '
    </p>
    <a
      target="_blank"
      href="' . $promotion['ubicacion'] . '"
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
      Ver promoción
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
  } ?>
</nav>