<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CatProdEditProdTransComunic extends Model
{
    use SoftDeletes;

    protected $table = 'cat_prod_edit_trans_comunic';
    protected $fillable = ['descricao'];
}
