<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornecedores = fornecedores::latest()->paginate(5);

        return view('fornecedores/index', compact('fornecedores'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fornecedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cnpj' => 'required',
            'razao_social' => 'required',
            'nome_fantasia' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'dados_bancarios' => 'required',
            'estado' => 'required',
            'cidade' => 'required',
            'bairro' => 'required',
            'endereco' => 'required',
            'CEP' => 'required',
            'detail' => 'required'
        ]);

        fornecedores::create($request->all());

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor adicionado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fornecedores  $fornecedores
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fornecedores = Fornecedores::find($id);
        return view('fornecedores.edit', compact('fornecedores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fornecedores  $fornecedores
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fornecedores = Fornecedores::find($id);
        return view('fornecedores.edit', compact('fornecedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fornecedores  $fornecedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cnpj' => 'required',
            'razao_social' => 'required',
            'nome_fantasia' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'dados_bancarios' => 'required',
            'estado' => 'required',
            'bairro' => 'required',
            'endereco' => 'required',
            'CEP' => 'required',
            'detail'
        ]);

        Fornecedores::find($id)->update($request->all());

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fornecedores  $fornecedores
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // echo '<pre>';
        // print_r(Fornecedores::find($id));
        // echo '</pre>';

        Fornecedores::find($id)->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor deletado com exito');
    }
}
