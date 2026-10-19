<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\CauserResolver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //alterado para log!!!
        app(CauserResolver::class)->resolveUsing(function ($sujeito) {
            if ($sujeito instanceof Model) {
                return $sujeito;
            }

            $id = is_scalar($sujeito)
                ? $sujeito
                : (request()->hasSession() ? session('user.id') : null);

            return $id ? User::find($id) : null;
        });
    }
}
