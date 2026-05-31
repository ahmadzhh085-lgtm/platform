<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function edit($id)
    {
        $employee = \App\Models\User::findOrFail($id);
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.employees.edit', compact('employee', 'roles'));
    }
    public function index()
    {
        // جلب جميع المستخدمين الذين لديهم دور موظف مع ترقيم الصفحات
        $employees = \App\Models\User::role(['موظف المالية', 'موظف الخدمات', 'Employee'])->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }
}
