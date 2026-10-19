@use('App\Services\Operations')

<div class="col">
    <div class="card produto-card h-100">
        <div class="card-body d-flex flex-column">

            <h5 class="card-title">
                <a href="{{ route('view_produto', ['id' => Operations::encryptId($produto->id)]) }}"
                   class="stretched-link text-reset text-decoration-none"
                   draggable="false">{{ $produto->nome }}</a>
            </h5>

            <p class="card-text text-body-secondary produto-descricao">
                {{ $produto->descricao ?: 'Sem descrição.' }}
            </p>

            <div class="mt-auto d-flex justify-content-between align-items-baseline">
                <span class="preco">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>

                @if ($produto->quantidade > 0)
                    <small class="text-body-secondary">{{ $produto->quantidade }} em estoque</small>
                @else
                    <small class="estoque-zerado">Sem estoque</small>
                @endif
            </div>

        </div>
    </div>
</div>
