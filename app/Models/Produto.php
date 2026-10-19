<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Produto extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'quantidade',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
    ];

    // Log automático (Logging Model Events): cadastro, edição, exclusão e restauração de produtos.
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('produtos')
            ->logOnly(['nome', 'preco', 'descricao', 'quantidade'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $evento) => 'Produto :subject.nome foi ' . match ($evento) {
                'created'  => 'cadastrado',
                'updated'  => 'atualizado',
                'deleted'  => 'excluído',
                'restored' => 'restaurado',
                default    => $evento,
            });
    }
}
