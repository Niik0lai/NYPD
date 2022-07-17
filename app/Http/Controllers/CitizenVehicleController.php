<?php

namespace App\Http\Controllers;

use App\Models\Cityvehicle;
use App\Models\User;
use Illuminate\Http\Request;

class CitizenVehicleController extends Controller
{
    public function index(){
        
        
        // $cv = Cityvehicle::find(20);
        
        // return $cv->cid->img;
        
        $volVehicules = Cityvehicle::all();
        $users = User::all();
        
        return view('/content/table/table-bootstrap/index_citizen_vehicle', compact('volVehicules','users'));
    }
    
    public function store(Request $request){
        
        //return $request->all();
        $request->validate([
            'noms' => 'required',
            'cassier_judiciaires_id' => 'required',
            'citoyen' => 'required',
            'plaque' => 'required',
            'vehicule' => 'required',
            'color' => 'required',
            'creation_date' => 'required',
            'modifide_date' => 'required',
        ]);
        
        //return $request->all();
        
        Cityvehicle::create($request->all());
        
        return back();
    }
    
    public function edit($id){
        $volVehicule = Cityvehicle::findOrFail($id);
        
        return view('/content/table/table-bootstrap/edit_citizen_vehicle', compact('volVehicule'));
    }
    
    public function update(Request $request, $id){
        //return $request->all();
        
         $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'plaque' => 'required',
            'vehicule' => 'required',
            'color' => 'required',
            'creation_date' => 'required',
            'modifide_date' => 'required',
        ]);
        
        $volVehicule = Cityvehicle::findOrFail($id);
        
        $volVehicule->update($request->all());
        
        return redirect()->route('cityvehicle.index');
    }
    
    public function delete($id){
        $volVehicule = Cityvehicle::findOrFail($id);
        
        $volVehicule->delete();
        return redirect()->route('cityvehicle.index');
    }
    
    public function archive($id){
         $volVehicule = Cityvehicle::findOrFail($id);
         
         $volVehicule->update([
             'archive'=>'1'
             ]);
        return redirect()->route('cityvehicle.index');
    }
    public function dearchive($id){
         $volVehicule = Cityvehicle::findOrFail($id);
         
         $volVehicule->update([
             'archive'=>'0'
             ]);
        return redirect()->route('cityvehicle.index');
    }
}
