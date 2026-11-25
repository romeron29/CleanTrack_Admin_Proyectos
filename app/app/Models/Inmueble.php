<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inmueble extends Model
{
    use HasFactory;

    public const TIPOS = ['casa', 'apartamento', 'oficina', 'local'];

    protected $table = 'inmuebles';

    protected $fillable = ['direccion', 'tipo'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
