<?php
require_once __DIR__ . '/../api/birthday/functions.php';

$sort = $sort ?? 'fecha_nacimiento';
$title = 'Cumpleañeros del mes';

$birthdayMonth = getBirthdayMonth();
?>
<section class='mt-5 p-4 flex flex-col justify-center items-center'>
  <div class='md:max-w-xl'>
    <h2 class='text-4xl font-bold text-center pt-2 pb-5'><?= $title ?></h2>
  </div>

  <table class='table-auto'>
    <thead class='bg-red-mary text-white'>
      <tr>
        <th class='text-center px-2 md:px-14 rounded-l-full'>Fecha</th>
        <th class='text-center px-2 md:px-14'>Nombre y Apellido</th>
        <th class='text-center px-2 md:px-14 rounded-r-full'>Departamento</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($birthdayMonth as $birthday) {
      ?>
        <tr>
          <td class='text-center'><?= date('d/m', strtotime($birthday['fecha_nacimiento'])); ?></td>
          <td class='text-center'><?= $birthday['nombre1'] . ' ' . $birthday['apellido1']; ?></td>
          <td class='text-center'><?= $birthday['departamento']; ?></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</section>