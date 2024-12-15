<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles Management') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="container mx-auto p-4">
            <!-- Card Section -->
            <div class="flex justify-center">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-full max-w-6xl p-6 mx-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Role List
                        </h3>
                        <a href="{{ route('roles.create') }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Add Role
                        </a>
                    </div>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">#</th>
                                <th scope="col" class="py-3 px-6">Role Name</th>
                                <th scope="col" class="py-3 px-6">Permissions</th>
                                <th scope="col" class="py-3 px-6">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($roles as $role)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="py-4 px-6 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 text-center">{{ $role->name }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($role->permissions->isEmpty())
                                            <span class="text-gray-500">No permissions</span>
                                        @else
                                            {{ $role->permissions->pluck('name')->join(', ') }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center flex justify-center space-x-4">
                                        <!-- Edit Action -->
                                        <a href="{{ route('roles.edit', $role) }}" class="text-blue-500 hover:text-blue-700">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Action -->
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700"
                                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-6 text-center text-gray-500">
                                        No roles found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination (if roles are paginated) -->
                    @if(method_exists($roles, 'links'))
                        <div class="mt-4">
                            {{ $roles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
