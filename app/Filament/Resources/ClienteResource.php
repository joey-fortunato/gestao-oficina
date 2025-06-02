<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                        ->label('Nome Completo')
                        ->required()
                        ->maxLength(255),

                Forms\Components\TextInput::make('bi')
                        ->label('Número de BI')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(14),
                
                Forms\Components\TextInput::make('contato')
                        ->label('Telefone')
                        ->tel()
                        ->required()
                        ->maxLength(20),
                
                Forms\Components\TextInput::make('endereco')
                        ->label('Endereço Completo')
                        ->required(),
                        
                Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                Forms\Components\TextInput::make('password')
                        ->label('Palavra-passe')
                        ->password()
                        ->required()
                        ->maxLength(255),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                ->label('Nome'),
                Tables\Columns\TextColumn::make('bi')
                ->label('B.I'),
                Tables\Columns\TextColumn::make('contato')
                ->label('Telefone'),
                Tables\Columns\TextColumn::make('endereco')
                ->label('Endereço')
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
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
