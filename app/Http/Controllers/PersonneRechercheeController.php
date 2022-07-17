<?php

namespace App\Http\Controllers;

use App\Models\PersonneRecherchee;
use App\Models\User;
use Illuminate\Http\Request;

class PersonneRechercheeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personneRecherchees = PersonneRecherchee::all();
        return view('/content/table/table-bootstrap/index_personne_recherchee', compact('personneRecherchees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personneRecherchees = PersonneRecherchee::all();

        $users = User::all();
        return view('/content/table/table-bootstrap/create_personne_recherchee', compact('personneRecherchees'), compact('users'));
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
            'img' => 'nullable',
            'nom' => 'required',
            'prenom' => 'required',
            'datenaissance' => 'required',
            'telephone' => 'required',
            'sexe'=>'required',
            'gang' => 'required',
            'metier' => 'required',
            'dsuspects' => 'required',
            'noms' => 'required',
        ]);

        // if (isset($request->img)) {
        //     $path = $request->file('img')->storeAs('public', "image-personne_recherchee-" . time() . "." . $request->file('img')->getClientOriginalExtension());
        // } else {
        //     $path = "";
        // }
        $input = $request->except('img');
        
         if (!empty($request->img)) {
            $input['img'] = PersonneRecherchee::fileUpload($request['img'], PersonneRecherchee::path_avis_image()); // upload file
        }
            
       PersonneRecherchee::create($input);
        
        // $personneRecherchee->img = $input['img'];

        // $personneRecherchee->nom = $request->nom;
        // $personneRecherchee->prenom = $request->prenom;
        // $personneRecherchee->datenaissance = $request->datenaissance;
        // $personneRecherchee->telephone = $request->telephone;
        // $personneRecherchee->gang = $request->gang;
        // $personneRecherchee->motif = $request->motif;
        // $personneRecherchee->dsuspects = $request->dsuspects;
        // $personneRecherchee->noms = $request->noms;

        return redirect()->route('index.personnerecherchee')
            ->with('success', 'Avis de recherche créée avec succès !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function show(PersonneRecherchee $personneRecherchee, $id)
    {

        $personneRecherchee = PersonneRecherchee::find($id);

        $personneRecherchee->loadMissing('faits');

        $breadcrumbs = [['link' => "/", 'name' => "Acceuil"], ['name' => "FiveAIM LPSD"]];
        return view('/content/table/table-bootstrap/profil_personne_recherchee', compact('personneRecherchee'), [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function edit(PersonneRecherchee $personneRecherchee, $id)
    {

        $personneRecherchee = PersonneRecherchee::find($id);
        return view('/content/table/table-bootstrap/edit_personne_recherchee', compact('personneRecherchee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function faits(PersonneRecherchee $personneRecherchee, $id)
    {
        $personneRecherchee = PersonneRecherchee::find($id);
        
        return view('/content/table/table-bootstrap/faits_personne_recherchee', compact('personneRecherchee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'img' => 'nullable',
            'nom' => 'required',
            'prenom' => 'required',
            'datenaissance' => 'required',
            'telephone' => 'required',
            'gang' => 'required',
            'motif' => 'required',
            'dsuspects' => 'required',
            'noms' => 'required',
        ]);

        // On ne passe pas le model en paramettre a la fonction
        $personneRecherchee = PersonneRecherchee::find($id);
        
        
        $input = $request->except('img');
        
        if (!empty($request->img)) {
            $old_img = '';
            $old_img = isset($personneRecherchee) ? $personneRecherchee->img : '';
            $input['img'] = PersonneRecherchee::fileUpload($request['img'], PersonneRecherchee::path_avis_image(), $old_img); // upload file
        }
        
        
       $personneRecherchee->update($input); 
        // $personneRecherchee->img = $input['img'];

        // $personneRecherchee->nom = $request->nom;
        // $personneRecherchee->prenom = $request->prenom;
        // $personneRecherchee->datenaissance = $request->datenaissance;
        // $personneRecherchee->telephone = $request->telephone;
        // $personneRecherchee->gang = $request->gang;
        // $personneRecherchee->motif = $request->motif;
        // $personneRecherchee->dsuspects = $request->dsuspects;
        // $personneRecherchee->noms = $request->noms;

        // $personneRecherchee->save();
        return redirect()->route('index.personnerecherchee')
            ->with('success', 'Avis de recherche créée avec succès !');

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function update_faits(Request $request, PersonneRecherchee $personneRecherchee, $id)
    {
        //   Todo: defini le type de variable dans la regle de validation
        $request->validate([
            'fr1' => 'nullable',
            'am1' => 'nullable',
            'date1' => 'nullable',

        ]);

        // On ne passe pas le model en paramettre a la fonction
        $personneRecherchee = PersonneRecherchee::find($id);

        $personneRecherchee->fr1 = $request->fr1;
        $personneRecherchee->am1 = $request->am1;
        $personneRecherchee->date1 = $request->date1;

        $personneRecherchee->save();
        return redirect()->route('index.personnerecherchee')
            ->with('success', 'Avis de recherche créée avec succès !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonneRecherchee $personneRecherchee, $id)
    {
        $personneRecherchee = PersonneRecherchee::find($id);
        $personneRecherchee->delete($id);
        return redirect()->route('index.personnerecherchee')
            ->with('success', 'Avis de recherche supprimé avec succès !');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function archive(PersonneRecherchee $personneRecherchee, Request $request, $id)
    {

        $personneRecherchee = PersonneRecherchee::find($id);

        $personneRecherchee->archive = "1";

        $personneRecherchee->save();

        return redirect()->route('index.personnerecherchee')
            ->with('success', 'Avis de recherche archivé avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonneRecherchee  $personneRecherchee
     * @return \Illuminate\Http\Response
     */
    public function desarchive(PersonneRecherchee $personneRecherchee, Request $request, $id)
    {

        $personneRecherchee = PersonneRecherchee::find($id);

        $personneRecherchee->archive = "0";

        $personneRecherchee->save();

        return redirect()->route('index.personnerecherchee')
            ->with('success', 'Contravention archivé avec succès');
    }

}
