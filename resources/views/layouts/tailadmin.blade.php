<!doctype html>
<html lang="en"
      x-data="{ page: 'ecommerce', loaded: true, darkMode: false, stickyMenu: false, sidebarToggle: false, scrollTop: false }"
      x-init="
          darkMode = JSON.parse(localStorage.getItem('darkMode'));
          $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
      "
      :class="{'dark bg-gray-900': darkMode === true}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>@yield('title', 'Dashboard | TailAdmin')</title>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">

        {{-- ✅ Laravel Mix hasil build --}}
        <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    </head>

    <body>
        @include('partials.preloader')

        <div class="flex h-screen overflow-hidden">
            @include('partials.sidebar')

            <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
                @include('partials.overlay')
                @include('partials.header')

                <main>
                    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                        @if(session('success'))
                            <div x-data="{ show: true }" 
                                x-show="show" 
                                x-init="setTimeout(() => show = false, 3000)" 
                                class="mb-4 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                                <strong class="font-semibold">Success!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div x-data="{ show: true }" 
                                x-show="show" 
                                x-init="setTimeout(() => show = false, 3000)" 
                                class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                                <strong class="font-semibold">Error!</strong> {{ session('error') }}
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        
       <script src="{{ mix('js/app.js') }}"></script>

        {{-- ✅ jQuery dan DataTables --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

        {{-- ✅ SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('scripts')
    </body>
</html>

