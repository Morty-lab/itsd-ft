<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the user has the required permissions
        if (!auth()->user()->hasAnyPermission(['can view users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $users = User::all();
        return view('users.index' , ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if the user has the required permissions
        if (!auth()->user()->hasAnyPermission(['can add users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
        }
        // Fetch all permissions
        $permissions = Permission::all();

        // Fetch all roles with their permissions
        $roles = Role::with('permissions')->get();

        // Pass data to the view
        return view('users.create', [
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Check if the user has the required permissions
        if (!auth()->user()->hasAnyPermission(['can add users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
        }

        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|in:super_admin,admin,staff,user', // Ensure the roles exists
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make('testpassword'), // Set a default password or generate one
        ]);

        // Assign the selected roles to the user
        $user->assignRole($request->input('roles')); // Spatie's method to assign roles

        // Sync permissions if provided
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('name', $request->input('permissions'))->get();
            $user->givePermissionTo($permissions); // Spatie's method to assign permissions
        }

        // Redirect with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->hasAnyPermission(['can view users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $user = User::find($id);

        // Fetch the user's permissions
        $permissions = $user->permissions;

        return view('users.view', ['user' => $user, 'permissions' => $permissions]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!auth()->user()->hasAnyPermission(['can edit users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $permissions = Permission::all(); // Assuming permissions are stored in a Permission model.
        return view('users.edit', compact('user', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->user()->hasAnyPermission(['can edit users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to perform this action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'permissions' => 'nullable|array', // Permissions are optional.
            'permissions.*' => 'exists:permissions,id', // Ensure each permission exists.
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Sync permissions (roles remain unchanged).
        $user->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('users.show', $user)->with('status', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if the user has the required permissions
        if (!auth()->user()->hasAnyPermission(['can delete users', 'is super admin'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to delete users.');
        }

        // Find the user by ID
        $user = User::find($id);

        // If the user is not found, return with an error message
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Prevent deletion of self
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        // Attempt to delete the user
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Log the exception if necessary and redirect with an error message
            \Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'An error occurred while trying to delete the user.');
        }
    }

}
