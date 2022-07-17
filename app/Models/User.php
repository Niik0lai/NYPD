<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'img','noms','name', 'pseudo', 'email', 'role', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
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
    
    static function path_avatar_image(){
        return 'uploaded_file/files/img/avatar/';
    }
}
