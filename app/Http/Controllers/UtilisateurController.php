<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Logo;
use App\Models\Lspd;
use App\Models\Codepanel;
use App\Models\CassierJudiciaire;
use App\Models\Amende;
use App\Models\Contravention;
use App\Models\Vol;
use App\Models\VolVehicule;
use App\Models\Rapport;
use App\Models\PersonneRecherchee;
use App\Models\Plainte;
use App\Models\Cityvehicle;
use App\Models\Ppa;

class UtilisateurController extends Controller
{
    
    public function __construct()
{
      //$this->middleware('auth');
}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        
        $users =  User::all();
        $roles = Role::all();
        
        return view('/content/table/table-bootstrap/index_utilisateur', compact('users', 'roles'));

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Utilisateur
     */
    protected function create(Request $request)
    {

        $request->validate([
            'img'=>'nullable',
            'noms' => ['required', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'pseudo' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        User::create([
            'img' =>  $request->img,
            'noms' => $request->noms,
            'name' => $request->name,
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return view('/content/table/table-bootstrap/home');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request)
    {
        $logo = Logo::first();
        $user = Auth::user();
        $lspd = Lspd::first();
        $codepanel = Codepanel::first();
        return view('/content/table/table-bootstrap/settings_utilisateur', compact('user','logo' , 'lspd', 'codepanel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function welcome(Request $request)
    {
        if (!Auth::user()){
            return redirect()->route('login');
        }
        
        $data = [];
        
        $data['agent'] = User::count();
        $data['citoyen'] = CassierJudiciaire::count();
        $data['amende'] = Amende::count();
        $data['amendeprix'] = Amende::where('paiement', 'Payé')->sum('prix');
        $data['contravention'] = Contravention::count();
        $data['vol'] = Vol::count();
        $data['volarchive'] = Vol::where('archive', 1)->count();
        $data['volvehicule'] = VolVehicule::count();
        $data['volvehiculearchive'] = VolVehicule::where('archive',1)->count();
        $data['rapport'] = Rapport::count();
        $data['rapportarchive'] = Rapport::where('archive',1)->count();
        $data['personneRecherchee'] = PersonneRecherchee::count();
        $data['personneRechercheearchive'] = PersonneRecherchee::where('archive',1)->count();
        $data['contraventionprix'] = Contravention::where('paiement', 'Payé')->sum('prix');
        $data['plainte'] = Plainte::count();
        $data['plaintearchive'] = Plainte::where('archive', 1)->count();
        $data['cityvehicle'] = Cityvehicle::count();
        $data['Ppa'] = Ppa::count();
        
        return view('/content/table/table-bootstrap/welcome', compact('data'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */    
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        
        return view('/content/table/table-bootstrap/edit_user', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        $user = Auth::user();

        $request->validate([
            'pseudo' => 'nullable',
            'name' => 'required',
            'email' => 'required',
        ]);

        $user->pseudo = $request->pseudo;
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return view('/content/table/table-bootstrap/infouser');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update_user(Request $request, User $user, $id)
    {
        
        $user = User::find($id);

        if($request->password){
            $request->validate([
                'pseudo' => 'nullable',
                'name' => 'nullable',
                'noms' => 'nullable',
                'role' => 'nullable',
                'mail' => 'required|unique:users,email,'.$id,
                'password' => 'required|confirmed',
            ],[
                'password.required' => "Password is required",    
                'password.confirmed' => "Password confirmation error",
                'mail.unique' => "Mail must be unique",
                'mail.required' => "Mail is required", 
            ]);
        }else{
              $request->validate([
                'pseudo' => 'nullable',
                'name' => 'nullable',
                'noms' => 'nullable',
                'role' => 'nullable',
                'mail' => 'required|unique:users,email,'.$id
            ],[
                'mail.required' => "Mail is required", 
                'mail.unique' => "Mail must be unique"
            ]);
        }
        
        if($request->password){
            $user->pseudo = $request->pseudo;
            $user->name = $request->name;
            $user->noms = $request->noms;
            $user->role = $request->role;
            $user->email = $request->mail;
            $user->password = Hash::make($request->password);
        }else{
        
            $user->pseudo = $request->pseudo;
            $user->name = $request->name;
            $user->noms = $request->noms;
            $user->role = $request->role;
            $user->email = $request->mail;
        }
        
       // return $user;

        $user->save();
        
        return back();
        return view('/content/table/table-bootstrap/infouser');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request, User $user)
    {
        
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);

        $user->save();

        return view('/content/table/table-bootstrap/password');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request, User $user)
    {
        
        // return auth()->user()->path_avatar_image() . auth()->user()->img;
        $user = Auth::user();

        $request->validate([
            'img' => 'required',
        ]);

        if (isset($request->img)) {
            //$path = $request->file('img')->storeAs('public', "image-profil-user-" . time() . "." . $request->file('img')->getClientOriginalExtension());
            if (!empty($request->img)) {
                $path = User::fileUpload($request['img'], User::path_avatar_image()); // upload file
            }
        }
    
        $user->img = $path;

        $user->save();

        return view('/content/table/table-bootstrap/profil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $utilisateur, $id)
    {
        $user = User::find($id);
        $user->delete($id);

        return redirect()->route('index.user')
            ->with('success', 'Utilisateur supprimé avec succès');
    }
    
    public function logoupload(Request $request){
        $input = [];
         if (!empty($request->image)) {
                $input['image'] = Logo::fileUpload($request['image'], Logo::path_logo_image()); // upload file
            }
        Logo::create($input);
    }
    
    public function logouploadupdate(Request $request){
       $logo = Logo::first();
        
        $input = [];
         if (!empty($request->image)) {
            $old_img = '';
            $old_img = isset($logo) ? $logo->image : '';
            $input['image'] = Logo::fileUpload($request['image'], Logo::path_logo_image(), $old_img); // upload file
        }
        
        $logo->update($input);
        
        return back();
        
        
    }
    
    public function lspd(){
        
        $lspd = Lspd::first();
        return view('/content/table/table-bootstrap/lspd', compact('lspd'));
    }
    
    public function codepanel(){
        $codepanel = Codepanel::first();
        return view('/content/table/table-bootstrap/codepanel', compact('codepanel'));
    }
    
    public function lspdcreate(Request $request){
        Lspd::create($request->all());
        
        return back();
    }
    
     public function lspdupdate(Request $request){
        $lspd = Lspd::first();
        $lspd->update($request->all());
        
        return back();
    }
    
     public function codepanelcreate(Request $request){
        Codepanel::create($request->all());
        
        return back();
    }
    
     public function codepanelupdate(Request $request){
        $lspd = Codepanel::first();
        $lspd->update($request->all());
        
        return back();
    }
}
