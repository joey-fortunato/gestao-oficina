<?php

namespace App\Filament\Resources\FornecedorResource\Pages;

use App\Filament\Resources\FornecedorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFornecedor extends CreateRecord
{
    protected static string $resource = FornecedorResource::class;

    protected function getFormActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Cadastrar')
                ->submit('Cadastrar fornecedor'), // Botão "Criar"

            Actions\Action::make('cancel') // Botão "Cancelar"
                ->label('Cancelar')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')), // Redireciona para a listagem
        ];
    }
}
