<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Plainte extends Model
{
    use HasFactory;
    protected $table = 'plaintes';
    public $timestamps = true;

    protected $guarded = [];
    
    public function citizen(){
        return $this->hasOne(CassierJudiciaire::class,'id','citoyen');
    }
    
   
    
    public function getImage($name){
        $user =  User::where('noms', $name)->first();
        
        if(!empty($user->img)){
            return $user->img;       
        }else{
            return false;
        }
     
    }
    
    public function selectCitizen($citizen){
        return $this->citoyen == $citizen->id ? true : false;
        
    }
    
     public function path_avatar_image(){
        return 'uploaded_file/files/img/avatar/';
    }
}
