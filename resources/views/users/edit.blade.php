@extends('layouts.tailadmin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-sm p-6">

    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Edit User</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Username -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Password (Optional) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Password <span class="text-gray-400 text-xs">(leave empty to keep current)</span>
            </label>
            <input type="password" name="password"
                class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
        </div>

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
            <select name="role_id"
                class="w-full px-3 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 focus:ring-brand-400 focus:border-brand-400">
                <option value="">-- Choose Role --</option>
                @foreach ($roles as $r)
                <option value="{{ $r->id }}" {{ $user->role_id == $r->id ? 'selected' : '' }}>
                    {{ $r->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('users.index') }}"
                class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 rounded-lg">
                Cancel
            </a>

            <button class="px-4 py-2 text-sm text-white bg-brand-500 hover:bg-brand-600 rounded-lg">
                Update
            </button>
        </div>

    </form>
</div>
@endsection
