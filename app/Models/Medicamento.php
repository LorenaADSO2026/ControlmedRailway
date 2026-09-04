<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $table = 'medicamentos';

    protected $fillable = [
        'nombre',
        'codigo',
        'lote',
        'fecha_vencimiento',
        'cantidad',
        'observaciones',
        'proveedor_id',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function movimientos()
    {
        return $this->hasMany(InventarioMovimiento::class, 'medicamento_id');
    }

    // Umbral de bajo stock
    const UMBRAL_BAJO_STOCK = 5;

    // Umbral de días para "próximo a vencer"
    const DIAS_POR_VENCER = 30;

    public function getEstaPorVencerAttribute(): bool
    {
        return $this->fecha_vencimiento
            && now()->lte($this->fecha_vencimiento)
            && now()->diffInDays($this->fecha_vencimiento, false) <= self::DIAS_POR_VENCER;
    }

    public function getYaVencioAttribute(): bool
    {
        return $this->fecha_vencimiento && now()->gt($this->fecha_vencimiento);
    }

    public function getBajoStockAttribute(): bool
    {
        return $this->cantidad <= self::UMBRAL_BAJO_STOCK;
    }
}
