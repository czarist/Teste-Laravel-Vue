<?php

namespace Database\Seeders;

use App\Models\Associado;
use App\Models\TodosTiposUsers;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PopulateAssociados extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cpf_correto = DB::table('cpf_correto')->get();


        // pergar o $cpf->cpf e formatar para o padrão do brasil
        // $cpf_formatado = str_replace('.', '', $cpf_correto->cpf);
        // $cpf_formatado = str_replace('-', '', $cpf_formatado);

        // $cpf_formatado = substr($cpf_formatado, 0, 3).'.'.substr($cpf_formatado, 3, 3).'.'.substr($cpf_formatado, 6, 3).'-'.substr($cpf_formatado, 9, 2);

        // dd($cpf_formatado, $cpf_correto->cpf);
        

        // $nome_certo = DB::table('nome_certo')->get();

        $count = $cpf_correto->count();
        
        //atualizar o a coluna nome do banco nome_cento na cpf_correto
        // for ($i=0; $i < $count; $i++) { 
        //     DB::table('cpf_correto')->where('id', $cpf_correto[$i]->id)->update(['nome' => $nome_certo[$i]->nome]);
        // }

        foreach($cpf_correto as $cpf)
        {
    
            $cpf_formatado = str_replace('.', '', $cpf->cpf);
            $cpf_formatado = str_replace('-', '', $cpf_formatado);
    
            $cpf_formatado = substr($cpf_formatado, 0, 3).'.'.substr($cpf_formatado, 3, 3).'.'.substr($cpf_formatado, 6, 3).'-'.substr($cpf_formatado, 9, 2);
    
            $user = User::create(
                [
                    'name' => $cpf->nome,
                    'email' => $cpf->email,
                    'password' => Hash::make('AssociadoAntigo123!@#'),
                    'cpf' => $cpf_formatado,
                ]
            );

            $associado = Associado::create([
                'numero_socio' => $cpf->numero_socio,
                'user_id' => $user->id
            ]);

            TodosTiposUsers::create(
                [
                    'tipo_id' => '4',
                    'user_id' =>  $user->id
                ]
            );

            TodosTiposUsers::create(
                [
                    'tipo_id' => '3',
                    'user_id' =>  $user->id
                ]
            );
        }
    }
}
