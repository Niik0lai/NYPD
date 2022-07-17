<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lspd extends Model
{
    use HasFactory;
    
    protected $guarded= [];
    
     public function path_avatar_image(){
        return 'uploaded_file/files/img/avatar/';
    }
}
