<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresupuestoResource\Pages;
use App\Filament\Resources\PresupuestoResource\RelationManagers;
use App\Models\Presupuesto;
use App\Models\User;
use App\Models\Categoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make('Llene los campos del Presupuesto')
                            ->schema([
                                    Forms\Components\Select::make('user_id')
                                        ->label('Usuarios')
                                        ->required()
                                        ->options(User::all()->pluck('name', 'id')),
                                    Forms\Components\Select::make('categoria_id')
                                        ->label('Categorías')
                                        ->required()
                                        ->options(Categoria::all()->pluck('nombre', 'id')),
                                    Forms\Components\TextInput::make('monto_asignado')
                                        ->required()
                                        ->numeric(),
                                    Forms\Components\TextInput::make('monto_gastado')
                                        ->required()
                                        ->numeric()
                                        ->default(0.00)
                                        ->disabled(),
                                    Forms\Components\TextInput::make('mes')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('anio')
                                        ->label('Año')
                                        ->required()
                                        ->maxLength(255),
                                
                                    ])->columns(2),
                        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('Nro')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto_asignado')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('monto_gastado')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mes')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anio')
                    ->label('Año')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->button()
                ->color('success'),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->successNotification(
                Notification::make()
                    ->title('Presupuesto eliminado correctamente')
                    ->body('El Presupuesto ha sido eliminado exitosamente.')
                    ->success()
                ),
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
            'index' => Pages\ListPresupuestos::route('/'),
            'create' => Pages\CreatePresupuesto::route('/create'),
            'edit' => Pages\EditPresupuesto::route('/{record}/edit'),
        ];
    }
}
