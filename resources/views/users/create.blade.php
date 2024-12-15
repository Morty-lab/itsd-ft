<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="container mx-auto p-4">
            <div class="flex justify-center">
                <div class="w-full max-w-4xl bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <!-- Name Input -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full p-2 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full p-2 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <!-- Roles Select -->
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <select name="role" id="role" class="mt-1 block w-full p-2 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Permissions Checkboxes -->
                        <div class="mb-4">
                            <label for="permissions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Permissions</label>
                            <div class="mt-2" id="permissions-container">
                                @foreach ($permissions as $permission)
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox rounded dark:bg-gray-700 dark:border-gray-600">
                                            <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
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
script
