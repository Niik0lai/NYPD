<?php

namespace App\Http\Controllers;

use App\Models\VolVehicule;
use App\Models\User;
use Illuminate\Http\Request;

class VolVehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        
        $volVehicules = VolVehicule::all();

        $users = User::all();
        return view('/content/table/table-bootstrap/index_vol_vehicule', compact('volVehicules'),compact('users'));
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
    // return $request->all();
        $volVehicule = new VolVehicule();

        $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'plaque' => 'required',
            'couleur' => 'required',
            'date' => 'required',
            'suspect' => 'required',
            'model'=>'required',
            'cassier_judiciaires_id'=>'required'
        ]);
        
        $volVehicule->noms = $request->noms;
        $volVehicule->citoyen = $request->citoyen;
        $volVehicule->cassier_judiciaires_id = $request->cassier_judiciaires_id;
        $volVehicule->plaque = $request->plaque;
        $volVehicule->couleur = $request->couleur;
        $volVehicule->date = $request->date;
        $volVehicule->suspect = $request->suspect;
        $volVehicule->model = $request->model;

        $volVehicule->save();
        return redirect()->route('index.volvehicule')
            ->with('success', 'Vol de véhicule créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VolVehicule  $volVehicule
     * @return \Illuminate\Http\Response
     */
    public function show(VolVehicule $volVehicule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolVehicule  $volVehicule
     * @return \Illuminate\Http\Response
     */
    public function edit(VolVehicule $volVehicule, $id)
    {

        $volVehicule = VolVehicule::find($id);
        return view('/content/table/table-bootstrap/edit_vol_vehicule', compact('volVehicule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VolVehicule  $volVehicule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VolVehicule $volVehicule, $id)
    {
        //return $request->all();
//     Todo: defini le type de variable dans la regle de validation
        $request->validate([

            'noms' => 'required',
            'citoyen' => 'required',
            'plaque' => 'required',
            'couleur' => 'required',
            'date' => 'required',
            'suspect' => 'required',
            'model'=>'required',
        ]);

// On ne passe pas le model en paramettre a la fonction
        $volVehicule = VolVehicule::find($id);

        $volVehicule->noms = $request->noms;
        $volVehicule->citoyen = $request->citoyen;
        $volVehicule->plaque = $request->plaque;
        $volVehicule->couleur = $request->couleur;
        $volVehicule->date = $request->date;
        $volVehicule->suspect = $request->suspect;
        $volVehicule->model = $request->model;
        
        $volVehicule->save();
        return redirect()->route('index.volvehicule')
            ->with('success', 'Vol de véhicule modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolVehicule  $volVehicule
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolVehicule $volVehicule, $id)
    {
        $volVehicule = VolVehicule::find($id);
        $volVehicule->delete($id);

        return redirect()->route('index.volvehicule')
            ->with('success', 'Vol de véhicule supprimé avec succès');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\VolVehicule  $volVehicule
    * @return \Illuminate\Http\Response
    */
   public function archive(VolVehicule $volVehicule, $id)
   {
      
       $volVehicule = VolVehicule::find($id);
       $volVehicule->archive = "1";


       $volVehicule->save();
       return redirect()->route('index.volvehicule')
           ->with('success', 'Vol de véhicule archivé avec succès');
   }
   /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\VolVehicule  $volVehicule
   * @return \Illuminate\Http\Response
   */
  public function desarchive(VolVehicule $volVehicule, $id)
  {
     
      $volVehicule = VolVehicule::find($id);
      $volVehicule->archive = "0";


      $volVehicule->save();
      return redirect()->route('index.volvehicule')
          ->with('success', 'Vol de véhicule désarchivé avec succès');
  }

}
