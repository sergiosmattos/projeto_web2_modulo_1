@use(App\Services\Operations)
@extends('layouts.main-layout')

@section('content')

<main class="container pb-5">
    <h2 class="mb-4">
        <i class="fa-solid fa-shield-halved me-2"></i>Painel admin
    </h2>

    @if(session('success'))
        <div class="aviso alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <h4 class="mt-4 mb-3">
        <i class="fa-solid fa-users me-2"></i>Usuários
    </h4>

    <div class="table-responsive">

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>E-mail</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($users as $user)
                <tr class="{{ $user->deleted_at ? 'linha-excluida' : '' }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->permission }}</td>
                    <td>
                        @if($user->deleted_at)
                            <span class="selo selo-vermelho">Deletado</span>
                        @else
                            <span class="selo">Ativo</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('admin_edit_user', Operations::encryptId($user->id)) }}" class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-pen me-1"></i>Editar
                        </a>
                        @if($user->deleted_at)
                            <a href="{{ route('admin_restore_user', Operations::encryptId($user->id)) }}" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-rotate-left me-1"></i>Restaurar
                            </a>
                            <a href="{{ route('admin_force_delete_user', Operations::encryptId($user->id)) }}" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash me-1"></i>Deletar permanentemente
                            </a>
                        @else
                            <a href="{{ route('admin_delete_user', Operations::encryptId($user->id)) }}" class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash me-1"></i>Deletar
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h4 class="mt-5 mb-3">
        <i class="fa-solid fa-boxes-stacked me-2"></i>Produtos
    </h4>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Cadastrado em</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach($produtos as $produto)
                    <tr class="{{ $produto->deleted_at ? 'linha-excluida' : '' }}">
                        <td>{{ $produto->id }}</td>
                        <td>{{ $produto->nome }}</td>
                        <td class="num text-nowrap">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                        <td class="num">{{ $produto->quantidade }}</td>
                        <td class="num text-nowrap">{{ $produto->created_at->format('d/m/Y - H:i') }}</td>
                        <td>
                            @if($produto->deleted_at)
                                <span class="selo selo-vermelho">Deletado</span>
                            @else
                                <span class="selo">Ativo</span>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin_edit_produto', Operations::encryptId($produto->id)) }}" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-pen me-1"></i>Editar
                            </a>
                            @if($produto->deleted_at)
                                <a href="{{ route('admin_restore_produto', Operations::encryptId($produto->id)) }}" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-rotate-left me-1"></i>Restaurar
                                </a>
                                <a href="{{ route('admin_force_delete_produto', Operations::encryptId($produto->id)) }}" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash me-1"></i>Deletar permanentemente
                                </a>
                            @else
                                <a href="{{ route('admin_delete_produto', Operations::encryptId($produto->id)) }}" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash me-1"></i>Deletar
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

@endsection
