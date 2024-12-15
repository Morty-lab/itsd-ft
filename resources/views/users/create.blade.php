<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="container mx-auto p-6">
            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <!-- Name Input -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter user name" required>
                    </div>

                    <!-- Email Input -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" id="email" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter user email" required>
                    </div>

                    <!-- Roles Select -->
                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="role" id="role" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Permissions Checkboxes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                        <div class="mt-2 space-y-4" id="permissions-container">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox h-4 w-4 text-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <label class="ml-3 text-sm text-gray-700 dark:text-gray-300">{{ ucfirst($permission->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>

<script>
    // Define roles and their permissions
    const roles = @json($roles->mapWithKeys(fn($role) => [$role->id => $role->permissions->pluck('name')]));

    document.getElementById('role').addEventListener('change', function() {
        const selectedRole = this.value;
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        // Uncheck all checkboxes initially
        checkboxes.forEach(checkbox => checkbox.checked = false);

        // If a role is selected, get its permissions and check the corresponding boxes
        if (roles[selectedRole]) {
            const rolePermissions = roles[selectedRole];
            checkboxes.forEach(checkbox => {
                if (rolePermissions.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        }
    });
</script>
