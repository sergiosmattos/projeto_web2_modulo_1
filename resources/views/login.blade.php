@extends('layouts.main-layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">

                    <div class="text-center p-3">
                        <span class="marca h3">Produtos</span>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">

                            <form action="{{ route('login_submit') }}" method="POST" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="text_email" class="form-label">
                                        E-mail
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text text-danger">
                                            <i class="fa-solid fa-user"></i>
                                        </span>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="text_email"
                                            value="{{ old('text_email') }}">
                                    </div>

                                    @error('text_email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="text_password" class="form-label">
                                        Senha
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text text-danger">
                                            <i class="fa-solid fa-key"></i>
                                        </span>

                                        <input
                                            type="password"
                                            class="form-control"
                                            name="text_password"
                                            value="{{ old('text_password') }}">
                                    </div>

                                    @error('text_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                        &nbsp;&nbsp;LOGIN
                
                                    </button>
                                </div>

                                

                            </form>

                            


                            @if(session('login_error'))
                                <div class="alert alert-danger text-center">
                                    {{ session('login_error') }}
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="col text-center">
                                <a href="{{route('create') }}">Não é cadastrado?</a>
                            </div>

                    <div class="text-center text-body-secondary mt-3">
                        <small>&copy;Copyright {{ date('Y') }}</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection