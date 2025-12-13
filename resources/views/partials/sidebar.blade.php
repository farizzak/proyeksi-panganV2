<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-start'"
    class="flex items-center gap-3 pt-8 pb-7 sidebar-header transition-all duration-300"
  >
    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
      <!-- Logo -->
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img
          class="dark:hidden w-12 h-auto"
          src="{{ asset('tailadmin/images/logo/logo_kotaSemarang.png') }}"
          alt="Logo"
        />
        <img
          class="hidden dark:block w-12 h-auto"
          src="{{ asset('tailadmin/images/logo/logo_kotaSemarang.png') }}"
          alt="Logo"
        />
      </span>

      <!-- Logo Icon (collapse mode) -->
      <img
        class="logo-icon w-9 h-auto"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="{{ asset('tailadmin/images/logo/logo_kotaSemarang.png') }}"
        alt="Logo Icon"
      />

      <!-- Text beside logo -->
      <span
        class="text-xl font-semibold text-gray-800 dark:text-gray-200 tracking-wide"
        :class="sidebarToggle ? 'hidden' : 'block'"
      >
        SIKETAN
      </span>
    </a>
  </div>
  <!-- END SIDEBAR HEADER -->

  <!-- SIDEBAR MENU -->
  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    @php
      $masterActive = request()->is('roles*') || request()->is('users*') || request()->is('kategori*') || request()->is('komoditas*');
      $transaksiActive = request()->is('ketersediaan*') || request()->is('rekap*') || request()->is('bahanpokok*');
      $initialSelected = $masterActive ? 'Master' : ($transaksiActive ? 'Transaksi Data' : 'Dashboard');
    @endphp

    <nav x-data="{ selected: @js($initialSelected) }">
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
            Menu
          </span>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- DASHBOARD -->
          <li>
            <a
              href="{{ url('/dashboard') }}"
              @click="page = 'Dashboard'"
              class="menu-item group"
              :class="[
                (page === 'Dashboard' || '{{ request()->is('dashboard') ? 'true' : 'false' }}' === 'true')
                  ? 'menu-item-active'
                  : 'menu-item-inactive'
              ]"
            >
              <!-- Icon: Home / Dashboard -->
              <svg
                :class="(page === 'Dashboard' || '{{ request()->is('dashboard') ? 'true' : 'false' }}' === 'true')
                  ? 'menu-item-icon-active'
                  : 'menu-item-icon-inactive'"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 9.75l8.485-6.364a1.5 1.5 0 0 1 1.83 0L21.8 9.75M4.5 9.75V20.25a.75.75 0 0 0 .75.75H9.75v-4.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v4.5h4.5a.75.75 0 0 0 .75-.75V9.75"
                />
              </svg>

              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                Dashboard
              </span>
            </a>
          </li>
          <!-- END DASHBOARD -->

          <!-- MASTER -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Master' ? '' : 'Master')"
              class="menu-item group"
              :class="(selected === 'Master') || (page === 'Role') || (page === 'User') || (page === 'Kategori') || (page === 'Komoditas') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <!-- Icon: Folder / Master -->
              <svg
                :class="(selected === 'Master') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 7.5V6a1.5 1.5 0 011.5-1.5h5.379a1.5 1.5 0 011.06.44l1.56 1.56A1.5 1.5 0 0013.56 7.5H19.5A1.5 1.5 0 0121 9v9a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 18V7.5z"
                />
              </svg>

              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                Master Data
              </span>

              <!-- Arrow -->
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Master') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- DROPDOWN -->
            <div class="overflow-hidden transform translate" :class="(selected === 'Master') ? 'block' : 'hidden'">
              <ul class="flex flex-col gap-1 mt-2 menu-dropdown pl-9" :class="sidebarToggle ? 'lg:hidden' : 'flex'">
                <li>
                  <a 
                    href="{{ route('roles.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('roles*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Role
                  </a>
                </li>
                <li>
                  <a 
                    href="{{ route('users.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('users*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    User
                  </a>
                </li>
                <li>
                  <a 
                    href="{{ route('kategori.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('kategori*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Kategori
                  </a>
                </li>
                <li>
                  <a 
                    href="{{ route('komoditas.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('komoditas*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Komoditas
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <!-- END MASTER -->

          <!-- TRANSAKSI DATA -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Transaksi Data' ? '' : 'Transaksi Data')"
              class="menu-item group"
              :class="(selected === 'Transaksi Data') ? 'menu-item-active' : 'menu-item-inactive'"
            >
              <!-- Icon: Document / Transaction -->
              <svg
                :class="(selected === 'Transaksi Data') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M7.5 3h9A1.5 1.5 0 0118 4.5v15a1.5 1.5 0 01-1.5 1.5h-9A1.5 1.5 0 016 19.5v-15A1.5 1.5 0 017.5 3zM9 8.25h6M9 12h6m-6 3.75h3"
                />
              </svg>

              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                Transaksi Data
              </span>

              <!-- Arrow -->
              <svg
                class="menu-item-arrow"
                :class="[(selected === 'Transaksi Data') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </a>

            <!-- DROPDOWN -->
            <div class="overflow-hidden transform translate" :class="(selected === 'Transaksi Data') ? 'block' : 'hidden'">
              <ul class="flex flex-col gap-1 mt-2 menu-dropdown pl-9" :class="sidebarToggle ? 'lg:hidden' : 'flex'">
                <li>
                  <a 
                    href="{{ route('ketersediaan.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('ketersediaan*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Proyeksi Ketersediaan
                  </a>
                </li>
                <li>
                  <a 
                    href="{{ route('rekap.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('rekap*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Rekap Ketersediaan
                  </a>
                </li>
                <li>
                  <a 
                    href="{{ route('bahanpokok.index') }}" 
                    class="menu-dropdown-item group {{ request()->is('bahanpokok*') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Scrapping Data Siharpa
                  </a>
                </li>
              </ul>
            </div>
          </li>
          <!-- END TRANSAKSI DATA -->
        </ul>
      </div>
    </nav>
  </div>
  <!-- END SIDEBAR MENU -->
</aside>
