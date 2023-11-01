<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();

        return view('dashboard.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('dashboard.role.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the role
        $request->validate([
            'role' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->input('role')]);

        // Sync the selected permissions to the role
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('role.index')->with('success', 'Role and permissions added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('dashboard.role.edit', compact('role', 'permissions', 'rolePermissions'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate and update the role
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->name = $request->input('name');
        $role->save();

        // Sync the selected permissions to the role
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::where('id',$id)->first();

        if(isset($role)){

            $role->permissions()->detach();
            $role->delete();

//            return redirect()->route('role.index')->with('success','Roles Deleted Successfully');
            session()->flash('success', 'Role deleted successfully');

        }
    }
}
