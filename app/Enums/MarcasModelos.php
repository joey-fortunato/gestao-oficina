<?php

namespace App\Enums;

class MarcasModelos
{
    const MARCAS = [
        'Toyota' => [
            'Corolla', 'Hilux', 'RAV4', 'Yaris', 'Camry'
        ],
        'Ford' => [
            'Fiesta', 'Focus', 'Ranger', 'Mustang', 'Explorer'
        ],
        'BMW' => [
            'Série 1', 'Série 3', 'X5', 'X3', 'M3'
        ],
        'Mercedes-Benz' => [
            'Classe A', 'Classe C', 'Classe E', 'GLA', 'GLC'
        ],
        'Volkswagen' => [
            'Golf', 'Polo', 'Passat', 'Tiguan', 'Arteon'
        ],
    ];

    public static function getMarcas(): array
    {
        return array_keys(self::MARCAS);
    }

    public static function getModelos(string $marca): array
    {
        return self::MARCAS[$marca] ?? [];
    }
}