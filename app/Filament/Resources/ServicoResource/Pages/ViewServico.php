<?php

namespace App\Filament\Resources\ServicoResource\Pages;

use App\Filament\Resources\ServicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServico extends ViewRecord
{
    protected static string $resource = ServicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
