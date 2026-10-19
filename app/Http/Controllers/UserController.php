<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function adminRestore($id)
    {
        User::withTrashed()->findOrFail(Operations::decryptId($id))->restore();
        return redirect()->route('admin_dashboard')->with('success', 'Usuário restaurado.');
    }

    public function adminDelete($id)
    {
        User::findOrFail(Operations::decryptId($id))->delete();
        return redirect()->route('admin_dashboard')->with('success', 'Usuário deletado.');
    }

    public function adminForceDelete($id)
    {
        User::withTrashed()->findOrFail(Operations::decryptId($id))->forceDelete();
        return redirect()->route('admin_dashboard')->with('success', 'Usuário deletado permanentemente.');
    }

        public function adminEditUser($id)
    {
        $user = User::withTrashed()->findOrFail(Operations::decryptId($id));
        return view('cadastro-usuario', ['editUser' => $user]);
    }

    public function adminEditUserSubmit(Request $request, $id)
    {
        $request->validate([
            'text_email'    => 'required|email|max:200',
            'text_name'     => 'required|min:3|max:50',
            'text_password' => 'nullable|min:6',
        ]);

        $user             = User::withTrashed()->findOrFail(Operations::decryptId($id));
        $user->email      = $request->text_email;
        $user->name       = $request->text_name;
        $user->permission = $request->text_permission ?? $user->permission;

        if ($request->filled('text_password')) {
            $user->password = bcrypt($request->text_password);
        }

        $user->save();

        return redirect()->route('admin_dashboard')->with('success', 'Usuário atualizado.');
    }
}