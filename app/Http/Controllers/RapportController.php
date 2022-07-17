<?php

namespace App\Http\Controllers;

use App\Models\Rapport;
use App\Models\User;
use App\Models\FaitsRapport;
use App\Models\Rapportphoto;

use Illuminate\Http\Request;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rapports = Rapport::all();
        return view('/content/table/table-bootstrap/index_rapport', compact('rapports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('/content/table/table-bootstrap/create_rapport' , compact('users'));
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
        //$rapport = new Rapport();
        $request->validate([
            'titre' => 'required',
            'nom' => 'nullable',
            'prenom' => 'nullable',
            'details' => 'required',
            'image' => 'nullable',
            'img2' => 'nullable',
            'img3' => 'nullable',
            'img4' => 'nullable',
            'noms' => 'required',
        ]);

        // if (isset($request->img1)) {
        //     $path1 = $request->file('img1')->storeAs('public', "image-rapport-" . time() . "." . $request->file('img1')->getClientOriginalExtension());
        // } else {
        //     $path1 = "";
        // } 

        // if (isset($request->img2)) {
        //     $path2 = $request->file('img2')->storeAs('public', "image-rapport-2-" . time() . "." . $request->file('img2')->getClientOriginalExtension());
        // } else {
        //     $path2 = "";
        // } 

        // if (isset($request->img3)) {
        //     $path3 = $request->file('img3')->storeAs('public', "image-rapport-3-" . time() . "." . $request->file('img3')->getClientOriginalExtension());
        // } else {
        //     $path3 = "";
        // } 

        // if (isset($request->img4)) {
        //     $path4 = $request->file('img4')->storeAs('public', "image-rapport-4-" . time() . "." . $request->file('img4')->getClientOriginalExtension());
        // } else {
        //     $path4 = "";
        // } 
        
        $input = $request->except('image');
        //  if (!empty($request->image)) {
        //     foreach($request->image as $image){
        //         $input['image'] = Rapport::fileUpload($request['image'], Rapport::path_rapport_image()); // upload file
                
        //         Rapportphoto::create([
        //             'rapport_id'=>
        //         ])
        //     }
        // }
        
        $input['created_by'] = auth()->user()->noms;
        
        $rap = Rapport::create($input);
        
          if (!empty($request->image)) {
            foreach($request->image as $image){
              
                $rapimg = Rapport::fileUpload($image, Rapport::path_rapport_image()); // upload file
                
                Rapportphoto::create([
                    'rapport_id'=> $rap->id,
                    'image'=> $rapimg
                ]);
            }
        }
        
        
        
        // $rapport->titre = $request->titre;
        // $rapport->nom = $request->nom;
        // $rapport->prenom = $request->prenom;
        // $rapport->details = $request->details;
        // $rapport->img1 = $path1;
        // $rapport->img2 = $path2;
        // $rapport->img3 = $path3;
        // $rapport->img4 = $path4;
        // $rapport->noms = $request->noms;

        //$rapport->save();
        return redirect()->route('index.rapport')
            ->with('success', 'Rapport créée avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function show(Rapport $rapport, $id)
    {
        $rapport = Rapport::find($id);
        //return $rapport->rapportphoto;
        $rapport->loadMissing('faits');

        return view('/content/table/table-bootstrap/profil_rapport', compact('rapport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function edit(Rapport $rapport, $id)
    {
        $rapport = Rapport::find($id);
        return view('/content/table/table-bootstrap/edit_rapport', compact('rapport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function faits(Rapport $rapport, $id)
    {
        $rapport = Rapport::find($id);
        $user_name = auth()->user()->noms;
        
        return view('/content/table/table-bootstrap/faits_rapport', compact('rapport', 'user_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rapport $rapport, $id)
    {
        
        $request->validate([
            'titre' => 'required',
            'nom' => 'nullable',
            'prenom' => 'nullable',
            'details' => 'required',
            'img1' => 'nullable',
            'img2' => 'nullable',
            'img3' => 'nullable',
            'img4' => 'nullable',
            'noms' => 'nullable',
        ]);
         
       $rapport = Rapport::find($id);

        $input = $request->except('image');
        
        if (!empty($request->image)) {
            $old_img = '';
            $old_img = isset($rapport) ? $rapport->image : '';
            $input['image'] = Rapport::fileUpload($request['image'], Rapport::path_rapport_image(), $old_img); // upload file
        }
        
        
        $input['updated_by'] = auth()->user()->noms;
        
        $rapport->update($input);
        
      
        
        // $rapport->update([
        //     'updated_by'=>auth()->user()->noms;
        //     ]);
        // if (isset($request->img1)) {
        //     $path1 = $request->file('img1')->storeAs('public', "image-rapport-edit-" . time() . "." . $request->file('img1')->getClientOriginalExtension());
        // } else {
        //     $path1 = "";
        // } 

        // if (isset($request->img2)) {
        //     $path2 = $request->file('img2')->storeAs('public', "image-rapport-edit-2-" . time() . "." . $request->file('img2')->getClientOriginalExtension());
        // } else {
        //     $path2 = "";
        // } 

        // if (isset($request->img3)) {
        //     $path3 = $request->file('img3')->storeAs('public', "image-rapport-edit-3-" . time() . "." . $request->file('img3')->getClientOriginalExtension());
        // } else {
        //     $path3 = "";
        // } 

        // if (isset($request->img4)) {
        //     $path4 = $request->file('img4')->storeAs('public', "image-rapport-edit-4-" . time() . "." . $request->file('img4')->getClientOriginalExtension());
        // } else {
        //     $path4 = "";
        // } 
        // $rapport->titre = $request->titre;
        // $rapport->nom = $request->nom;
        // $rapport->prenom = $request->prenom;
        // $rapport->details = $request->details;
        // $rapport->img1 = $path1;
        // $rapport->img2 = $path2;
        // $rapport->img3 = $path3;
        // $rapport->img4 = $path4;
        // $rapport->noms = $request->noms;

        //$rapport->save();
        return redirect()->route('index.rapport')
            ->with('success', 'Rapport créée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rapport $rapport, $id)
    {
        $rapport = Rapport::find($id);

        $rapport->delete($id);
        return redirect()->route('index.rapport')
            ->with('success', 'Rapport supprimé avec succès !');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function archive(Rapport $rapport, $id)
    {
        $rapport = Rapport::find($id);

        $rapport->archive = "1";

        $rapport->save();

        return redirect()->route('index.rapport')
            ->with('success', 'Rapport archivé avec succès');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rapport  $rapport
     * @return \Illuminate\Http\Response
     */
    public function desarchive(Rapport $rapport, $id)
    {
        $rapport = Rapport::find($id);

        $rapport->archive = "0";

        $rapport->save();

        return redirect()->route('index.rapport')
            ->with('success', 'Rapport désarchivé avec succès');
    }
    
    public function removephoto($id){
        $rapport = Rapportphoto::find($id);
        
        $rapport->removeImage($rapport->path_rapport_image(), $rapport->image);
      
        $rapport->delete();
        
        return back();
    }
    
    public function addphoto($id){
        $rapport = Rapport::findOrFail($id);
        return view('/content/table/table-bootstrap/addraportphoto', compact('rapport'));
    }
    
    public function upphoto(Request $request){
        
         if (!empty($request->image)) {
            foreach($request->image as $image){
              
                $rapimg = Rapport::fileUpload($image, Rapport::path_rapport_image()); // upload file
                
                Rapportphoto::create([
                    'rapport_id'=> $request->rapport_id,
                    'image'=> $rapimg
                ]);
            }
        }
        
        return redirect()->route('show.rapport', $request->rapport_id);
    }
    
    public function editlist($id){
       $prison=  FaitsRapport::findOrFail($id);
        
        return view('/content/table/table-bootstrap/edit_details', compact('prison'));
    }
    
    public function updateeditlist($id, Request $request){
        $faits = FaitsRapport::findOrFail($id);
        $input = $request->all();
        $input['updated_by'] = auth()->user()->noms;
        
        $faits->update($input);
        
        return redirect()->route('index.rapport');
    }
    
    public function deleleList($id){
        $faits = FaitsRapport::findOrFail($id);
        
        $faits->delete();
        
        return back();
    }
}
