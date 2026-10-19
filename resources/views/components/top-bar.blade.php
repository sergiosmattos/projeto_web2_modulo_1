<header class="border-bottom mb-4">
    <div class="container-fluid px-4 py-3 d-flex flex-row align-items-center gap-2">

        <a href="{{ route('home_page') }}" class="marca h4 mb-0 me-auto">Produtos</a>

        @if (session()->has('user'))

            @if (session()->get('user.permission') === 'admin')
                <a href="{{ route('new_produto') }}" class="btn btn-danger">
                    <i class="fa-solid fa-circle-plus me-2"></i>Novo produto
                </a>
            @endif

            <div class="dropdown">

                <button
                    class="btn btn-outline-danger dropdown-toggle px-4"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    Menu
                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    @if (session()->get('user.permission') === 'admin')
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_dashboard') }}">
                                <i class="fa-solid fa-user-lock me-2"></i>Painel admin
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin_logs') }}">
                                <i class="fa-solid fa-clipboard-list me-2"></i>Logs
                            </a>
                        </li>
                    @endif

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}">
                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout
                        </a>
                    </li>

                </ul>
            </div>

        @endif

    </div>
</header>
