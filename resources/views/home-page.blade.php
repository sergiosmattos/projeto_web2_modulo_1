@extends('layouts.main-layout')

@section('content')

    @if (count($produtos) != 0)

        <main class="container-fluid px-4 pb-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3">
                @foreach ($produtos as $produto)
                    <x-produto-card :produto="$produto"/>
                @endforeach
            </div>
        </main>

    @else

        <div class="text-center text-body-secondary mt-5">
            <i class="fa-solid fa-box-open fa-3x mb-3"></i>
            <p>Ainda não há produtos cadastrados.</p>

            @if (session()->get('user.permission') === 'admin')
                <a href="{{ route('new_produto') }}" class="btn btn-danger">Cadastrar o primeiro produto</a>
            @endif
        </div>

    @endif

@endsection
