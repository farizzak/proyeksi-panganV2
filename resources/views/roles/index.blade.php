@extends('layouts.tailadmin')

@section('title', 'Role')


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
  </style>
@endpush

@section('content')
  <div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800 mb-6">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Role</h2>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
      <!-- TABLE SECTION -->
      <div class="md:col-span-7">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-4">
          <div class="overflow-x-auto">
            <table id="dataTable" class="min-w-full text-sm">
              <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <tr>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">No.</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Name</th>
                  <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-800"></tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- FORM SECTION -->
      <div class="md:col-span-5">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-6">
          <form id="myform" method="POST" action="{{ route('roles.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="_method" id="method" value="post">

            <h3 id="formtitle" class="text-lg font-semibold text-gray-800 dark:text-gray-100">Add Role</h3>

            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
              <input
                type="text"
                id="name"
                name="name"
                placeholder="Name..."
                required
                class="mt-1 w-full rounded-lg border border-gray-200 bg-transparent px-3 py-2 text-gray-800 
                      placeholder:text-gray-400 outline-none transition-all duration-200
                      focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20
                      dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder:text-gray-500
                      dark:focus:border-brand-400 dark:focus:ring-brand-400/20"
              />
            </div>

            <div class="flex justify-end gap-3 pt-2">
              <button type="button" id="cancelEdit" 
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg
                      dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                Reset
              </button>
              <button type="submit" 
                class="btn-brand-stable px-4 py-2 text-sm font-medium text-white rounded-lg flex items-center gap-1">
                Submit
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center bg-black/50 hidden">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg w-full max-w-md p-6">
      <div class="text-center space-y-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Delete Confirmation</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Are you sure you want to delete this role?</p>
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
    const baseUrl = "{{ url('roles') }}";
    const $form   = $('#myform');
    const $submit = $('#myform button[type="submit"]');
    const $method = $('#method');
    const $title  = $('#formtitle');

    // Inisialisasi DataTable
    const table = $('#dataTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('roles.index') }}",
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,
          className: 'px-4 py-3 text-gray-700 dark:text-gray-200 w-16' },
        { data: 'name', name: 'name', className: 'px-4 py-3 text-gray-800 dark:text-gray-100' },
        {
          data: 'id',
          orderable: false,
          searchable: false,
          className: 'px-4 py-3 text-center w-28',
          render: function (id, type, row) {
            const safeName = $('<div>').text(row.name ?? '').html();
            return `
              <div class="flex justify-center gap-3">
                <button class="edit-btn text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                        data-id="${id}" data-name="${safeName}" title="Edit" aria-label="Edit ${safeName}">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="delete-btn text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                        data-id="${id}" data-name="${safeName}" title="Delete" aria-label="Delete ${safeName}">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>`;
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

    // Submit (Create / Update)
    $form.on('submit', function (e) {
      e.preventDefault();

      const isCreate = $method.val() === 'post';
      const url = isCreate ? "{{ route('roles.store') }}" : `${baseUrl}/${$form.data('edit-id')}`;
      const httpMethod = isCreate ? 'POST' : 'PUT';

      $submit.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');

      $.ajax({
        url: url,
        method: httpMethod,
        data: $form.serialize(),
        success: function (res) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: res.message || 'Data berhasil disimpan!',
            toast: true, position: 'top-end', showConfirmButton: false, timer: 1800
          });
          resetForm();
          table.ajax.reload(null, false);
        },
        error: function (xhr) {
          const msg = xhr.responseJSON?.message
            || (xhr.status === 422 ? 'Validasi gagal. Periksa input.' : 'Terjadi kesalahan!');
          Swal.fire({ icon: 'error', title: 'Error', text: msg });
        },
        complete: function () {
          $submit.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
        }
      });
    });

    function resetForm() {
      $title.text('Add Role');
      $method.val('post');
      $form.removeData('edit-id');
      $form.attr('action', "{{ route('roles.store') }}")[0].reset();
      $('#name').blur();
    }

    // Edit
    $('#dataTable').on('click', '.edit-btn', function () {
      const id = $(this).data('id');
      const name = $(this).data('name');

      $title.text('Edit Role');
      $method.val('put');
      $form.attr('action', `${baseUrl}/${id}`).data('edit-id', id);
      $('#name').val($('<div>').html(name).text()).trigger('focus');
    });

    // Cancel edit
    $('#cancelEdit').on('click', function () {
      resetForm();
    });

    // Delete
    $('#dataTable').on('click', '.delete-btn', function () {
      const id = $(this).data('id');
      const name = $(this).data('name');

      Swal.fire({
        title: 'Are you sure?',
        text: `Role "${$('<div>').html(name).text()}" akan dihapus!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((r) => {
        if (!r.isConfirmed) return;
        $.ajax({
          url: `${baseUrl}/${id}`,
          method: 'DELETE',
          success: function (res) {
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: res.message || 'Data berhasil dihapus!',
              toast: true, position: 'top-end', showConfirmButton: false, timer: 1800
            });
            table.ajax.reload(null, false);
            if ($form.data('edit-id') == id) resetForm();
          },
          error: function () {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus data!' });
          }
        });
      });
    });
  });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
@endpush
