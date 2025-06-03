<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $fillable = [
    'nome',
    'preco',
    'descricao',
];

public function agendamentos()
{
    return $this->belongsToMany(Agendamento::class)
        ->withPivot(['funcionario_id', 'observacoes']);
}

}
