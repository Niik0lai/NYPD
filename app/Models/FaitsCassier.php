<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaitsCassier extends Model
{
    use HasFactory;
    protected $table = 'faits_cassiers';
    public $timestamps = true;

    protected $fillable = [
        'cassier_judiciaire_id',
        'fr1',
        'am1',
        'date1',
        
    ];
}
