@extends('layouts.tailadmin')

@section('title', 'Template Data')
@push('styles')
    <style>

        html.dark #downloadBtn {
        background-color: rgb(249 115 22) !important; /* orange-500 */
        border-color: transparent !important;
        color: #fff !important;
        }

        html.dark #downloadBtn:hover {
        background-color: rgb(234 88 12) !important; /* orange-600 */
        }

        
        html.dark #uploadBtn {
        background-color: rgb(249 115 22) !important; /* orange-500 */
        border-color: transparent !important;
        color: #fff !important;
        }

        html.dark #uploadBtn:hover {
        background-color: rgb(234 88 12) !important; /* orange-600 */
        }

        html.dark #texth2 {
            color: black !important;
        }

        

    </style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="overflow-hidden rounded-3xl border border-orange-100 bg-gradient-to-br from-orange-50 via-white to-amber-50 px-6 py-6 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800 mb-6">
            <h2 id="texth2" class="text-2xl font-semibold text-gray-800 dark:text-white">Template Distribusi</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">Unduh template bulanan, isi data, lalu unggah kembali dengan format yang sama.</p>
        </div>
        <div class="mt-5 grid grid-cols-1 gap-3 text-sm text-gray-600 sm:grid-cols-3">
            <div class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-sm">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-100 text-orange-700">1</span>
                <span>Pilih bulan dan unduh template.</span>
            </div>
            <div class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-sm">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-100 text-orange-700">2</span>
                <span>Isi data sesuai kolom yang tersedia.</span>
            </div>
            <div class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-sm">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-orange-100 text-orange-700">3</span>
                <span>Unggah file Excel untuk diproses.</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-orange shadow-sm">
            <div class="flex items-center justify-between rounded-t-2xl bg-gradient-to-r from-orange-500 via-orange-600 to-amber-600 px-6 py-4">
                <div class="flex items-center gap-3 text-orange">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l3.5-3.5M12 15l-3.5-3.5M5 20h14" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold">Download Template</h2>
                        <p class="text-xs text-orange/80">Gunakan format resmi untuk unggah.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4 px-6 py-5">
                <div class="rounded-xl border border-orange-100 bg-orange-50 px-4 py-3 text-xs text-orange-700">
                    Tips: pilih bulan yang sesuai periode input data.
                </div>
                <form action="" method="GET" onsubmit="event.preventDefault(); downloadTemplate();" class="space-y-4">
                    <div class="space-y-2">
                        <label for="month" class="text-sm font-medium text-gray-700">Pilih Bulan</label>
                        <select id="month" name="month" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200" required>
                            <option value="" disabled selected>Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <button type="submit"  id="downloadBtn" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l3.5-3.5M12 15l-3.5-3.5M5 20h14" />
                        </svg>
                        Download Template
                    </button>
                </form>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-orange shadow-sm">
            <div class="flex items-center justify-between rounded-t-2xl bg-gradient-to-r from-orange-500 via-orange-600 to-amber-600 px-6 py-4">
                <div class="flex items-center gap-3 text-orange">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange/15">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0l3.5 3.5M12 9L8.5 12.5M5 5h14" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold">Upload Template</h2>
                        <p class="text-xs text-orange/80">Unggah file Excel yang sudah diisi.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4 px-6 py-5">
                @if ($message = Session::get('success'))
                    <div class="flex items-start justify-between gap-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        <span>{{ $message }}</span>
                        <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <form action="{{ route('distribution_data.upload-template')}}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="space-y-2">
                        <label for="file" class="text-sm font-medium text-gray-700">Upload File Excel</label>
                        <input type="file" id="file" name="file" class="block w-full rounded-lg border border-dashed border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-600 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-orange-700" required>
                        <p class="text-xs text-gray-500">Format yang didukung: .xlsx, .xls</p>
                        <p id="file-name" class="text-xs font-medium text-gray-600"></p>
                    </div>
                    <button type="submit" id="uploadBtn" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0l3.5 3.5M12 9L8.5 12.5M5 5h14" />
                        </svg>
                        Upload Template
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function downloadTemplate() {
        const month = document.getElementById('month').value;
        if (month) {
            const url = "{{ route('distribution_data.export-template', ['month' => ':month']) }}";
            window.location.href = url.replace(':month', month);
        }
    }

    const fileInput = document.getElementById('file');
    const fileName = document.getElementById('file-name');
    if (fileInput && fileName) {
        fileInput.addEventListener('change', () => {
            const selected = fileInput.files && fileInput.files[0] ? fileInput.files[0].name : '';
            fileName.textContent = selected ? `File dipilih: ${selected}` : '';
        });
    }
</script>
@endpush
