<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function roleCount(){
        return User::where('role', $this->name)->count();
    }
    
    public function selectRole($user){
      return  $this->name == $user->role ? true : false;
    }
    
 
}
