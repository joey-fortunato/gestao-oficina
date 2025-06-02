<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = [
    'cliente_id',
    'matricula',
    'marca',
    'modelo',
    'ano',
    'cor',
    'chassi',
    'quilometragem',
];

public function cliente()
{
    return $this->belongsTo(Cliente::class);
}

// Mutator para formatar automaticamente
public function setMatriculaAttribute($value)
{
    // Remove caracteres inválidos e formata
    $cleanValue = strtoupper(preg_replace('/[^A-Z0-9]/', '', $value));
    
    // Formata no padrão AA-00-00-AA
    $this->attributes['matricula'] = substr($cleanValue, 0, 2) . '-' . 
                                     substr($cleanValue, 2, 2) . '-' . 
                                     substr($cleanValue, 4, 2) . '-' . 
                                     substr($cleanValue, 6, 2);
}

// Accessor para exibição
public function getMatriculaFormatadaAttribute()
{
    return $this->matricula; // Já está formatado
}

}
