<?php
require_once __DIR__ . '/../../api/news/functions.php';
$id = isset($_GET['id']) ? trim($_GET['id']) : false;

?>

<section class='p-4 flex flex-col justify-center items-center'>
  <div class='md:max-w-xl'>
    <h2 class='text-2xl font-bold text-center py-2'>Cumpleañeros del mes</h2>
  </div>

  <div class='grid grid-cols-1 md:grid-cols-3 md:gap-10'>
    <div class='flex flex-col justify-center items-center my-8'>
      <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/avatar-user.png' />
      <p class=' text-3xl font-bold'>Vicenzo Giusti</p>
      <span class='font-bold text-gray-500 italic'>dd/mm</span>
    </div>
    <div class='flex flex-col justify-center items-center my-8'>
      <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/employees/arianna-gonzalez.jpg' />
      <p class='text-3xl font-bold'>Arianna González</p>
      <span class='font-bold text-gray-500 italic'>dd/mm</span>
    </div>
    <div class='flex flex-col justify-center items-center my-8'>
      <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/avatar-user.png' />
      <p class='text-3xl font-bold'>Hector Lucena</p>
      <span class='font-bold text-gray-500 italic'>dd/mm</span>
    </div>
    <div class='flex flex-col justify-center items-center my-8'>
      <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/employees/maria-emilia-campos.jpg' />
      <p class='text-3xl font-bold'>María Emilia Campos</p>
      <span class='font-bold text-gray-500 italic'>dd/mm</span>
    </div>
    <div class='flex flex-col justify-center items-center my-8'>
      <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/employees/jorge-valera.jpg' />
      <p class='text-3xl font-bold'>Jorge Valera</p>
      <span class='font-bold text-gray-500 italic'>dd/mm</span>
    </div>
    <div class='flex flex-col justify-center items-center my-8'>
      <img class='aspect-square w-60 rounded-full' src='../../src/assets/images/employees/dayan-benitez.jpg' />
      <p class='text-3xl font-bold'>Dayan Benitez</p>
      <span class='font-bold text-gray-500 italic'>dd/mm</span>
    </div>
  </div>
</section>