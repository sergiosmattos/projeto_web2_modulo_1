<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'email',
        'name',
        'password',
        'permission',
    ];

    // Log automático (Logging Model Events): cadastro, edição, exclusão e restauração de usuários.
    // A senha NÃO entra no log.
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('usuarios')
            ->logOnly(['name', 'email', 'permission'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $evento) => 'Usuário :subject.name foi ' . match ($evento) {
                'created'  => 'cadastrado',
                'updated'  => 'atualizado',
                'deleted'  => 'excluído',
                'restored' => 'restaurado',
                default    => $evento,
            });
    }
}
