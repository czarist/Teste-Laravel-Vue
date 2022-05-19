<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AvaliadorExpocom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'avaliador',
        'avaliador_junior',
        'nacional_gp',
        'nacional_ij',
        'nacional_publicom'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');   
    }

    
}
