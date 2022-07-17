<?php

namespace App\Http\Controllers;

use App\Models\Plainte;
use App\Models\User;
use Illuminate\Http\Request;

class PlainteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $plaintes = Plainte::all();
        return view('/content/table/table-bootstrap/index_plainte', compact('plaintes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $users = User::all();
        return view('/content/table/table-bootstrap/create_plainte' , compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $request->validate([
            'citoyen' => 'required',
            'details' => 'required',
            'dsuspects' => 'required',
            'noms' => 'required',
        ]);
        
        $input = $request->all();
        
        $input['created_by'] = auth()->user()->noms;
        
        Plainte::create($input);
        
    
        // if (isset($request->img)) {
        //     $path = $request->file('img')->storeAs('public', "image-plainte-" . time() . "." . $request->file('img')->getClientOriginalExtension());
        // } else {
        //     $path = "";
        // }
        // $plainte->img = $path;
        // $plainte->nom = $request->nom;
        // $plainte->prenom = $request->prenom;
        // $plainte->datenaissance = $request->datenaissance;
        // $plainte->telephone = $request->telephone;
        // $plainte->gang = $request->gang;
        // $plainte->motif = $request->motif;
        // $plainte->details = $request->details;
        // $plainte->dsuspects = $request->dsuspects;
        // $plainte->noms = $request->noms;

       
        return redirect()->route('index.plainte')
            ->with('success', 'Plainte créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plainte  $plainte
     * @return \Illuminate\Http\Response
     */
    public function show(Plainte $plainte, $id)
    {
        
        $plainte = Plainte::find($id);

        return view('/content/table/table-bootstrap/profil_victime_plainte', compact('plainte'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plainte  $plainte
     * @return \Illuminate\Http\Response
     */
    public function edit(Plainte $plainte, $id)
    {
        $plainte = Plainte::find($id);
        return view('/content/table/table-bootstrap/edit_plainte', compact('plainte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plainte  $plainte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'citoyen' => 'required',
            'details' => 'required',
            'dsuspects' => 'required',
            'noms' => 'required',
        ]);

        $plainte = Plainte::find($id);

        // if (isset($request->img)) {
        //     $path = $request->file('img')->storeAs('public', "image-plainte-modifiee-" . time() . "." . $request->file('img')->getClientOriginalExtension());
        // } else {
        //     $path = "";
        // }
        // $plainte->img = $path;
        // $plainte->nom = $request->nom;
        // $plainte->prenom = $request->prenom;
        // $plainte->datenaissance = $request->datenaissance;
        // $plainte->telephone = $request->telephone;
        // $plainte->gang = $request->gang;
        // $plainte->motif = $request->motif;
        // $plainte->details = $request->details;
        // $plainte->dsuspects = $request->dsuspects;
        // $plainte->noms = $request->noms;
        
         $input = $request->all();
        
        $input['modified_by'] = auth()->user()->noms;
        
        $plainte->update($input);
        
        return redirect()->route('index.plainte')
            ->with('success', 'Plainte créée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plainte  $plainte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plainte $plainte, $id)
    {
        $plainte = Plainte::find($id);
        $plainte->delete($id);
        return redirect()->route('index.plainte')
            ->with('success', 'Plainte supprimé créée avec succès !');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plainte  $plainte
     * @return \Illuminate\Http\Response
     */
    public function archive(Plainte $plainte, $id)
    {
        $plainte = Plainte::find($id);
        $plainte->archive = "1";

        $plainte->save();

        return redirect()->route('index.plainte')
            ->with('success', 'Plainte archivé avec succès');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plainte  $plainte
     * @return \Illuminate\Http\Response
     */
    public function desarchive(Plainte $plainte, $id)
    {
        $plainte = Plainte::find($id);
        $plainte->archive = "0";

        $plainte->save();

        return redirect()->route('index.plainte')
            ->with('success', 'Plainte désarchivé avec succès');

    }

}
