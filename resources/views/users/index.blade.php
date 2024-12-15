<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    @if(!auth()->user()->can('can view users') && !auth()->user()->can('is super admin'))
        @php
            return redirect()->route('dashboard')->send();
        @endphp
    @endif

    <x-slot name="slot">
        <div class="container mx-auto p-4">
           

            <!-- Card Section -->
            <div class="flex justify-center">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg w-full max-w-6xl p-6 mx-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            User List
                        </h3>
                        @if(auth()->user()->can('can add users') && auth()->user()->can('is super admin'))
                            <a href="{{ route('users.create') }}"
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                Add User
                            </a>
                        @endif
                    </div>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">#</th>
                                <th scope="col" class="py-3 px-6">Name</th>
                                <th scope="col" class="py-3 px-6">Email</th>
                                <th scope="col" class="py-3 px-6">Role(s)</th>
                                <th scope="col" class="py-3 px-6">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                // Define the roles hierarchy
                                $hierarchy = ['super admin' => 1, 'admin' => 2, 'staff' => 3, 'user' => 4];
                                $currentUserRole = auth()->user()->roles->pluck('name')->first();
                                $currentUserLevel = $hierarchy[$currentUserRole] ?? PHP_INT_MAX;
                            @endphp

                            @forelse ($users as $user)
                                @php
                                    $userRole = $user->roles->pluck('name')->first();
                                    $userLevel = $hierarchy[$userRole] ?? PHP_INT_MAX;
                                @endphp

                                @if ($user->id === auth()->id() || $userLevel < $currentUserLevel)
                                    @continue
                                @endif

                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="py-4 px-6 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 text-center">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-center">{{ $user->email }}</td>
                                    <td class="py-4 px-6 text-center">
                                        {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                    </td>
                                    <td class="py-4 px-6 text-center flex justify-center space-x-4">
                                        <!-- Edit Action -->
                                        @if(auth()->user()->can('can edit users'))
                                            <a href="{{ route('users.edit', $user) }}" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        <!-- View Action -->
                                        @if(auth()->user()->can('can view users'))
                                            <a href="{{ route('users.show', $user) }}" class="text-green-500 hover:text-green-700">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif

                                        <!-- Delete Action -->
                                        @if(auth()->user()->can('can delete users'))
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-6 text-center text-gray-500">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
