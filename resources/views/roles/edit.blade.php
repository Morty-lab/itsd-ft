<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Role') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="max-w-3xl mx-auto">
            <!-- Card Section -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Edit Role</h1>

                <form method="POST" action="{{ route('roles.update', $role) }}">
                    @csrf
                    @method('PUT')

                    <!-- Role Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $role->name) }}"
                               class="mt-1 block w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700">
                    </div>

                    <!-- Permissions Field -->
                    <div class="mb-6">
                        <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center">
                                    <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                           value="{{ $permission->id }}"
                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
