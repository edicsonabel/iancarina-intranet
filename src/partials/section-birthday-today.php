<?php
require_once __DIR__ . '/../api/birthday/functions.php';

$sort = $sort ?? 'fecha_nacimiento';
$title = 'Cumpleañeros de hoy';

$birthdayToday = getBirthdayToday();
?>
<section class='mt-5 p-4 flex flex-col justify-center items-center'>
  <div class='md:max-w-xl'>
    <h2 class='text-4xl font-bold text-center py-2'><?= $title ?></h2>
  </div>
  <div class='grid grid-cols-1 md:grid-cols-3 md:gap-20 mt-8'>
    <?php

    foreach ($birthdayToday as $birthday) {
    ?>
      <div class='flex flex-col justify-center items-center'>
        <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/avatar-user.png' />
        <p class='text-2xl font-bold'><?= $birthday['nombre1'] . ' ' . $birthday['apellido1']; ?></p>
        <p class='flex justify-between w-full text-xs'>
          <span class='font-bold italic bg-gray-500 text-white px-4 py-1 rounded-full'><?= date('d/m', strtotime($birthday['fecha_nacimiento'])); ?></span>
          <span class='font-bold italic bg-red-mary text-white px-4 py-1 rounded-full'><?= $birthday['departamento']; ?></span>
        </p>
      </div>
    <?php
    }
    ?>
  </div>
</section>