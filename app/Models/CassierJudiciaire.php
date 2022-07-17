<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CassierJudiciaire extends Model
{
    use HasFactory;
    protected $table = 'cassier_judiciaires';
    public $timestamps = true;

    protected $guarded=[];

    public function faits(){
        return $this->hasMany(FaitsCassier::class, 'cassier_judiciaire_id');
    }
    public function peines(){
        return $this->hasMany(Peines::class, 'cassier_judiciaire_id');
    }
    
     public function contraventions(){
        return $this->hasMany(Contravention::class, 'cassier_judiciaires_id');
    }
    
     public function ppa(){
        return $this->hasMany(Ppa::class, 'cassier_judiciaires_id');
    }
    
     public function volvehicule(){
        return $this->hasMany(VolVehicule::class, 'cassier_judiciaires_id');
    }
    
     public function cityvehicle(){
        return $this->hasMany(Cityvehicle::class, 'cassier_judiciaires_id');
    }
    
    public function amende(){
        return $this->hasMany(Amende::class, 'cassier_judiciaires_id');
    }
    
     public function vol(){
        return $this->hasMany(Vol::class, 'cassier_judiciaires_id');
    }
    
     public function plainte(){
        return $this->hasMany(Plainte::class, 'citoyen');
    }
    
     static function fileUpload($new_file, $path, $old_file_name = null)
    {
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        $file_name = time() . $new_file->getClientOriginalName();
        $destinationPath = public_path($path);

        if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {
            unlink($path . $old_file_name);
        }

        #original image upload
        $new_file->move($destinationPath, $file_name);
        

        return $file_name;
    }
    
    static function path_citizen_image(){
        return 'uploaded_file/files/img/citizen/';
    }
    
     static function path_default_image(){
        return 'uploaded_file/files/img/default/defaultCitizen.jpg';
    }
    
     public function getImage($name){
        $user =  User::where('noms', $name)->first();
        
        if(!empty($user->img)){
            return $user->img;       
        }else{
            return false;
        }
    }
    
     public function path_avatar_image(){
        return 'uploaded_file/files/img/avatar/';
    }
}
