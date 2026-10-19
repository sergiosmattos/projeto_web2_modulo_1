@extends('layouts.main-layout')

@use('App\Models\Produto')
@use('App\Services\Operations')

@section('content')

    <main class="container pb-5">
        <h2 class="mb-4">
            <i class="fa-solid fa-clock-rotate-left me-2"></i>Histórico
        </h2>

        @forelse ($logs as $log)

            <div class="card mb-3">
                <div class="card-body d-flex flex-row justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="card-title mb-1">{{ $log->description }}</h5>
                        <small class="text-body-secondary">
                            <i class="fa-solid fa-calendar me-1"></i>
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </small>
                    </div>

                    {{-- O produto pode ter sido excluído: só mostra o link se ele ainda existir --}}
                    @if ($log->subject instanceof Produto)
                        <a href="{{ route('view_produto', Operations::encryptId($log->subject->id)) }}"
                           class="btn btn-outline-danger btn-sm text-nowrap">
                            Ver produto
                        </a>
                    @endif
                </div>
            </div>

        @empty

            <div class="text-center text-body-secondary mt-5">
                <i class="fa-solid fa-clock-rotate-left fa-3x mb-3"></i>
                <p>Você ainda não tem atividades registradas.</p>
                <a href="{{ route('home_page') }}" class="btn btn-outline-danger">Ver produtos</a>
            </div>

        @endforelse
    </main>

@endsection
