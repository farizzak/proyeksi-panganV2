@extends('layouts.tailadmin')

@section('title', 'Add User')

@section('content')
<div class="grid grid-cols-1 gap-6">

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-sm">
        
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-800">
            <h2 class="text-base font-semibold text-gray-800 dark:text-white/90">Tambah User</h2>
        </div>

        <!-- Form -->
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6 p-6">
            @csrf

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="p-4 rounded-lg bg-red-100 text-red-700 text-sm">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Username
                </label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                           bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                           focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 outline-hidden
                           dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                           bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                           focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 outline-hidden
                           dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                           bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                           focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 outline-hidden
                           dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    class="dark:bg-dark-900 shadow-theme-xs h-11 w-full rounded-lg border border-gray-300
                           bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400
                           focus:border-brand-300 focus:ring-brand-500/10 focus:ring-3 outline-hidden
                           dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                />
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1.5">
                    Role
                </label>

                <div x-data="{ selected: '{{ old('role_id') }}' !== '' }" class="relative z-20 bg-transparent">
                    <select
                        name="role_id"
                        class="dark:bg-dark-900 shadow-theme-xs h-11 w-full appearance-none
                               rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11
                               text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300
                               focus:ring-brand-500/10 focus:ring-3 outline-hidden
                               dark:border-gray-700 dark:bg-gray-900 dark:text-white/90
                               dark:placeholder:text-white/30"
                        @change="selected = true"
                    >
                        <option value="">-- Pilih Role --</option>

                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}"
                                {{ old('role_id') == $r->id ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>

                    <span class="pointer-events-none absolute top-1/2 right-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M4.8 7.4L10 12.6L15.2 7.4"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>

                @error('role_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Button --}}
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                    Kembali
                </a>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
