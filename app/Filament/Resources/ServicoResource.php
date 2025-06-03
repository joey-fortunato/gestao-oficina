<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicoResource\Pages;
use App\Filament\Resources\ServicoResource\RelationManagers;
use App\Models\Servico;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServicoResource extends Resource
{
    protected static ?string $model = Servico::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationLabel = 'Serviços';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados do Serviço')
                ->schema([
                    Forms\Components\TextInput::make('nome')
                        ->label('Nome')
                        ->required(),
                    
                    Forms\Components\TextInput::make('preco')
                        ->label('Preço')
                        ->numeric()
                        ->suffix('Kz')
                        ->required(),

                    Forms\Components\TextInput::make('descricao')
                        ->label('Descrição')
                        ->required(),
                    
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                ->label('Nome'),
                Tables\Columns\TextColumn::make('preco')
                ->label('Preço'),
                Tables\Columns\TextColumn::make('descricao')
                ->label('Descrição'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                 ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicos::route('/'),
            'create' => Pages\CreateServico::route('/create'),
            'view' => Pages\ViewServico::route('/{record}'),
            'edit' => Pages\EditServico::route('/{record}/edit'),
        ];
    }
}
