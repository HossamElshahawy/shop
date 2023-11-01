<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::all();
        return view('dashboard.permission.index',compact('permissions'));
    }


    public function create()
    {
        return view('dashboard.permission.create');
    }


    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',
        ]);

        Permission::create([
            'name' => $request->name,
        ]);


        return redirect()->back()->with('success','Permission Added Success');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('dashboard.permission.edit',compact('permission'));

    }

    public function update(Request $request, string $id)
    {
        $permission = Permission::where('id',$id)->first();

        $request->validate([
            'name' => 'required'
        ]);

        $permission->update([
            "name" => $request->name
        ]);

        return redirect()->route('permission.index')->with('success','Permission Updated Successfully');
    }


    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();
//        return response()->json(['message' => 'Permission deleted successfully']);
        session()->flash('success', 'Permission deleted successfully');

    }
}
