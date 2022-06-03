<?php

namespace Database\Seeders;

use App\Models\PagSeguroPgto;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RetirarPagamentosCancelados extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pgto = PagSeguroPgto::select('id', 'status_id', 'created_at', 'updated_at')
            ->where('status_id', 7)
            ->where('updated_at', '<', Carbon::now()->subDays(15))
            ->get()
            ->each(function ($pgto) {
                $pgto->delete();
            });
    }
}
