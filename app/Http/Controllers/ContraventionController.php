<?php

namespace App\Http\Controllers;

use App\Models\Contravention;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContraventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        
      
        $contraventions = Contravention::all();
        $user = Auth::user();
        return view('/content/table/table-bootstrap/index_contravention', compact('contraventions'),compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    public function regulation()
    {
        echo "helo";exit;

    }    public function code()
    {
echo "helo";exit;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $contravention = new Contravention();

        $request->validate([
            'noms' => 'required',
            'citoyen' => 'required',
            'raison' => 'required',
            'date' => 'required',
            'prix' => 'required',
            'paiement' => 'required',
        ]);
    Contravention::create($request->all());
        // $contravention->noms = $request->noms;
        // $contravention->citoyen = $request->citoyen;
        // $contravention->raison = $request->raison;
        // $contravention->date = $request->date;
        // $contravention->prix = $request->prix;
        // $contravention->cassier_judiciaires_id = $request->cassier_judiciaires_id;
        // $contravention->paiement = $request->paiement;

        // $contravention->save();
        
        return back()->with('success', 'Contravention créée avec succès !');
        // return redirect()->route('index.contravention')
        //     ->with('success', 'Contravention créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contravention  $contravention
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $contraventions = Contravention::all();

        $breadcrumbs = [['link' => "/", 'name' => "Contravention"], ['name' => "FiveAIM LPSD"]];
        return view('/content/table/table-bootstrap/index_contravention', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contravention  $contravention
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $contravention = Contravention::find($id);
        return view('/content/table/table-bootstrap/edit_contravention', compact('contravention'));
        // return view('/content/table/table-bootstrap/edit_contravention');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contravention  $contravention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $contravention = Contravention::find($id);

        $contravention->noms = $request->noms;
        $contravention->citoyen = $request->citoyen;
        $contravention->raison = $request->raison;
        $contravention->date = $request->date;
        $contravention->prix = $request->prix;
        $contravention->paiement = $request->paiement;

        $contravention->save();

        return redirect()->route('index.contravention')->with('success', 'Contravention modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contravention  $contravention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contravention $contravention, $id)
    {

        $contravention = Contravention::find($id);
        $contravention->delete($id);

        return redirect()->route('index.contravention')
            ->with('success', 'Contravention deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contravention  $contravention
     * @return \Illuminate\Http\Response
     */
    public function archive(Contravention $contravention, Request $request, $id)
    {

        $contravention = Contravention::find($id);

        $contravention->archive = "1";

        $contravention->save();
        return redirect()->route('index.contravention')
            ->with('success', 'Contravention archivé avec succès');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contravention  $contravention
     * @return \Illuminate\Http\Response
     */
    public function desarchive(Contravention $contravention, Request $request, $id)
    {

        $contravention = Contravention::find($id);

        $contravention->archive = "0";

        $contravention->save();
        return redirect()->route('index.contravention')
            ->with('success', 'Contravention archivé avec succès');
    }
}
