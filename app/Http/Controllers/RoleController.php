<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
        'name' => 'required|unique:roles',
    ]);
        Role::create($request->all());
        
        return back();
    }
    
    public function update(Request $request, $id){
        
         $validated = $request->validate([
        'name' => 'required|unique:roles',
    ]);
        $role = Role::findOrFail($id);
        
        $role->update($request->all());
        
        return back();
    }
    
    public function delete($id){
        $role = Role::findOrFail($id);
        $role->delete();
        
        return back();
    }
}
