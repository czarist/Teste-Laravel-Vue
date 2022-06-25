<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvaliacaoNacionalController extends Controller
{
    public function index()
    {
        return view('nacional.avaliacao.index');
    }
}
