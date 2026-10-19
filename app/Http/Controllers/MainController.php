<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produto;
use App\Services\Operations;

class MainController extends Controller
{
    public function __construct(protected Operations $operations) {}

    public function index()
    {
        $produtos = Produto::all();
        return view('home-page', ['produtos' => $produtos]);
    }

    //admin
    public function adminDashboard()
    {
        $users = User::withTrashed()->get();
        $produtos = Produto::withTrashed()->get();

        return view('dashboard', [
            'users'    => $users,
            'produtos' => $produtos,
        ]);
    }
    public function adminLogs(Request $request)
    {
        return view('logs', ['logs' => []]);
    }

}
