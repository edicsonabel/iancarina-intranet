<header>
  <div class='bg-red-mary flex justify-center h-[3.5rem]'>
    <img class='aspect-[625/169]' src='./../../src/assets/images/alimentos-mary.webp' alt='Alimentos Mary' />
  </div>
  <nav class='shadow fixed bottom-4 left-0 right-0 z-50 md:relative md:bottom-0'>
    <ul class='bg-white w-100 text-black mx-3 py-2 rounded-3xl flex flex-row justify-center items-center text-2xl overflow-hidden [&>li]:w-1/6 [&>li>button]:h-16 [&>li>a]:h-16 [&>li>a]:flex [&>li>a]:flex-col [&>li>a]:justify-center [&>li>a]:items-center [&>li>a]:overflow-hidden [&>li>a>span]:text-xs [&>li>button]:text-xs md:mx-0 md:rounded-none md:[&>li>a>span]:text-xl md:[&>li>button]:text-xl'>
      <li class='md:flex md:justify-center'>
        <a class='w-full' href='../inicio/' title='Inicio'>
          <img class='hidden md:inline-block w-4/6' src='./../../src/assets/images/logo-mary-iancarina-negro.png' alt='Logo Alimentos Mary' />
          <i class='md:hidden fa-solid fa-house'></i>
          <span class='md:hidden'>Inicio</span>
        </a>
      </li>

      <li>
        <a href='http://www.iancarina.com.ve/extensions/' target='_blank' title='Directorio telefónico'>
          <i class=' md:hidden fa-solid fa-users'></i>
          <span>Dir. Telefónico</span>
        </a>
      </li>

      <li>
        <a href='../inicio/#novedades' title='Novedades' class='scroll-to' data-scrollto='#novedades'>
          <i class='md:hidden fa-regular fa-newspaper'></i>
          <span>Novedades</span>
        </a>
      </li>

      <li>
        <a href='https://mail.alimentosmary.org/' target='_blank' title='Correo corporativo'>
          <i class='md:hidden fa-regular fa-envelope'></i>
          <span>Correo</span>
        </a>
      </li>

      <li>
        <button id='ddAppsButton' data-dropdown-toggle='ddApps' data-dropdown-trigger='hover' class='w-full text-black focus:outline-none justify-center text-center inline-flex items-center' type='button'>
          Apps
          <svg class='w-2.5 h-2.5 ms-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 10 6'>
            <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 4 4 4-4' />
          </svg>
        </button>

        <div id='ddApps' class='focus:border-red-mary z-10 hidden bg-white divide-y divide-white rounded-lg shadow w-44
        [&>ul]:py-2 [&>ul]:text-sm [&>ul]:text-black [&>ul>span]:px-3 [&>ul>span]:opacity-60 [&>ul>li>a]:block [&>ul>li>a]:px-4 [&>ul>li>a]:py-2 max-h-[75dvh] overflow-y-auto scrollable-light'>

          <ul>
            <span>Adempiere</span>
            <li>
              <a class='hover:bg-slate-200' href='http://adempiere-ianca.iancarina.com.ve/webui/' target=_blank>Adempiere Ianca</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://vmadempierezenith:55881/webui/' target=_blank>Adempiere Inalsa</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://adempiere.corisa.local/webui/' target=_blank>Adempiere Corisa</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://adempiere.iancarina.com.ve/webui/' target=_blank>Adempiere Iancarina</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://adempiere-promotora.iancarina.com.ve/webui/' target=_blank>Adempiere Promotoras G&D</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://www.iancarina.com.ve/corporacionmary/' target=_blank>SIC Mary</a>
            </li>
          </ul>

          <ul>
            <li>
              <a class='hover:bg-slate-200' href='http://vmserverapp:8888/jasperserver/login.html' target=_blank>Jaspersoft</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://www.iancarina.com.ve/owncloud/' target=_blank>OwnCloud</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://vmpowerbimary/PBIReports' target=_blank>Power BI</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://vmserverapp:8280/OpenKM/login.jsp' target=_blank>OpenKM</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://www.iancarina.com.ve/Intranet/mary/php/sistemaserp.php'>Sistemas ERP</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://www.iancarina.com.ve/wiki/' target=_blank>Wiki</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://www.iancarina.com.ve/eLearning/' target=_blank>e-Learning</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='https://onedrive.live.com/about/es-es/signin/' target=_blank>OneDrive</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://intranet-venta.iancarina.com.ve:8050/' target=_blank>Venta Iancarina</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='https://cloud.alimentosmary.org/login' target=_blank>NextCloud</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='https://solicitudes.iancarina.com.ve/HomePage.do?logout=true' target=_blank>Solicitudes TI</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='#'>Solicitudes Legal</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='#'>Tienda</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='http://www.iancarina.com.ve/Intranet/src/Camaras.php' target=_blank>Cámaras</a>
            </li>
          </ul>
        </div>
      </li>

      <li>
        <button id='ddNovedadesDepButton' data-dropdown-toggle='ddNovedadesDep' data-dropdown-trigger='hover' class='w-full text-black focus:outline-none justify-center text-center inline-flex items-center' type='button'>
          Novedades por area
          <svg class='w-2.5 h-2.5 ms-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 10 6'>
            <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 4 4 4-4' />
          </svg>
        </button>

        <div id='ddNovedadesDep' class='z-10 hidden bg-white divide-y divide-gray-400 rounded-lg shadow w-44
        [&>ul]:py-2 [&>ul]:text-sm [&>ul]:text-black [&>ul>span]:px-3 [&>ul>span]:opacity-60 [&>ul>li>a]:block [&>ul>li>a]:px-4 [&>ul>li>a]:py-2 scrollable-light'>
          <ul>
            <li>
              <a class='hover:bg-slate-200' href='../novedades-legal/'>Legal</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='../novedades-rrhh/'>Recursos Humanos</a>
            </li>
            <li>
              <a class='hover:bg-slate-200' href='../novedades-tecnologia/'>Tecnología</a>
            </li>
          </ul>
        </div>
      </li>

      <!-- <li>
        <button id='ddRecursosDepButton' data-dropdown-toggle='ddRecursosDep' data-dropdown-trigger='hover' class='w-full text-black focus:outline-none justify-center text-center inline-flex items-center' type='button'>
          Recursos
          <svg class='w-2.5 h-2.5 ms-3' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 10 6'>
            <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 1 4 4 4-4' />
          </svg>
        </button>

        <div id='ddRecursosDep' class='z-10 hidden bg-white-500 divide-y divide-black-400 rounded-lg shadow w-44
        [&>ul]:py-2 [&>ul]:text-sm [&>ul]:text-white [&>ul>span]:px-3 [&>ul>span]:opacity-60 [&>ul>li>a]:block [&>ul>li>a]:px-4 [&>ul>li>a]:py-2 scrollable-light'>
          <ul>
            <li>
              <a class='bg-white' href='../recursos-legal/'>Legal</a>
            </li>
            <li>
              <a class='bg-white' href='../recursos-rrhh/'>Recursos Humanos</a>
            </li>
            <li>
              <a class='bg-white' href='../recursos-tecnologia/'>Tecnología</a>
            </li>
          </ul>
        </div>
      </li> -->
    </ul>
  </nav>
</header>