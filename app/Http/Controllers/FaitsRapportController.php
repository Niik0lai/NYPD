<?php

namespace App\Http\Controllers;

use App\Models\FaitsRapport;
use Illuminate\Http\Request;

class FaitsRapportController extends Controller
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
            'rapport_id' => 'required|exists:rapports,id',
        ]);

        foreach($request->group as $faitsrapports){
            FaitsRapport::create([
                'fr1'=> $faitsrapports['fr1'],
                'am1'=> $faitsrapports['am1'],
                'date1'=> $faitsrapports['date1'],
                'rapport_id'=> $request->rapport_id,
                'created_by'=>auth()->user()->noms
            ]);
        }
        

        return redirect()->route('index.rapport')
        ->with('success', 'Faits du rapport créée avec succès !');
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
     * @param  \App\Models\FaitsRapport  $faitsRapport
     * @return \Illuminate\Http\Response
     */
    public function show(FaitsRapport $faitsRapport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaitsRapport  $faitsRapport
     * @return \Illuminate\Http\Response
     */
    public function edit(FaitsRapport $faitsRapport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FaitsRapport  $faitsRapport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaitsRapport $faitsRapport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FaitsRapport  $faitsRapport
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaitsRapport $faitsRapport)
    {
        //
    }
}
