@use(App\Services\Operations)

@extends('layouts.form-layout')

@section('form-content')

    <form action="{{ isset($editUser) ? route('admin_edit_user_submit', Operations::encryptId($editUser->id)) : route('create_submit') }}" method="POST" novalidate autocomplete="off">
        @csrf

        <h5 class="mb-4 text-center">
            {{ isset($editUser) ? 'Editar Usuário' : 'Cadastro' }}
        </h5>

        <div class="mb-3">
            <label for="text_email" class="form-label">E-mail</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <input type="email" class="form-control" name="text_email"
                        value="{{ old('text_email', $editUser->email ?? '') }}">
            </div>
            @error('text_email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="text_name" class="form-label">Nome</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-user"></i>
                </span>
                <input type="text" class="form-control" name="text_name"
                        value="{{ old('text_name', $editUser->name ?? '') }}">
            </div>
            @error('text_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="text_password" class="form-label">
                Senha
                @isset($editUser)
                    <small class="text-body-secondary">(deixe em branco para manter a atual)</small>
                @endisset
            </label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-key"></i>
                </span>
                <input type="password" class="form-control" name="text_password">
            </div>
            @error('text_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        @isset($editUser)
        <div class="mb-3">
            <label for="text_permission" class="form-label">Permissão</label>
            <div class="input-group">
                <span class="input-group-text text-danger">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <select name="text_permission" class="form-select">
                    <option value="user"  {{ $editUser->permission === 'user'  ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $editUser->permission === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        @endisset

        <div class="mb-3">
            <button type="submit" class="btn btn-danger w-100">
                <i class="fa-solid fa-{{ isset($editUser) ? 'floppy-disk' : 'user-plus' }}"></i>
                &nbsp;&nbsp;{{ isset($editUser) ? 'Salvar Alterações' : 'Cadastrar' }}
            </button>

            @isset($editUser)
                <a href="{{ route('admin_dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                    Cancelar
                </a>
            @endisset
        </div>

    </form>

    @if(!isset($editUser))
        <div class="col text-center">
            <a href="{{ route('login') }}">Já tem cadastro?</a>
        </div>
    @endif

@endsection