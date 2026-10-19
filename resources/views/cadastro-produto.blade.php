@use(App\Services\Operations)

@extends('layouts.form-layout')

@section('form-content')

    <form action="{{ isset($editProduto) ? route('admin_edit_produto_submit', Operations::encryptId($editProduto->id)) : route('submit_new_produto') }}"
          method="POST" novalidate autocomplete="off">
        @csrf

        <h5 class="mb-4 text-center">
            {{ isset($editProduto) ? 'Editar produto' : 'Novo produto' }}
        </h5>

        <div class="mb-3">
            <label for="produto_nome" class="form-label">Nome</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-tag"></i>
                </span>
                <input type="text" class="form-control" id="produto_nome" name="produto_nome"
                       value="{{ old('produto_nome', $editProduto->nome ?? '') }}">
            </div>
            @error('produto_nome')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="produto_preco" class="form-label">Preço (R$)</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-coins"></i>
                </span>
                <input type="number" step="0.01" min="0" class="form-control" id="produto_preco" name="produto_preco"
                       value="{{ old('produto_preco', $editProduto->preco ?? '') }}">
            </div>
            @error('produto_preco')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="produto_quantidade" class="form-label">Quantidade</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </span>
                <input type="number" step="1" min="0" class="form-control" id="produto_quantidade" name="produto_quantidade"
                       value="{{ old('produto_quantidade', $editProduto->quantidade ?? '') }}">
            </div>
            @error('produto_quantidade')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="produto_descricao" class="form-label">Descrição</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-align-left"></i>
                </span>
                <textarea id="produto_descricao" name="produto_descricao" class="form-control" rows="3">{{ old('produto_descricao', $editProduto->descricao ?? '') }}</textarea>
            </div>
            @error('produto_descricao')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-danger w-100">
                <i class="fa-solid fa-{{ isset($editProduto) ? 'floppy-disk' : 'circle-plus' }}"></i>
                &nbsp;&nbsp;{{ isset($editProduto) ? 'Salvar alterações' : 'Cadastrar produto' }}
            </button>

            <a href="{{ isset($editProduto) ? route('admin_dashboard') : route('home_page') }}" class="btn btn-outline-secondary w-100 mt-2">
                Cancelar
            </a>
        </div>
    </form>

@endsection
