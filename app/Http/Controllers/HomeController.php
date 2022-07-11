<?php

namespace App\Http\Controllers;

use App\Models\Associado;
use App\Models\PagSeguroPgto;
use App\Models\RegionalSuldeste;
use App\Models\TodosTiposUsers;
use App\Models\User;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
}
