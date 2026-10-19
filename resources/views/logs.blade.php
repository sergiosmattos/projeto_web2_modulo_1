@extends('layouts.main-layout')

@section('content')

@php
    $eventos = [
        'created'     => 'Cadastro',
        'updated'     => 'Edição',
        'deleted'     => 'Exclusão',
        'restored'    => 'Restauração',
        'visualizado' => 'Visualização',
    ];
@endphp

<main class="container pb-5">

    <h2 class="mb-4">
        <i class="fa-solid fa-clipboard-list me-2"></i>Logs do sistema
    </h2>

    {{-- Filtro por tipo de log --}}
    {{-- <div class="btn-group mb-4" role="group" aria-label="Filtrar logs">
        <a href="{{ route('admin_logs') }}"
           class="btn {{ $filtro === 'todos' ? 'btn-danger' : 'btn-outline-secondary' }}">Todos</a>
        <a href="{{ route('admin_logs', ['filtro' => 'usuario']) }}"
           class="btn {{ $filtro === 'usuario' ? 'btn-danger' : 'btn-outline-secondary' }}">Usuários</a>
        <a href="{{ route('admin_logs', ['filtro' => 'produto']) }}"
           class="btn {{ $filtro === 'produto' ? 'btn-danger' : 'btn-outline-secondary' }}">Produtos</a>
    </div> --}}

    @if (count($logs) == 0)

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
                        <th>Tipo</th>
                        <th>Evento</th>
                        <th>Descrição</th>
                        <th>Feito por</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($logs as $log)
                        <tr>
                            <td class="text-nowrap num">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="selo">{{ $log->log_name === 'usuarios' ? 'Usuário' : 'Produto' }}</span>
                            </td>
                            <td>{{ $eventos[$log->event] ?? $log->event }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->causer?->name ?? '—' }}</td>
                            <td class="small text-break">
                                @if ($log->event === 'updated')
                                    @foreach ($log->properties->get('attributes', []) as $campo => $novo)
                                        <div>
                                            <span class="text-body-secondary">{{ $campo }}:</span>
                                            {{ data_get($log->properties, 'old.' . $campo) ?? '—' }}
                                            →
                                            {{ $novo ?? '—' }}
                                        </div>
                                    @endforeach
                                @elseif ($log->event === 'visualizado')
                                    <span class="text-body-secondary">IP</span> {{ $log->properties->get('ip', '—') }}
                                @else
                                    <span class="text-body-secondary">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</main>

@endsection
