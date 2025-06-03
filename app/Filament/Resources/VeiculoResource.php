<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VeiculoResource\Pages;
use App\Filament\Resources\VeiculoResource\RelationManagers;
use App\Models\Veiculo;
use App\Models\Cliente;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Enums\MarcasModelos;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VeiculoResource extends Resource
{
    protected static ?string $model = Veiculo::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Veículos';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // Seção para seleção do cliente
            Forms\Components\Section::make('Dados do Proprietário')
                ->schema([
                    Forms\Components\Select::make('cliente_id')
                        ->label('Cliente')
                        ->options(Cliente::all()->pluck('nome', 'id'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->columnSpanFull()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('cliente_info', Cliente::find($state)?->bi ?? '')),
                        
                    Forms\Components\TextInput::make('cliente_info')
                        ->label('B.I do Cliente')
                        ->disabled()
                        ->dehydrated(false)
                        ->columnSpanFull(),
                ]),
            
            // Seção para dados do veículo
            Forms\Components\Section::make('Dados do Veículo')
                ->columns(3)
                ->schema([
                  Forms\Components\TextInput::make('matricula')
                        ->label('Matrícula')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->mask('aa-99-99-aa') // Máscara básica
                        ->placeholder('LD-00-00-AA')
                        ->rules([
                            'regex:/^[A-Z]{2}-\d{2}-\d{2}-[A-Z]{2}$/' // Validação regex
                        ])
                        ->columnSpan(1)
                        ->extraInputAttributes([
                            'style' => 'text-transform: uppercase;' // Forçar maiúsculas
                        ]),
                        
                    Forms\Components\Select::make('marca')
                        ->label('Marca')
                        ->options(array_combine(
                            MarcasModelos::getMarcas(), 
                            MarcasModelos::getMarcas()
                        ))
                        ->searchable()
                        ->required()
                        ->live() // Ativa reatividade
                        ->afterStateUpdated(fn (Set $set) => $set('modelo', null)) // Limpa modelo quando marca muda
                        ->columnSpan(1),
                        
                    Forms\Components\Select::make('modelo')
                        ->label('Modelo')
                        ->options(function (Get $get) {
                            $marca = $get('marca');
                            
                            if (!$marca) {
                                return [];
                            }
                            
                            return array_combine(
                                $modelos = MarcasModelos::getModelos($marca),
                                $modelos
                            );
                        })
                        ->searchable()
                        ->required()
                        ->columnSpan(1),
                        
                    Forms\Components\TextInput::make('ano')
                        ->label('Ano')
                        ->required()
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue(now()->year)
                        ->columnSpan(1),
                        
                    Forms\Components\ColorPicker::make('cor')
                        ->label('Cor')
                        ->required()
                        ->columnSpan(1),
                        
                    Forms\Components\TextInput::make('chassi')
                        ->label('Chassi')
                        ->placeholder('9AA.AA99A9.9A.')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(50)
                        ->columnSpan(1),
                        
                    Forms\Components\TextInput::make('quilometragem')
                        ->label('Quilometragem')
                        ->required()
                        ->numeric()
                        ->minValue(0)
                        ->suffix('km')
                        ->columnSpan(1),
                ]),
            
            // Seção para documentos (opcional)
            Forms\Components\Section::make('Documentos')
                ->schema([
                    Forms\Components\FileUpload::make('documentos')
                        ->label('Documentos do Veículo')
                        ->multiple()
                        ->directory('veiculos/documentos')
                        ->visibility('private')
                        ->storeFileNamesIn('documentos_nomes')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nome')
                ->label('Proprietário'),
                Tables\Columns\TextColumn::make('matricula')
                ->label('Matrícula'),
                Tables\Columns\TextColumn::make('marca')
                ->label('Marca'),
                Tables\Columns\TextColumn::make('modelo')
                ->label('Modelo'),
                Tables\Columns\TextColumn::make('ano')
                ->label('Ano'),
                Tables\Columns\ColorColumn::make('cor')
                ->label('Cor'),
                Tables\Columns\TextColumn::make('chassi')
                ->label('Chassi'),
                Tables\Columns\TextColumn::make('quilometragem')
                ->label('Quilometragem')

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
            'index' => Pages\ListVeiculos::route('/'),
            'create' => Pages\CreateVeiculo::route('/create'),
            'view' => Pages\ViewVeiculo::route('/{record}'),
            'edit' => Pages\EditVeiculo::route('/{record}/edit'),
        ];
    }
}
