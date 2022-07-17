<?php

namespace App\Http\Controllers;

use App\Models\CassierJudiciaire;
use App\Models\User;
use Illuminate\Http\Request;

class CassierJudiciaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cassierJudiciaires = CassierJudiciaire::all();
        $users = User::all();
        return view('/content/table/table-bootstrap/index_casier', compact('cassierJudiciaires'), compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('/content/table/table-bootstrap/create_casier', compact('users'));
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
            'statut' => 'required',
            'datedenaissance' => 'required',
            'telephone'=>'required',
            'gang' => 'required',
            'metier' => 'required',
            'noms' => 'required',
            'taille'=>'required',
            'sexe'=>'required',
        ]);
        
        $input = $request->except('image');
         if (!empty($request->image)) {
                $input['img'] = CassierJudiciaire::fileUpload($request['image'], CassierJudiciaire::path_citizen_image()); // upload file
            }

        // On ne passe pas le model en paramettre a la fonction
        CassierJudiciaire::create($input);
        return redirect()->route('index.casier')
            ->with('success', 'Casier créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function show(CassierJudiciaire $cassierJudiciaire, $id)
    {
        $cassierJudiciaire = CassierJudiciaire::find($id);
        $cassierJudiciaire->loadMissing('faits');
        $cassierJudiciaire->loadMissing('peines');

        return view('/content/table/table-bootstrap/profil_casier', compact('cassierJudiciaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function edit(CassierJudiciaire $cassierJudiciaire, $id)
    {
        
        $cassierJudiciaire = CassierJudiciaire::find($id);
        return view('/content/table/table-bootstrap/edit_casier', compact('cassierJudiciaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function faits(CassierJudiciaire $cassierJudiciaire, $id)
    {
        
        $cassierJudiciaire = CassierJudiciaire::find($id);
        return view('/content/table/table-bootstrap/faits_casier', compact('cassierJudiciaire'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function peines(CassierJudiciaire $cassierJudiciaire, $id)
    {
        
        $cassierJudiciaire = CassierJudiciaire::find($id);
        return view('/content/table/table-bootstrap/peines_casier', compact('cassierJudiciaire'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CassierJudiciaire $cassierJudiciaire, $id)
    {
       // return $request->all();
        
         $request->validate([
            'image' => 'nullable',
            'nom' => 'required',
            'statut' => 'required',
            'datedenaissance' => 'required',
            'telephone'=>'required',
            'gang' => 'required',
            'metier' => 'required',
            'noms' => 'required',
            'taille'=>'required',
            'sexe'=>'required',
        ]);

        $cassierJudiciaire = CassierJudiciaire::find($id);
        
        $input = $request->except('image');
        
         if (!empty($request->image)) {
            $old_img = '';
            $old_img = isset($cassierJudiciaire) ? $cassierJudiciaire->image : '';
            $input['img'] = CassierJudiciaire::fileUpload($request['image'], CassierJudiciaire::path_citizen_image(), $old_img); // upload file
        }
        
        $cassierJudiciaire->update($input);
        
        return redirect()->route('index.casier')
            ->with('success', 'Casier créée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(CassierJudiciaire $cassierJudiciaire, $id)
    {
        
        $cassierJudiciaire = CassierJudiciaire::find($id);

        $cassierJudiciaire->delete($id);
        return redirect()->route('index.casier')
            ->with('success', 'Casier supprimé avec succès !');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function archive(CassierJudiciaire $cassierJudiciaire, $id)
    {
        
        $cassierJudiciaire = CassierJudiciaire::find($id);

       // $cassierJudiciaire->delete($id);
        $cassierJudiciaire->archive = "1";
        $cassierJudiciaire->save();

        return redirect()->route('index.casier')
            ->with('success', 'Casier supprimé avec succès !');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CassierJudiciaire  $cassierJudiciaire
     * @return \Illuminate\Http\Response
     */
    public function desarchive(CassierJudiciaire $cassierJudiciaire, $id)
    {
        
        $cassierJudiciaire = CassierJudiciaire::find($id);

       // $cassierJudiciaire->delete($id);
        $cassierJudiciaire->archive = "0";
        $cassierJudiciaire->save();
        
        return redirect()->route('index.casier')
            ->with('success', 'Casier supprimé avec succès !');
    }
    
    public function notes($id){
        $cassierJudiciaire = CassierJudiciaire::find($id);
        return view('/content/table/table-bootstrap/notes_casier', compact('cassierJudiciaire'));
    }
    
    public function updatenotes(Request $request, $id){
         $cassierJudiciaire = CassierJudiciaire::find($id);
         
         $cassierJudiciaire->update([
           'notes'  => $request->notes
        ]);
        
        return back();
    }
    
}
