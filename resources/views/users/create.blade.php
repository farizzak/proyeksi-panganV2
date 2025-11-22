@extends('layouts.tailadmin')

@section('title', 'Add User')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-6">
    
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Add User</h2>
    @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
        <ul class="list-disc ml-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Username -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
            <input type="text" name="username" value="{{ old('username') }}"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" name="password"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-amber-800 mb-1">Role</label>
            <select name="role_id" required
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700">
                <option value="">-- Pilih Role --</option>
                @foreach ($roles as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('users.index') }}"
                class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 rounded-lg">
                Cancel
            </a>

            <button class="px-4 py-2 text-sm text-white bg-brand-500 hover:bg-brand-600 rounded-lg">
                Save
            </button>
        </div>

    </form>
</div>
@endsection
