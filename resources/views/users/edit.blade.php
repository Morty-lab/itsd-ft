<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    @if(!auth()->user()->can('can edit users') && !auth()->user()->can('is super admin'))
        @php
            return redirect()->route('dashboard')->send();
        @endphp
    @endif

    <div class="container mx-auto p-6">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200">Edit User</h1>

            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <!-- Name Input -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                           class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter user name" required>
                </div>

                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                           class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter user email" required>
                </div>

                <!-- Roles Display -->
                <div class="mb-6">
                    <label for="roles" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <input id="roles" type="text" value="{{ $user->roles->pluck('name')->join(', ') }}" readonly
                           class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" disabled>
                </div>

                <!-- Permissions Checkboxes -->
                <div class="mb-6">
                    <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                    <div class="mt-2 space-y-4">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center">
                                <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                       value="{{ $permission->id }}"
                                       {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Save Changes Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="px-6 py-3 text-white bg-green-600 rounded-lg hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
