<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inmueble extends Model
{
    use HasFactory;

    public const TIPOS = ['casa', 'apartamento', 'oficina', 'local'];

    /** Áreas del inmueble: columna => etiqueta para la interfaz. */
    public const AREAS = [
        'habitaciones' => 'Habitaciones',
        'banos' => 'Baños',
        'cocinas' => 'Cocinas',
        'oficinas' => 'Oficinas',
    ];

    protected $table = 'inmuebles';

    protected $fillable = ['direccion', 'tipo', 'habitaciones', 'banos', 'cocinas', 'oficinas'];

    protected $attributes = [
        'habitaciones' => 0,
        'banos' => 0,
        'cocinas' => 0,
        'oficinas' => 0,
    ];

    protected function casts(): array
    {
        return [
            'habitaciones' => 'integer',
            'banos' => 'integer',
            'cocinas' => 'integer',
            'oficinas' => 'integer',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
