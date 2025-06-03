<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Peca extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'preco',
        'quantidade_estoque',
        'quantidade_minima',
        'localizacao',
        'fornecedor_id'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
    ];

    // Relação com fornecedor (opcional)
    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    // Scope para peças com estoque baixo
    public function scopeEstoqueBaixo($query)
    {
        return $query->whereColumn('quantidade_estoque', '<=', 'quantidade_minima');
    }

    // Método para verificar disponibilidade
    public function temEstoque(int $quantidade): bool
    {
        return $this->quantidade_estoque >= $quantidade;
    }
}
