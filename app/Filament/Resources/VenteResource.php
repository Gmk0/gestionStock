<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenteResource\Pages;
use App\Filament\Resources\VenteResource\RelationManagers;

use App\Filament\Resources\VenteResource\Widgets\VenteOverview as WidgetsVenteOverview;
use App\Models\HistoPrix;
use App\Models\Produit;
use App\Models\Vente;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\Summarizers\Sum;



class VenteResource extends Resource
{
    protected static ?string $model = Vente::class;
    protected static ?string $modelLabel = 'Total ventes';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('produit_id')
                ->options(Produit::all()->pluck('nom', 'id')),
                Forms\Components\TextInput::make('qte_pc')
                    ->live()
                    ->numeric(),

            Forms\Components\Select::make('histoPrix_id')
                ->options(HistoPrix::all()->pluck('prix_unit', 'prix_unit'))
                ->live()
            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                if (($get('qte_pc') ?? '') ) {
                    return;
                }

                $set('montant', $state * 3);
            }),


                Forms\Components\TextInput::make('montant')
                ->dehydrated()
                    ->numeric(),
                Forms\Components\TextInput::make('histoPrix_id')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('date_vente'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->groups([
            'produit.nom',
        ])
            ->columns([
                Tables\Columns\TextColumn::make('produit.nom')
                    ->numeric(),
                   
                Tables\Columns\TextColumn::make('qte_pc')
                    ->numeric(),

                Tables\Columns\TextColumn::make('qte_pqt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant')
                    ->money('CDF')
               
                    ->summarize(Sum::make()
                ->money('CDF')
                    ->label('Total vente'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('histoPrix.prix_unit')->label('Prix piece')
                    ->numeric()
                  ,
                Tables\Columns\TextColumn::make('date_vente')
                    ->dateTime()
                    ->sortable(),
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
    public static function getWidgets(): array
    {
        return[
          WidgetsVenteOverview::class,  
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVentes::route('/'),
            'create' => Pages\CreateVente::route('/create'),
            'edit' => Pages\EditVente::route('/{record}/edit'),
        ];
    }
}
