<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="container mx-auto p-4">
            <div class="flex justify-center">
                <div class="w-full max-w-4xl">
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mx-auto" style="max-width: 50%;">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">#</th>
                                <th scope="col" class="py-3 px-6">Name</th>
                                <th scope="col" class="py-3 px-6">Email</th>
                                <th scope="col" class="py-3 px-6">Role(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="py-4 px-6 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 text-center">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-center">{{ $user->email }}</td>
                                    <td class="py-4 px-6  text-center">
                                        {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                    </td>
                                    <td class="py-4 px-6  text-center">
                                        {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 px-6 text-center text-gray-500">
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
