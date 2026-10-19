@extends('layouts.main-layout')

@section('content')

@php
    $eventos = [
        'created'     => 'Cadastro',
        'updated'     => 'Edição',
        'deleted'     => 'Exclusão',
        'restored'    => 'Restauração',
        'visualized' => 'Visualização',
        'login'     => 'Login',
        'logout'     => 'Logout',
    ];
@endphp

<main class="container pb-5">

    <h2 class="mb-4">
        <i class="fa-solid fa-clipboard-list me-2"></i>Logs do sistema
    </h2>

    @if ($logs->isEmpty())

        <div class="text-center text-body-secondary mt-5">
            <i class="fa-solid fa-clipboard-list fa-3x mb-3"></i>
            <p>Nenhum log encontrado para este filtro.</p>
        </div>

    @else

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Evento</th>
                        <th>Descrição</th>
                        <th>Afetado</th>
                        <th>Realizado por</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($logs as $log)
                        <tr>
                            <td class="text-nowrap num">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $eventos[$log->event] ?? $log->event }}</td>
                            <td>{{ $log->description }}</td>
                            <td>
                                <span class="selo">{{ $log->subject?->name }}</span>
                            </td>
                            <td>{{ $log->causer?->name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</main>

@endsection
