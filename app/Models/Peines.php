<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peines extends Model
{
    use HasFactory;
    protected $table = 'peines';
    public $timestamps = true;

    protected $fillable = [
        'cassier_judiciaire_id',
        'fr1',
        'am1',
        'date1',
        
    ];
}
