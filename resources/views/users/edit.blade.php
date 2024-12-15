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

    <div class="container mx-auto p-4">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold mb-4">Edit User</h1>

            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                           class="block w-full mt-1 p-2 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                           class="block w-full mt-1 p-2 border border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div class="mb-4">
                    <label for="roles" class="block text-gray-700 dark:text-gray-300">Role</label>
                    <input id="roles" type="text" value="{{ $user->roles->pluck('name')->join(', ') }}" readonly
                           class="block w-full mt-1 p-2 border border-gray-300 rounded bg-gray-100 dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div class="mb-4">
                    <label for="permissions" class="block text-gray-700 dark:text-gray-300">Permissions</label>
                    <div class="mt-2">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center mb-2">
                                <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                       value="{{ $permission->id }}"
                                       {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="permission-{{ $permission->id }}" class="ml-2 text-gray-700 dark:text-gray-300">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>