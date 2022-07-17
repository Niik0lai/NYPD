<?php

namespace App\Http\Controllers;

use App\Models\Ppa;
use Illuminate\Http\Request;

class PpaController extends Controller
{
    public function index(){
        $ppas = Ppa::all();
        return view('/content/table/table-bootstrap/index_ppa', compact('ppas'));
    }
    
    public function store(Request $request){
        $request->validate([
            'noms'=>'required',
            'citoyen'=>'required',
            'categorie'=>'required',
            'date'=>'required',
            'cassier_judiciaires_id'=>'required',
            'montant'=>'required',
            'etat'=>'required'
        ]);
        
        Ppa::create($request->all());
        
        return back();
    }
    
    public function edit($id){
        
        $ppa = Ppa::find($id);
        
        return view('/content/table/table-bootstrap/edit_ppa', compact('ppa'));
    }
    
    public function update(Request $request, $id){
        
         $request->validate([
            'noms'=>'required',
            'citoyen'=>'required',
            'categorie'=>'required',
            'date'=>'required',
            'montant'=>'required',
            'etat'=>'required'
        ]);
        
        $ppa = Ppa::findOrFail($id);
        
        $ppa->update($request->all());
        
        return back();
    }
    
    public function archive($id){
        $ppa = Ppa::findOrFail($id);
        
        $ppa->update([
           'archives' => '1'
        ]);
        
        return back();
    }
    
    public function dearchive($id){
        $ppa = Ppa::findOrFail($id);
        
        $ppa->update([
           'archives' => '0'
        ]);
        
        return back();
    }
    
    public function delete($id){
        $ppa = Ppa::findOrFail($id);
        
        $ppa->delete();
        
        return back();
    }
    
    
}
