<?php

namespace App\Http\Controllers;

use App\Models\Peines;
use Illuminate\Http\Request;

class PeinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'group.*.fr1' => 'required',
            'group.*.am1' => 'required',
            'group.*.date1' => 'required',
            'cassier_judiciaire_id' => 'required|exists:cassier_judiciaires,id',
        ]);

        foreach($request->group as $faits){
            Peines::create([
                'fr1'=> $faits['fr1'],
                'am1'=> $faits['am1'],
                'date1'=> $faits['date1'],
                'cassier_judiciaire_id'=> $request->cassier_judiciaire_id,
            ]);
        }
        

        return redirect()->route('index.casier')
        ->with('success', 'Peines du casier créée avec succès !');
    }
    
     public function editprison($id)
    {
        $prison = Peines::findOrFail($id);
        return view('/content/table/table-bootstrap/edit_prison', compact('prison'));
    }
    
    
    public function updateprison(Request $request, $id){
        $prison = Peines::findOrFail($id);
        
        $prison->update($request->all());
        
        return back();
        
    }
    
    public function deleteprison($id){
        $prison = Peines::findOrFail($id);
        
        $prison->delete();
        
        return back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peines  $peines
     * @return \Illuminate\Http\Response
     */
    public function show(Peines $peines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peines  $peines
     * @return \Illuminate\Http\Response
     */
    public function edit(Peines $peines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peines  $peines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peines $peines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peines  $peines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peines $peines)
    {
        //
    }
}
