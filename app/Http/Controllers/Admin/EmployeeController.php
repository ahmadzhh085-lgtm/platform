<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with(['roles', 'permissions'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.employees.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['required', 'in:active,inactive'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'status' => $validated['status'],
        ]);

        $roles = $request->input('roles', []);
        if (empty($roles)) {
            $roles = ['User'];
        }

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $permissions = $request->input('permissions', []);
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $user->syncRoles($roles);
        $user->syncPermissions($permissions);

        return redirect()->route('admin.employees.index')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    public function show(User $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.employees.edit', compact('employee', 'roles', 'permissions'));
    }

    public function update(Request $request, User $employee)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:6'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => $validated['status'],
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($validated['password']);
        }

        $employee->update($data);

        $roles = $request->input('roles', []);
        if (empty($roles)) {
            $roles = ['User'];
        }

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $permissions = $request->input('permissions', []);
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $employee->syncRoles($roles);
        $employee->syncPermissions($permissions);

        return redirect()->route('admin.employees.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function destroy(User $employee)
    {
        if (auth()->id() === $employee->id) {
            return redirect()->route('admin.employees.index')->with('error', 'لا يمكن حذف حسابك الحالي.');
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
