<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PecaResource\Pages;
use App\Filament\Resources\PecaResource\RelationManagers;
use App\Models\Peca;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PecaResource extends Resource
{
    protected static ?string $model = Peca::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Peças';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPecas::route('/'),
            'create' => Pages\CreatePeca::route('/create'),
            'view' => Pages\ViewPeca::route('/{record}'),
            'edit' => Pages\EditPeca::route('/{record}/edit'),
        ];
    }
}
