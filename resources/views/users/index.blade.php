@extends('layouts.tailadmin')

@section('title', 'Users')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Users</h2>
    </div>
    
    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-900 border border-gray-600 dark:border-gray-800 rounded-2xl shadow-sm p-6 space-y-4">
        <!-- Top Controls -->
        <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-4">
            <!-- LEFT: Search + Length + Add -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div id="usersTable_search_container"></div>
                <!-- Show Entries Dropdown -->
                <div id="usersTable_length_container"></div>
                <!-- Add button -->
                <a href="{{ route('users.create') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-brand-500 hover:bg-brand-600 rounded-lg shadow-sm">
                    + Add User
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="usersTable" class="min-w-full border border-gray-300 dark:border-gray-700 divide-y divide-gray-300 dark:divide-gray-700">               
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr class="divide-x divide-gray-300 dark:divide-gray-700">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No.</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Username</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Role</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700"></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    const table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        dom: 'lrtip',
        ajax: "{{ route('users.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'username' },
            { data: 'name' },
            { data: 'email' },
            { data: 'role_name', defaultContent: '-' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(id) {
                    return `
                        <div class="flex justify-center gap-3">
                            <a href="/users/${id}/edit" class="text-blue-500 hover:text-blue-700">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <button class="delete-btn text-red-500 hover:text-red-700" data-id="${id}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#usersTable_length').hide();

    // Inject Search
    $('#usersTable_search_container').html(`
        <input id="dtSearch" type="text"
        placeholder="Search users..."
        class="px-3 py-2 border rounded-lg text-sm bg-white dark:bg-gray-800 dark:border-gray-700
        focus:ring-brand-400 focus:border-brand-400">
    `);

    $('#dtSearch').keyup(function() {
        table.search(this.value).draw();
    });

    // Inject Length Dropdown
    $('#usersTable_length_container').html(`
        <select id="dtLength"
            class="border rounded-lg px-3 py-2 bg-white dark:bg-gray-800 dark:border-gray-700">
            ${$('#usersTable_length select').html()}
        </select>
    `);

    $('#dtLength').on('change', function () {
        table.page.len($(this).val()).draw();
    });

    // Delete button click
    $('#usersTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/users/${id}`,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'User berhasil dihapus!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        table.ajax.reload(null, false);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menghapus data!',
                        });
                    }
                });
            }
        });
    });

});
</script>

<!-- Fontawesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

<!-- UNIVERSAL SWEETALERT FLASH HANDLER -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    @foreach (['success', 'error', 'warning', 'info', 'status', 'message'] as $msg)
        @if(session($msg))

            Swal.fire({
                icon: '{{ $msg === "error" ? "error" : ($msg === "warning" ? "warning" : ($msg === "info" ? "info" : "success")) }}',
                title: '{{ ucfirst($msg) }}',
                text: "{{ session($msg) }}",
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1800,
                timerProgressBar: true,
            });

        @endif
    @endforeach

});
</script>


@endpush
