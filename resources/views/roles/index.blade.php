@extends('layouts.tailadmin')

@section('title', 'Role')

@section('content')
<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Role</h2>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Table Section -->
    <div>
      <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-4">
        <div class="overflow-x-auto">
          <table id="dataTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">No.</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Name</th>
                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <!-- Form Section -->
    <div>
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
              class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg">
              Cancel
            </button>
            <button type="submit" 
              class="px-4 py-2 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 rounded-lg flex items-center gap-1">
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
$(document).ready(function() {
    // ✅ Inisialisasi DataTable
    const table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('roles.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return `
                        <div class="flex justify-center gap-3">
                            <button 
                                class="edit-btn text-blue-500 hover:text-blue-700" 
                                data-id="${data}" 
                                data-name="${row.name}" 
                                title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button 
                                class="delete-btn text-red-500 hover:text-red-700" 
                                data-id="${data}" 
                                data-name="${row.name}" 
                                title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search roles..."
        }
    });

    // ✅ Tombol Edit
    $('#dataTable').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#formtitle').text('Edit Role');
        $('#method').val('put');
        $('#myform').attr('action', `/roles/${id}`);
        $('#name').val(name);
    });

    // ✅ Tombol Cancel (reset form)
    $('#cancelEdit').on('click', function() {
        $('#formtitle').text('Add Role');
        $('#method').val('post');
        $('#myform').attr('action', `{{ route('roles.store') }}`);
        $('#name').val('');
    });

    // ✅ Tombol Delete (tampilkan modal)
    let deleteId = null;
    $('#dataTable').on('click', '.delete-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteModal').removeClass('hidden');
        $('#delform').attr('action', `/roles/${deleteId}`);
    });

    // ✅ Tombol Cancel di modal
    $('#cancelDelete').on('click', function() {
        $('#deleteModal').addClass('hidden');
    });
});
</script>

{{-- FontAwesome untuk icon --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
@endpush
