<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FornecedorResource\Pages;
use App\Filament\Resources\FornecedorResource\RelationManagers;
use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralModelLabel = 'Fornecedores';
    protected static ?string $navigationLabel = 'Fornecedores';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados do Fornecedor')
                ->schema([
                    Forms\Components\TextInput::make('nome')
                        ->label('Nome')
                        ->required(),
                    Forms\Components\TextInput::make('contacto')
                    ->tel()
                    ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                    Forms\Components\TextInput::make('endereco')
                        ->label('Endereço')
                        ->required(),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                ->label('Nome'),
                Tables\Columns\TextColumn::make('contacto')
                ->label('Contacto'),
                Tables\Columns\TextColumn::make('email')
                ->label('Email'),
                Tables\Columns\TextColumn::make('endereco')
                ->label('Endereço'),
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
            'index' => Pages\ListFornecedors::route('/'),
            'create' => Pages\CreateFornecedor::route('/create'),
            'view' => Pages\ViewFornecedor::route('/{record}'),
            'edit' => Pages\EditFornecedor::route('/{record}/edit'),
        ];
    }
}
