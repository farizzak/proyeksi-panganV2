@extends('layouts.tailadmin')

@section('title', 'Ketersediaan')


@push('styles')
  <style>
    /* Matikan float default DataTables agar flex bisa bekerja */
    #dataTable_wrapper .dataTables_filter,
    #dataTable_wrapper .dataTables_length,
    #dataTable_wrapper .dataTables_info,
    #dataTable_wrapper .dataTables_paginate {
      float: none !important;
      width: auto;
    }

    /* BAR ATAS: search kiri, length kanan (via .ml-auto wrapper) */

    #dataTable td.dataTables_empty {
        text-align: center !important;
        vertical-align: middle !important;
        padding: 2rem 0 !important;
        font-size: 14px;
        color: rgb(75 85 99) !important; /* gray-600 */
    }

    html.dark #dataTable td.dataTables_empty {
        color: rgb(209 213 219) !important; /* gray-300 */
    }


    #dataTable_wrapper .dt-topbar{
      width:100%;
      display:flex; align-items:center; gap:.75rem; flex-wrap:wrap;
    }
    #dataTable_wrapper .dt-topbar .dataTables_filter label{
      display:flex; align-items:center; gap:.5rem;
    }
    #dataTable_wrapper .dt-topbar .dataTables_filter input{
      padding:.5rem .75rem; border-width:1px; border-radius:.5rem; outline:none;
      border-color:rgb(229 231 235); background:transparent; color:rgb(31 41 55);
      width:16rem;
    }
    html.dark #dataTable_wrapper .dt-topbar .dataTables_filter input{
      border-color:rgb(55 65 81); color:rgb(243 244 246); background-color:rgb(17 24 39);
    }

    /* Dorong container length & paginate ke kanan */
    #dataTable_wrapper .dt-topbar .ml-auto{ margin-left:auto; }
    #dataTable_wrapper .dt-bottombar .ml-auto{ margin-left:auto; }

    /* BAR BAWAH: info kiri, paginate kanan */
    #dataTable_wrapper .dt-bottombar{
      width:100%;
      display:flex; align-items:center; gap:1rem; flex-wrap:wrap;
    }
    #dataTable_wrapper .dataTables_info { font-size:.875rem; color:rgb(75 85 99); }
    html.dark #dataTable_wrapper .dataTables_info { color:rgb(209 213 219); }

    #dataTable_wrapper .dataTables_paginate{
      display:flex; align-items:center; gap:.25rem;
    }
    #dataTable_wrapper .dataTables_paginate .paginate_button{
      padding:.375rem .625rem; border-radius:.5rem; border:1px solid rgb(229 231 235);
      background:transparent; color:rgb(31 41 55) !important; cursor:pointer; font-size:.875rem;
    }
    #dataTable_wrapper .dataTables_paginate .paginate_button.current,
    #dataTable_wrapper .dataTables_paginate .paginate_button:hover{
      background: rgb(59 130 246 / .08); border-color: rgb(59 130 246);
      color: rgb(59 130 246) !important;
    }
    html.dark #dataTable_wrapper .dataTables_paginate .paginate_button{
      border-color:rgb(55 65 81); color:rgb(243 244 246) !important;
    }
    html.dark #dataTable_wrapper .dataTables_paginate .paginate_button.current,
    html.dark #dataTable_wrapper .dataTables_paginate .paginate_button:hover{
      background: rgb(59 130 246 / .18); border-color: rgb(59 130 246); color: rgb(191 219 254) !important;
    }

    /* Hover row */
    #dataTable tbody tr { transition: background-color .15s ease; }
    #dataTable tbody tr:hover { background-color:rgb(249 250 251); }
    html.dark #dataTable tbody tr:hover { background-color:rgb(31 41 55); }

    .toggle-bg {
      position: relative;
      transition: all .3s;
    }
    .toggle-bg::after {
      content: '';
      position: absolute;
      top: 2px;
      left: 2px;
      width: 20px;
      height: 20px;
      background: white;
      border-radius: 999px;
      transition: all .3s;
    }
    input:checked + .toggle-bg {
      background-color: rgb(59 130 246); /* blue */
    }
    input:checked + .toggle-bg::after {
      transform: translateX(20px);
    }

  </style>
@endpush

@section('content')
  <div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800 mb-6">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Ketersediaan</h2>

      <a href="{{ route('ketersediaan.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600 transition">
        <i class="fa-solid fa-plus"></i>
        Tambah Ketersediaan
      </a>
    </div>


    <!-- Grid Layout -->
    <div class="grid grid-cols-1 gap-6">

      <!-- FILTER SECTION -->
      <div class="mb-4 flex flex-wrap items-end gap-3">

        <!-- Pilih Tahun -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
          <select id="filterYear"
                  class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
            <option value="">-- Pilih Tahun --</option>
            @foreach(range(date('Y')-5, date('Y')+1) as $y)
              <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>
        </div>

        <!-- Pilih Bulan -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bulan</label>
          <select id="filterMonth"
                  class="px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
            <option value="">-- Pilih Bulan --</option>
            @foreach(range(1,12) as $m)
              <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
            @endforeach
          </select>
        </div>

        <button id="btnFilter" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg">
          Filter
        </button>

        <button id="btnReset" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">
          Reset
        </button>

      </div>

      <!-- TABLE SECTION -->
      <div>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-4">
          <div class="overflow-x-auto">
            <table id="dataTable" class="min-w-full text-sm">
              <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <tr>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">No.</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Tanggal</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-800"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center bg-black/50 hidden">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg w-full max-w-md p-6">
      <div class="text-center space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Delete Confirmation</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Are you sure you want to delete this Ketersediaan?</p>
      </div>
      <div class="mt-6 flex justify-end gap-3">
        <button type="button" id="cancelDelete"
          class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg">
          Cancel
        </button>
        <form id="delform" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
  // CSRF global untuk semua request jQuery
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

  $(document).ready(function () {
    const baseUrl = "{{ url('ketersediaan') }}";
    const $form   = $('#myform');
    const $submit = $('#myform button[type="submit"]');
    const $method = $('#method');
    const $title  = $('#formtitle');

    $('#btnFilter').on('click', function () {
      table.ajax.reload();
    });

    $('#btnReset').on('click', function () {
      $('#filterYear').val('');
      $('#filterMonth').val('');
      table.ajax.reload();
    });


    // Inisialisasi DataTable
    const table = $('#dataTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
          url  : "{{ route('ketersediaan.index') }}",
          data : function (d) {
            d.year  = $('#filterYear').val();
            d.month = $('#filterMonth').val();
          }
      },
      columns: [
        { 
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false,
          className: 'px-4 py-3'
        },
        { 
          data: 'tanggal',
          name: 'tanggal',
          className: 'px-4 py-3'
        },
        { 
          data: 'id',
          orderable: false,
          searchable: false,
          className: 'px-4 py-3 text-center',
          render: function(id, type, row) {
            return `
              <div class="flex justify-center gap-3">
                <a href="/ketersediaan/${id}/edit" 
                  class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                  <i class="fa-solid fa-pen"></i>
                </a>

                <button class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                        data-id="${id}">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            `;
          }
        }
      ],

      order: [[0, 'asc']],
      responsive: true,
      stateSave: true,
      scrollY: false,
      pageLength: 10,
      lengthMenu: [[10,25,50,100],[10,25,50,100]],

      // === KUNCI POSISI: Search kiri, Length kanan; Info kiri, Paginate kanan
      dom: '<"dt-topbar d-flex items-center gap-3"f<"ml-auto"l>>'
        + '<"datatable-scroll"t>'
        + '<"dt-bottombar d-flex items-center"i<"ml-auto"p>>',


      language: {
        search: 'Search:',
        searchPlaceholder: 'Type to search...',
        lengthMenu: 'Show: _MENU_',
        processing: 'Loading...',
        paginate: {
          first: 'First', last: 'Last',
          next: $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
          previous: $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
        }
      },

      createdRow: function (row) {
        $(row).addClass('hover:bg-gray-50 dark:hover:bg-gray-800');
      },

      drawCallback: function () {
        const $w = $('#dataTable_wrapper');
        $w.find('.dataTables_info').addClass('text-gray-600 dark:text-gray-300');
        $w.find('.dataTables_paginate').addClass('items-center');
        $w.find('.dataTables_scroll').css('margin-bottom', '1rem');
      },


      initComplete: function () {
        const $w = $('#dataTable_wrapper');
        // kosmetik kecil
        $w.find('.dataTables_filter').addClass('flex items-center gap-2');
        $w.find('.dataTables_length').addClass('flex items-center gap-2');

        // Debounce search
        const $input = $w.find('.dataTables_filter input');
        let t = null;
        $input.off('keyup.DT').on('keyup', function () {
          clearTimeout(t);
          t = setTimeout(() => table.search(this.value).draw(), 300);
        });
      }
    });

    $('#dataTable').on('change', '.status-toggle', function () {
      const id = $(this).data('id');
      const status = $(this).is(':checked') ? 1 : 0;

      $.post(`/ketersediaan/${id}/status`, { status }, function (res) {
        Swal.fire({
          icon: 'success',
          title: res.message,
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1300,
        });
      }).fail(function () {
        Swal.fire('Error', 'Gagal mengubah status', 'error');
      });
    });




    // Delete
    $('#dataTable').on('click', '.delete-btn', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Delete this item?',
            text: 'Ketersediaan akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true
        }).then(result => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: `/ketersediaan/${id}`,
                method: 'DELETE',
                success: function (res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    table.ajax.reload();
                },
                error: function () {
                    Swal.fire('Error', 'Gagal menghapus data', 'error');
                }
            });
        });
    });

  });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
@endpush
