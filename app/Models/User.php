<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class User extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $fillable = [
        'email',
        'name',
        'password',
        'permission',
    ];
}
