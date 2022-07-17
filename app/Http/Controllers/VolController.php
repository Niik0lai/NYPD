<?php

namespace App\Http\Controllers;

use App\Models\Vol;
use App\Models\User;
use Illuminate\Http\Request;

class VolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $vols = Vol::all();

        $users = User::all();
        return view('/content/table/table-bootstrap/index_vol', compact('vols'),compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $vol = new Vol();

        $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'objet' => 'required',
            'date' => 'required',
            'estimation' => 'required',
            'suspect' => 'required',
        ]);

        $vol->noms = $request->noms;
        $vol->citoyen = $request->citoyen;
        $vol->objet = $request->objet;
        $vol->date = $request->date;
        $vol->cassier_judiciaires_id = $request->cassier_judiciaires_id;
        $vol->estimation = $request->estimation;
        $vol->suspect = $request->suspect;

        $vol->save();
        return redirect()->route('index.vol')
            ->with('success', 'Vol créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vol  $vol
     * @return \Illuminate\Http\Response
     */
    public function show(Vol $vol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vol  $vol
     * @return \Illuminate\Http\Response
     */
    public function edit(Vol $vol, $id)
    {
        
        $vol = Vol::find($id);
        return view('/content/table/table-bootstrap/edit_vol', compact('vol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vol  $vol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vol $vol, $id)
    {
        $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'objet' => 'required',
            'date' => 'required',
            'estimation' => 'required',
            'suspect' => 'required',
        ]);
        $vol = Vol::find($id);

        $vol->noms = $request->noms;
        $vol->citoyen = $request->citoyen;
        $vol->objet = $request->objet;
        $vol->date = $request->date;
        $vol->estimation = $request->estimation;
        $vol->suspect = $request->suspect;

        $vol->save();
        return redirect()->route('index.vol')
            ->with('success', 'Vol créée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vol  $vol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vol $vol, $id)
    {
        $vol = Vol::find($id);
        $vol->delete($id);

        return redirect()->route('index.vol')
            ->with('success', 'Vol supprimé avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vol  $vol
     * @return \Illuminate\Http\Response
     */
    public function archive(Vol $vol, $id)
    {
        $vol = Vol::find($id);
        $vol->archive = "1";


        $vol->save();
        return redirect()->route('index.vol')
            ->with('success', 'Vol de véhicule archivé avec succès');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vol  $vol
     * @return \Illuminate\Http\Response
     */
    public function desarchive(Vol $vol, $id)
    {
        $vol = Vol::find($id);
        $vol->archive = "0";


        $vol->save();
        return redirect()->route('index.vol')
            ->with('success', 'Vol de véhicule désarchivé avec succès');

    }
}
