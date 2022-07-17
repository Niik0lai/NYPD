<?php

namespace App\Http\Controllers;

use App\Models\Amende;
use App\Models\User;
use Illuminate\Http\Request;

class AmendeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $amendes = Amende::all();
        $users = User::all();
        return view('/content/table/table-bootstrap/index_amende', compact('amendes'),compact('users') );
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
        $amende = new Amende();

        $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'raison' => 'required',
            'date' => 'required',
            'prix' => 'required',
            'paiement' => 'required',
        ]);

        $amende->noms = $request->noms;
        $amende->citoyen = $request->citoyen;
        $amende->raison = $request->raison;
        $amende->date = $request->date;
        $amende->prix = $request->prix;
        $amende->cassier_judiciaires_id = $request->cassier_judiciaires_id;
        $amende->paiement = $request->paiement;

        $amende->save();
        return redirect()->route('index.amende')
            ->with('success', 'Amendes créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Amende  $amende
     * @return \Illuminate\Http\Response
     */
    public function show(Amende $amende)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Amende  $amende
     * @return \Illuminate\Http\Response
     */
    public function edit(Amende $amende, $id)
    {
        $amende = Amende::find($id);
        return view('/content/table/table-bootstrap/edit_amendes', compact('amende'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Amende  $amende
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amende $amende, $id)
    {

//     Todo: defini le type de variable dans la regle de validation
        $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'raison' => 'required',
            'date' => 'required',
            'prix' => 'required',
            'paiement' => 'required',
        ]);

// On ne passe pas le model en paramettre a la fonction
        $amende = Amende::find($id);

        $amende->noms = $request->noms;
        $amende->citoyen = $request->citoyen;
        $amende->raison = $request->raison;
        $amende->date = $request->date;
        $amende->prix = $request->prix;
        $amende->paiement = $request->paiement;

        $amende->save();

        return redirect()->route('index.amende')->with('success', 'Amende modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Amende  $amende
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amende $amende, $id)
    {
        $amende = Amende::find($id);
        $amende->delete($id);

        return redirect()->route('index.amende')
            ->with('success', 'Amende supprimé avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Amende  $amende
     * @return \Illuminate\Http\Response
     */
    public function archive(Amende $amende, Request $request, $id)
    {

        $amende = Amende::find($id);

        $amende->archive = "1";


        $amende->save();
        return redirect()->route('index.amende')
            ->with('success', 'Amende archivé avec succès');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Amende  $amende
     * @return \Illuminate\Http\Response
     */
    public function desarchive(Amende $amende, Request $request, $id)
    {

        $amende = Amende::find($id);

        $amende->archive = "0";


        $amende->save();
        return redirect()->route('index.amende')
            ->with('success', 'Amende désarchivé avec succès');
    }


}
