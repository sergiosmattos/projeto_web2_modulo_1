<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function viewProduto($id) {

        $produto = Produto::findOrFail(Operations::decryptId($id));
        $user = User::findOrFail(session()->get('user.id'));

        return view('produto-page', [
            'produto' => $produto,
        ]);
    }

    public function newProduto() {
        return view('cadastro-produto');
    }

    public function submitNewProduto(Request $request) {

        $request->validate(
            [
                'produto_nome' => 'required|min:3|max:200',
                'produto_preco' => 'required|numeric|min:0',
                'produto_descricao' => 'nullable',
                'produto_quantidade' => 'required|integer|min:0',
            ],
            [
                'produto_nome.required' => "O nome é obrigatório.",
                'produto_nome.min' => "O nome deve conter no mínimo :min caracteres.",
                'produto_nome.max' => "O nome deve conter no máximo :max caracteres.",

                'produto_preco.required' => "O preço é obrigatório.",
                'produto_preco.numeric' => "O preço deve ser um número.",
                'produto_preco.min' => "O preço não pode ser negativo.",

                'produto_quantidade.required' => "A quantidade é obrigatória.",
                'produto_quantidade.integer' => "A quantidade deve ser um número inteiro.",
                'produto_quantidade.min' => "A quantidade não pode ser negativa.",
            ]
        );

        $produto = new Produto();

        $produto->nome = $request->produto_nome;
        $produto->preco = $request->produto_preco;
        $produto->descricao = $request->produto_descricao;
        $produto->quantidade = $request->produto_quantidade;

        $produto->save();

        return redirect('/');

    }
    public function adminDelete($id)
    {
        Produto::findOrFail(Operations::decryptId($id))->delete();
        return redirect()->route('admin_dashboard')->with('success', 'Produto deletado.');
    }

    public function adminRestore($id)
    {
        Produto::withTrashed()->findOrFail(Operations::decryptId($id))->restore();
        return redirect()->route('admin_dashboard')->with('success', 'Produto restaurado.');
    }

    public function adminForceDelete($id)
    {
        Produto::withTrashed()->findOrFail(Operations::decryptId($id))->forceDelete();
        return redirect()->route('admin_dashboard')->with('success', 'Produto deletado permanentemente.');
    }

    public function adminEdit($id)
    {
        $produto = Produto::withTrashed()->findOrFail(Operations::decryptId($id));
        return view('cadastro-produto', ['editProduto' => $produto]);
    }

    public function adminEditSubmit(Request $request, $id)
    {
        $request->validate([
            'produto_nome'       => 'required|min:3|max:200',
            'produto_preco'      => 'required|numeric|min:0',
            'produto_descricao'  => 'nullable',
            'produto_quantidade' => 'required|integer|min:0',
        ]);

        $produto            = Produto::withTrashed()->findOrFail(Operations::decryptId($id));
        $produto->nome       = $request->produto_nome;
        $produto->preco      = $request->produto_preco;
        $produto->descricao  = $request->produto_descricao;
        $produto->quantidade = $request->produto_quantidade;

        $produto->save();

        return redirect()->route('admin_dashboard')->with('success', 'Produto atualizado.');
    }
}
