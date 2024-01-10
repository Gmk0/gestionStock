<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoPrixResource\Pages;
use App\Filament\Resources\HistoPrixResource\RelationManagers;
use App\Models\HistoPrix;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoPrixResource extends Resource
{
    protected static ?string $model = HistoPrix::class;
    protected static ?string $modelLabel = 'Prix Produit';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('prix_pqt')
                    ->numeric(),
                Forms\Components\TextInput::make('prix_unit')
                    ->numeric(),
                Forms\Components\TextInput::make('benefice')
                    ->numeric(),
                Forms\Components\Toggle::make('activer')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prix_pqt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prix_unit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('benefice')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activer')
                    ->boolean(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHistoPrixes::route('/'),
        ];
    }
}
