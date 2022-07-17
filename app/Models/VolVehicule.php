<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class VolVehicule extends Model
{
    use HasFactory;

    protected $table = 'vol_vehicules';
    public $timestamps = true;


    protected $guarded=[];
    
     public function cid(){
        return $this->hasOne(CassierJudiciaire::class, 'id','cassier_judiciaires_id');
    }
    
    public function getImage($name){
        $user =  User::where('noms', $name)->first();
        
        if(!empty($user->img)){
            return $user->img;       
        }else{
            return false;
        }
     
    }
    
      public function citizen(){
        return $this->hasOne(CassierJudiciaire::class,'id','citoyen');
    }
    
      public function selectCitizen($citizen){
        return $this->cassier_judiciaires_id == $citizen->id ? true : false;
        
    }
    
    public function path_avatar_image(){
        return 'uploaded_file/files/img/avatar/';
    }
}
