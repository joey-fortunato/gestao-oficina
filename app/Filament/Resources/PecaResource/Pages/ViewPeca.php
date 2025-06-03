<?php

namespace App\Filament\Resources\PecaResource\Pages;

use App\Filament\Resources\PecaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPeca extends ViewRecord
{
    protected static string $resource = PecaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
