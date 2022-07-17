<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;
    
    protected $guarded=[];
    
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
    
    static function path_logo_image(){
        return 'uploaded_file/files/img/logo/';
    }
    

}
