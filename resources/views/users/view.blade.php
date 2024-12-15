<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    @if(!auth()->user()->can('can view users') && !auth()->user()->can('is super admin'))
        @php
            return redirect()->route('dashboard')->send();
        @endphp
    @endif

    <x-slot name="slot">
        <div class="flex justify-center bg-gray-50 dark:bg-gray-900 mt-3">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <div class="space-y-4">
                    <!-- User Information Card -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md">
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                            <strong>Name:</strong> <span class="text-gray-900 dark:text-gray-200">{{ $user->name }}</span>
                        </p>
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                            <strong>Email:</strong> <span class="text-gray-900 dark:text-gray-200">{{ $user->email }}</span>
                        </p>
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                            <strong>Roles:</strong> <span class="text-gray-900 dark:text-gray-200">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</span>
                        </p>
                        <!-- Permissions -->
                        <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                            <strong>Permissions:</strong>
                            <span class="text-gray-900 dark:text-gray-200">
                                @if($permissions->isEmpty())
                                    No permissions assigned
                                @else
                                    {{ implode(', ', $permissions->pluck('name')->toArray()) }}
                                @endif
                            </span>
                        </p>
                    </div>

                    <!-- Action Button Section -->
                    <div class="mt-6 flex justify-start">
                        <a href="{{ route('users.edit', $user) }}"
                           class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
