<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    public const TIPOS = ['residencial', 'comercial'];

    protected $table = 'clientes';

    protected $fillable = ['nombre', 'tipo', 'telefono'];

    public function inmuebles(): HasMany
    {
        return $this->hasMany(Inmueble::class);
    }
}
