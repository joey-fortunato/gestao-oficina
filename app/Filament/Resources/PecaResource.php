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
                Forms\Components\Section::make('Informações Básicas')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                            
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(100),
                            
                        Forms\Components\Textarea::make('descricao')
                        ->label('Descrição')
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('preco')
                            ->label('Preço')
                            ->numeric()
                            ->suffix('Kz')
                            ->required(),
                    ]),
                    
                Forms\Components\Section::make('Gestão de Stock')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('quantidade_estoque')
                            ->label('Quantidade em Stock')
                            ->numeric()
                            ->required(),
                            
                        Forms\Components\TextInput::make('quantidade_minima')
                            ->label('Stock Mínimo')
                            ->numeric()
                            ->required(),
                            
                        Forms\Components\TextInput::make('localizacao')
                            ->required()
                            ->label('Localização no Armazém'),
                    ]),
                    
                Forms\Components\Section::make('Dados do Fornecedor')
                    ->schema([
                        Forms\Components\Select::make('fornecedor_id')
                            ->relationship('fornecedor', 'nome')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nome')
                                    ->required(),
                                Forms\Components\TextInput::make('contacto')
                                ->label('Contacto')
                                ->numeric()
                                ->required(),
                                Forms\Components\TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required(),
                                Forms\Components\TextInput::make('endereco')
                                    ->label('Endereço')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('preco')
                    ->money('AKZ')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('quantidade_estoque')
                    ->label('Quantidade em Stock')
                    ->sortable()
                    ->color(fn (Peca $record) => $record->quantidade_estoque <= $record->quantidade_minima ? 'danger' : 'success'),
                    
                Tables\Columns\TextColumn::make('fornecedor.nome')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('localizacao')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('fornecedor')
                    ->relationship('fornecedor', 'nome'),
                Tables\Filters\Filter::make('estoque_baixo')
                    ->label('Apenas com estoque baixo')
                    ->query(fn ($query) => $query->estoqueBaixo()),
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
