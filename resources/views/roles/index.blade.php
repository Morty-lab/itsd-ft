<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Roles</h1>
            <a href="{{ route('roles.create') }}"
               class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                Add Role
            </a>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Role Name</th>
                <th class="px-4 py-2 border">Permissions</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td class="px-4 py-2 border">{{ $role->name }}</td>
                    <td class="px-4 py-2 border">
                        {{ $role->permissions->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('roles.edit', $role) }}"
                           class="px-2 py-1 text-white bg-green-500 rounded hover:bg-green-600">
                            Edit
                        </a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-2 py-1 text-white bg-red-500 rounded hover:bg-red-600"
                                    onclick="return confirm('Are you sure you want to delete this roles?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
