<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonneRecherchee extends Model
{
    use HasFactory;
    protected $table = 'personne_recherchees';
    public $timestamps = true;



   protected $guarded = [];
   

    public function faits(){
        return $this->hasMany(Faits::class, 'personne_recherchee_id');
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
    
    
       static function path_avis_image(){
        return 'uploaded_file/files/img/avis/';
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
