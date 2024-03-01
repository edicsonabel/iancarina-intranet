<div id='carousel-main' class='relative w-full'>
  <!-- Carousel wrapper -->
  <div id='carousel-main-wrapper' class='relative overflow-hidden aspect-16/8'>
    <!-- Item 1 -->
    <div class='carousel-item hidden duration-700 ease-in-out bg-white'>
      <section class='px-2 py-4 flex justify-center items-center font-extrabol h-full bg-white'>
        <h2 class='flex justify-center flex-col text-center'>
          <span class='text-5xl sm:text-7xl md:text-8xl font-bold'>Bienvenidos</span>
          <span>
            <span class='text-xl sm:text-2xl md:text-3xl font-normal'>a nuestra</span>
            <span class='text-red-mary font-extralight italic text-4xl'>plataforma</span>
          </span>
        </h2>
      </section>
    </div>

    <!-- Item 2 -->
    <div class='carousel-item hidden duration-700 ease-in-out'>
      <img src='../../src/assets/images/banner-1.jpg' class='absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2' />
    </div>

    <!-- Item 3 -->
    <div class='carousel-item hidden duration-700 ease-in-out'>
      <img src='../../src/assets/images/banner-2.jpg' class='absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2' />
    </div>
  </div>

  <!-- Slider indicators -->
  <div class='absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse'>
    <button id='carousel-item-indicator-0' type='button' class='w-3 h-3 rounded-full' aria-current='true' aria-label='Slide 0'></button>
    <button id='carousel-item-indicator-1' type='button' class='w-3 h-3 rounded-full' aria-current='false' aria-label='Slide 1'></button>
    <button id='carousel-item-indicator-2' type='button' class='w-3 h-3 rounded-full' aria-current='false' aria-label='Slide 2'></button>
  </div>

  <!-- Slider controls -->
  <button type='button' class='absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none' id='data-carousel-prev'>
    <span class='inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none'>
      <svg class='w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180' aria-hidden='true' xmlns='http://www.w3.org/3000/svg' fill='none' viewBox='0 0 6 10'>
        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 1 1 5l4 4'></path>
      </svg>
      <span class='sr-only'>Previous</span>
    </span>
  </button>
  <button type='button' class='absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none' id='data-carousel-next'>
    <span class='inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none'>
      <svg class='w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 6 10'>
        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 9 4-4-4-4'></path>
      </svg>
      <span class='sr-only'>Next</span>
    </span>
  </button>
</div>

<section class='p-4 md:flex md:flex-row md:justify-between md:[&>div]:w-1/2 md:[&>div]:px-6 lg:[&>div]:px-12'>
  <div>
    <!-- <h2 class="text-2xl text-center pt-3">Propósito, Misión y Visión</h2> -->
    <div class='mb-4 border-b border-gray-200'>
      <ul class='flex flex-wrap -mb-px text-sm font-medium text-center' id='tabs-proposito-mision-vision' data-tabs-toggle='#tabs-proposito-mision-vision-tab-content' role='tablist'>
        <li class='w-1/3' role='presentation'>
          <button class='inline-block text-black p-4 border-b-2 rounded-t-lg' id='proposito-tab' data-tabs-target='#proposito' type='button' role='tab' aria-controls='proposito' aria-selected='false'>
            Propósito
          </button>
        </li>
        <li class='w-1/3' role='presentation'>
          <button class='inline-block text-black p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300' id='mision-tab' data-tabs-target='#mision' type='button' role='tab' aria-controls='mision' aria-selected='false'>
            Misión
          </button>
        </li>
        <li class='w-1/3' role='presentation'>
          <button class='inline-block text-black p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-30' id='vision-tab' data-tabs-target='#vision' type='button' role='tab' aria-controls='vision' aria-selected='false'>
            Visión
          </button>
        </li>
      </ul>
    </div>
    <div>
      <div class='hidden p-4 rounded-lg' id='proposito' role='tabpanel' aria-labelledby='proposito-tab'>
        <p class='text-sm lg:text-lg text-gray-500'>
          Producir y desarrollar productos alimenticios de alta calidad para
          garantizar la satisfacción de todos los consumidores.
        </p>
      </div>
      <div class='hidden p-4 rounded-lg' id='mision' role='tabpanel' aria-labelledby='mision-tab'>
        <p class='text-sm lg:text-lg text-gray-500'>
          Somos una empresa que desarrolla, elabora y distribuye alimentos reconocidos por su calidad, sustentados en innovación, esfuerzo y profesionalismo que contribuye al bienestar de sus trabajadores y la familia venezolana.
        </p>
      </div>
      <div class='hidden p-4 rounded-lg' id='vision' role='tabpanel' aria-labelledby='vision-tab'>
        <p class='text-sm lg:text-lg text-gray-500'>
          Ser lideres del mercado de los productos que elaboramos y distribuimos, a nivel nacional con proyección internacional, conservando la cultura familiar de nuestra empresa.
        </p>
      </div>
    </div>
  </div>

  <div>
    <h2 class='text-2xl text-center font-bold py-2'>Video corporativo</h2>
    <iframe class='w-full aspect-video' src='https://www.youtube.com/embed/I6U2Byc76j0'></iframe>
  </div>
</section>

<section class='p-4 flex flex-col justify-center items-center md:flex-row md:justify-between md:[&>div]:w-1/3 md:[&>a]:w-1/3'>
  <div class='max-w-sm rounded overflow-hidden shadow-lg text-center my-4'>
    <span class='inline-block py-3 text-center text-red-mary'><i class='fa-solid fa-list-ol text-7xl'></i></span>
    <div class='px-6 py-4'>
      <div class='font-bold text-xl mb-2'>Cumplimientos</div>
      <p class='text-gray-700 text-base'>
        <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus
        quia, nulla! Maiores et perferendis eaque, exercitationem praesentium
        nihil. -->
      </p>
    </div>
  </div>

  <a href='../promociones/' class='max-w-sm rounded overflow-hidden shadow-lg text-center my-4'>
    <span class='inline-block py-3 text-center text-red-mary'><i class='fa-solid fa-bullhorn text-7xl'></i></span>
    <div class='px-6 py-4'>
      <div class='font-bold text-xl mb-2'>Promociones</div>
      <p class='text-gray-700 text-base'>
        <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus
        quia, nulla! Maiores et perferendis eaque, exercitationem praesentium
        nihil. -->
      </p>
    </div>
  </a>

  <a href='../cumpleaños/' class='max-w-sm rounded overflow-hidden shadow-lg text-center my-4'>
    <span class='inline-block py-3 text-center text-red-mary'><i class='fa-solid fa-cake-candles text-7xl'></i></span>
    <div class='px-6 py-4'>
      <div class='font-bold text-xl mb-2'>Cumpleaños</div>
      <p class='text-gray-700 text-base'>
        <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus
        quia, nulla! Maiores et perferendis eaque, exercitationem praesentium
        nihil. -->
      </p>
    </div>
  </a>
</section>

<section class='min-h-[60vh] px-2 py-4 grid grid-cols-1 bg-blue-400 md:grid-cols-2 lg:grid-cols-4'>
  <div class='flex flex-col justify-center items-center text-white py-4 my-5'>
    <i class='fa-solid fa-chart-line text-7xl pb-4'></i>
    <span class='text-4xl font-bold mb-2'>9000</span>
    <p class='text-2xl'>Producción</p>
  </div>

  <div class='flex flex-col justify-center items-center text-white py-4 my-5'>
    <i class='fa-solid fa-ruler text-7xl pb-4'></i>
    <span class='text-4xl font-bold mb-2'>96</span>
    <p class='text-2xl'>Hectáreas sembradas</p>
  </div>

  <div class='flex flex-col justify-center items-center text-white py-4 my-5'>
    <i class='fa-solid fa-hand-holding-dollar text-7xl pb-4'></i>
    <span class='text-4xl font-bold mb-2'>1500</span>
    <p class='text-2xl'>Ventas mensuales</p>
  </div>

  <div class='flex flex-col justify-center items-center text-white py-4 my-5'>
    <i class='fa-solid fa-user-group text-7xl pb-4'></i>
    <span class='text-4xl font-bold mb-2'>1400</span>
    <p class='text-2xl'>Clientes atendidos</p>
  </div>
</section>

<section class='p-4 pb-24 grid grid-cols-1 lg:grid-cols-2 bg-red-mary min-h-[20vh]'>
  <div class='my-8 w-full flex flex-col justify-center items-center text-white text-center'>
    <h2 class='text-white text-3xl text-center py-3 font-bold'>Contacto</h2>
    <span class='block py-1'>Para comunicarte con nosotros</span>

    <span class='block py-1'>Llámanos al
      <a class='font-extrabold italic inline-block' target='_blank' href='tel:+582123075435'>+58 2123075435</a>
      /
      <a class='font-extrabold italic inline-block' target='_blank' href='tel:+582129939035'>+58 2129939035</a>
    </span>
    <span class='block py-1'>Escríbenos por correo electrónico al:
      <a class='font-extrabold italic inline-block' target='_blank' href='mailto:info@alimentosmary.com'>info@alimentosmary.com</a></span>
    <span class='block py-1'>Solo Whatsapp:
      <a class='font-extrabold italic inline-block' target='_blank' href='https://wa.me/+584120468457'>+58 4120468457</a></span>
  </div>

  <div class='my-8 w-full flex flex-col justify-center items-center'>
    <h2 class='text-white text-3xl text-center py-3 font-bold'>Ubicación</h2>
    <div class='relative w-full h-96'>
      <iframe class='absolute top-0 left-0 w-full h-full rounded-xl z-0' src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15739.152583714029!2d-69.2482001!3d9.527127!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e7dc0d3c63381f5%3A0xa77a0c2cad9e972e!2sMary%20Iancarina!5e0!3m2!1ses-419!2sve!4v1700116413468!5m2!1ses-419!2sve' frameborder='0' style='border: 0' allowfullscreen='' aria-hidden='false' tabindex='0'>
      </iframe>
    </div>
  </div>
</section>