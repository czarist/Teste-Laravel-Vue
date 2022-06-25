<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acesso extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'pagina', 'link'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
