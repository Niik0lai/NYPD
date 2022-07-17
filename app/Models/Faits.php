<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faits extends Model
{
    use HasFactory;
    protected $table = 'faits';
    public $timestamps = true;

    protected $fillable = [
        'personne_recherchee_id',
        'fr1',
        'am1',
        'date1',
        
    ];
}
