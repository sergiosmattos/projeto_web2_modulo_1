<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produto;
use App\Services\Operations;
use Spatie\Activitylog\Models\Activity;

class MainController extends Controller
{
    public function __construct(protected Operations $operations) {}

    public function index()
    {
        $produtos = Produto::all();
        return view('home-page', ['produtos' => $produtos]);
    }

    // Histórico do usuário = logs em que ele é o "causer" (quem fez a ação)
    public function history()
    {
        $user = User::findOrFail(session('user.id'));

        $logs = Activity::causedBy($user)
                    ->with('subject')
                    ->latest('id')
                    ->get();

        return view('history', ['logs' => $logs]);
    }

    //admin
    public function adminDashboard()
    {
        $users    = User::withTrashed()->get();
        $produtos = Produto::withTrashed()->get();

        return view('dashboard', [
            'users'    => $users,
            'produtos' => $produtos,
        ]);
    }

    // Todos os logs do sistema, com filtro por tipo: ?filtro=usuario | produto
    public function adminLogs(Request $request)
    {
        $filtro = (string) $request->query('filtro', 'todos');

        $nomesDosLogs = [
            'usuario' => 'usuarios',
            'produto' => 'produtos',
        ];

        if (!isset($nomesDosLogs[$filtro])) {
            $filtro = 'todos';
        }

        $logs = Activity::query()
                    ->with(['causer', 'subject'])
                    ->when($filtro !== 'todos', fn ($query) => $query->inLog($nomesDosLogs[$filtro]))
                    ->latest('id')
                    ->get();

        return view('logs', [
            'logs'   => $logs,
            'filtro' => $filtro,
        ]);
    }

}
