<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapportphoto extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    
    static function removeImage($path, $old_file_name)
    {
        if (isset($old_file_name) && $old_file_name != "" && file_exists($path . $old_file_name)) {

            unlink($path . $old_file_name);
        }

        return true;
    }
    
     static function path_rapport_image(){
        return 'uploaded_file/files/img/rapport/';
    }
}
