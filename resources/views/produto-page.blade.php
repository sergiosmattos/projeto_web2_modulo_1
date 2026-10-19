@extends('layouts.main-layout')

@section('content')

    <main class="container pb-5" style="max-width: 48rem;">

        <a href="{{ route('home_page') }}" class="text-decoration-none">
            <i class="fa-solid fa-arrow-left me-2"></i>Voltar aos produtos
        </a>

        <div class="card mt-3">
            <div class="card-body p-4">

                <h1 class="h3 mb-2">{{ $produto->nome }}</h1>
                <p class="preco mb-4">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>

                <dl class="row mb-0">
                    <dt class="col-sm-4 text-body-secondary fw-normal">Em estoque</dt>
                    <dd class="col-sm-8 num {{ $produto->quantidade > 0 ? '' : 'estoque-zerado' }}">
                        {{ $produto->quantidade > 0 ? $produto->quantidade : 'Sem estoque' }}
                    </dd>

                    <dt class="col-sm-4 text-body-secondary fw-normal">Visualizações</dt>
                    <dd class="col-sm-8 num">{{ $totalVisualizacoes }}</dd>

                    <dt class="col-sm-4 text-body-secondary fw-normal">Cadastrado em</dt>
                    <dd class="col-sm-8">{{ $produto->created_at->format('d/m/Y \à\s H:i') }}</dd>
                </dl>

                <hr>

                <p class="mb-0">{{ $produto->descricao ?: 'Sem descrição.' }}</p>

            </div>
        </div>

    </main>

@endsection
