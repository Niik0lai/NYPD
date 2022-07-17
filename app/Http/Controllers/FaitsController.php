<?php

namespace App\Http\Controllers;

use App\Models\Faits;
use Illuminate\Http\Request;

class FaitsController extends Controller
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
            'personne_recherchee_id' => 'required|exists:personne_recherchees,id',
        ]);

        foreach($request->group as $faits){
            Faits::create([
                'fr1'=> $faits['fr1'],
                'am1'=> $faits['am1'],
                'date1'=> $faits['date1'],
                'personne_recherchee_id'=> $request->personne_recherchee_id,
            ]);
        }
        
        return redirect()->back();
        return redirect()->route('index.plainte')
        ->with('success', 'Faits créée avec succès !');

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
     * @param  \App\Models\Faits  $faits
     * @return \Illuminate\Http\Response
     */
    public function show(Faits $faits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faits  $faits
     * @return \Illuminate\Http\Response
     */
    public function editfait($id)
    {
         $prison = Faits::findOrFail($id);
        
         return view('/content/table/table-bootstrap/update_faits', compact('prison'));
    }
    
    
    public function updatefaits(Request $request, $id){
        $faits = Faits::findOrFail($id);
        
        $faits->update($request->all());
        
        return redirect()->route('show.personne_recherchee', $faits->personne_recherchee_id);
    }
    
    
    public function deletefaits($id){
        $faits = Faits::findOrFail($id);
        
        $faits->delete();
        
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faits  $faits
     * @return \Illuminate\Http\Response
     */
    public function update ($id)
    {
        return 'ok';
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faits  $faits
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faits $faits)
    {
        //
    }
}
