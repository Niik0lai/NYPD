<?php

namespace App\Http\Controllers;

use App\Models\FaitsCassier;
use Illuminate\Http\Request;

class FaitsCassierController extends Controller
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
            FaitsCassier::create([
                'fr1'=> $faits['fr1'],
                'am1'=> $faits['am1'],
                'date1'=> $faits['date1'],
                'cassier_judiciaire_id'=> $request->cassier_judiciaire_id,
            ]);
        }
        

        return redirect()->route('index.casier')
        ->with('success', 'Faits du casier créée avec succès !');
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
     * @param  \App\Models\FaitsCassier  $faitsCassier
     * @return \Illuminate\Http\Response
     */
    public function show(FaitsCassier $faitsCassier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FaitsCassier  $faitsCassier
     * @return \Illuminate\Http\Response
     */
    public function edit(FaitsCassier $faitsCassier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FaitsCassier  $faitsCassier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaitsCassier $faitsCassier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FaitsCassier  $faitsCassier
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaitsCassier $faitsCassier)
    {
        //
    }
}
