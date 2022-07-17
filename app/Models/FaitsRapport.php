<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaitsRapport extends Model
{
    use HasFactory;
    protected $table = 'faits_rapports';
    public $timestamps = true;

    protected $guarded=[];

    
}
