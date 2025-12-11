@extends('layouts.tailadmin')

@section('title', 'Data Bahan Pokok')

@push('styles')
  <style>
    /* (Saya pakai styling CSS yang kamu kirim, sedikit dirapikan) */
    #dataTable_wrapper .dataTables_filter,
    #dataTable_wrapper .dataTables_length,
    #dataTable_wrapper .dataTables_info,
    #dataTable_wrapper .dataTables_paginate {
      float: none !important;
      width: auto;
    }

    #dataTable td.dataTables_empty {
      text-align: center !important;
      vertical-align: middle !important;
      padding: 2rem 0 !important;
      font-size: 14px;
      color: rgb(75 85 99) !important;
    }
    html.dark #dataTable td.dataTables_empty { color: rgb(209 213 219) !important; }

    #dataTable_wrapper .dt-topbar{
      width:100%; display:flex; align-items:center; gap:.75rem; flex-wrap:wrap;
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

    #dataTable_wrapper .dt-topbar .ml-auto{ margin-left:auto; }
    #dataTable_wrapper .dt-bottombar .ml-auto{ margin-left:auto; }

    #dataTable_wrapper .dt-bottombar{
      width:100%; display:flex; align-items:center; gap:1rem; flex-wrap:wrap;
    }
    #dataTable_wrapper .dataTables_info { font-size:.875rem; color:rgb(75 85 99); }
    html.dark #dataTable_wrapper .dataTables_info { color:rgb(209 213 219); }

    #dataTable_wrapper .dataTables_paginate{ display:flex; align-items:center; gap:.25rem; }
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

    #dataTable tbody tr { transition: background-color .15s ease; }
    #dataTable tbody tr:hover { background-color:rgb(249 250 251); }
    html.dark #dataTable tbody tr:hover { background-color:rgb(31 41 55); }

    /* kecilkan input date agar rapi */
    input[type="date"] {
      padding:.5rem .6rem; border:1px solid rgb(229 231 235); border-radius:.5rem; background:transparent;
    }
    html.dark input[type="date"] { border-color: rgb(55 65 81); color: rgb(243 244 246); }
  </style>
@endpush

@section('content')
  <div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800 mb-6">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Data Bahan Pokok</h2>

      <!-- Form POST untuk menyimpan data ke DB (scrapeData) -->
      <form id="formSave" action="{{ route('bahanpokok.scrape') }}" method="POST" class="inline-block">
        @csrf
        <input type="hidden" name="from" id="save_from">
        <input type="hidden" name="to" id="save_to">
        <button type="submit"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
          <i class="fa-solid fa-plus"></i>
          Simpan Data
        </button>
      </form>
    </div>

    <div class="grid grid-cols-1 gap-6">
      <!-- FILTER (Tanggal Dari - Sampai) -->
      <div class="mb-4 flex flex-wrap items-end gap-3">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
          <input type="date" id="fromDate" class="px-3 py-2 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
          <input type="date" id="toDate" class="px-3 py-2 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100" />
        </div>

        <button id="btnFilter" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Filter</button>
        <button id="btnReset" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">Reset</button>
      </div>

      <!-- TABLE -->
      <div>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-4">
          <div class="overflow-x-auto">
            <table id="dataTable" class="min-w-full text-sm">
              <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <tr>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">No.</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Bahan Pokok</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Satuan</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Harga Tanggal 1</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Harga Tanggal 2</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Persentase</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-800"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal (tetap ada bila nanti perlu) -->
  <div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center bg-black/50 hidden">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg w-full max-w-md p-6">
      <div class="text-center space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Delete Confirmation</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Are you sure you want to delete this ?</p>
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
  // CSRF untuk semua request jQuery (sudah ada di project sebelumnya)
  $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

  $(document).ready(function () {
    // default tanggal: yesterday - today (format input date: YYYY-MM-DD)
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);

    function toYMD(d) {
      const mm = String(d.getMonth() + 1).padStart(2,'0');
      const dd = String(d.getDate()).padStart(2,'0');
      return `${d.getFullYear()}-${mm}-${dd}`;
    }

    // Set default values on date inputs
    $('#fromDate').val(toYMD(yesterday));
    $('#toDate').val(toYMD(today));

    // Convert YYYY-MM-DD -> d-m-Y (controller expects d-m-Y)
    function formatToDMY(isoDate) {
      if (!isoDate) return '';
      const [y,m,d] = isoDate.split('-');
      return `${d}-${m}-${y}`;
    }

    // Sync hidden inputs for Save form
    function syncSaveInputs() {
      $('#save_from').val(formatToDMY($('#fromDate').val()));
      $('#save_to').val(formatToDMY($('#toDate').val()));
    }

    syncSaveInputs(); // initial

    // Reload table on filter
    $('#btnFilter').on('click', function () {
      table.ajax.reload();
      syncSaveInputs();
    });

    $('#btnReset').on('click', function () {
      $('#fromDate').val(toYMD(yesterday));
      $('#toDate').val(toYMD(today));
      table.ajax.reload();
      syncSaveInputs();
    });

    // Inisialisasi DataTable
    const table = $('#dataTable').DataTable({
      processing: true,
      serverSide: false, // serverSide false karena scrapeAjax mengembalikan array data langsung
      ajax: {
        url: "{{ route('bahanpokok.scrapeAjax') }}",
        type: "POST",
        data: function (d) {
          // kirim format yang controller ekspektasi (d-m-Y)
          d.from = formatToDMY($('#fromDate').val());
          d.to   = formatToDMY($('#toDate').val());
        },
        dataSrc: function (json) {
          // jika terjadi error dari server, tampilkan pesan di console dan kembalikan array kosong
          if (json.error) {
            console.error('Scrape error:', json.error);
            return [];
          }
          return json.data || [];
        }
      },
      columns: [
        {
          data: null,
          orderable: false,
          searchable: false,
          className: 'px-4 py-3',
          render: function (data, type, row, meta) {
            return meta.row + 1 + meta.settings._iDisplayStart;
          }
        },
        { data: 'bahan_pokok', name: 'bahan_pokok', className: 'px-4 py-3' },
        { data: 'satuan', name: 'satuan', className: 'text-center px-4 py-3' },
        { data: 'harga_tanggal_1', name: 'harga_tanggal_1', className: 'text-center px-4 py-3' },
        { data: 'harga_tanggal_2', name: 'harga_tanggal_2', className: 'text-center px-4 py-3' },
        { data: 'persentase', name: 'persentase', className: 'text-center px-4 py-3' },
        {
            data: 'keterangan',
            name: 'keterangan',
            className: 'text-center px-4 py-3',
            render: function(data) {
                let badgeClass = '';
                let label = data ?? '-';

                switch (data?.trim()) { // ← trim biar tidak error spasi
                    case 'Turun':
                        badgeClass = 'bg-green-500 text-white';
                        break;
                    case 'Naik':
                        badgeClass = 'bg-red-500 text-white';
                        break;
                    default:
                        badgeClass = 'bg-yellow-500 text-white';
                }

                return `
                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${badgeClass}"
                          style="${badgeClass.includes('bg-yellow') ? 'background:#facc15;color:#ffffff;' : ''}">
                        ${label}
                    </span>
                `;
            }
        }


      ],
      order: [[0, 'asc']],
      responsive: true,
      stateSave: false,
      pageLength: 10,
      lengthMenu: [[10,25,50,100],[10,25,50,100]],
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
      initComplete: function () {
        const $w = $('#dataTable_wrapper');
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

    // Jika user klik Submit Simpan Data, sinkronkan tanggal (sebelum form submit)
    $('#formSave').on('submit', function (e) {
      syncSaveInputs();
      // biarkan form submit (server akan redirect kembali)
    });

  });
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
@endpush
