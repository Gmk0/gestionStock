<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchatResource\Pages;
use App\Filament\Resources\AchatResource\RelationManagers;
use App\Models\Achat;
use App\Models\Produit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AchatResource extends Resource
{
    protected static ?string $model = Achat::class;
    protected static ?string $modelLabel = 'Aprovisionnement';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('produit_id')
                    ->options(Produit::all()->pluck('nom', 'id'))
                    ->native(false)
                    ,
                Forms\Components\TextInput::make('qte_pqt')
                    ->numeric(),
                Forms\Components\TextInput::make('montant')
                ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                ->required()
                ->numeric(),
                Forms\Components\DateTimePicker::make('date_paiement'),


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
                    ->numeric()
                    
                    ,
              
                Tables\Columns\TextColumn::make('qte_pqt')
            ->summarize(Sum::make()
            
                ->label('Total Paquet'))
                    ->numeric()
                    ,
                Tables\Columns\TextColumn::make('montant')
                    ->numeric()
                ->money('CDF')

                ->summarize(Sum::make()
                ->money('CDF')
                    ->label('Total Commande'))
             
                    ,
                Tables\Columns\TextColumn::make('date_paiement')
                    ->dateTime()
                    ,
                Tables\Columns\SelectColumn::make('status')
                ->options(['Livre'=> 'Livré','en attente'=>'En attente'])
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
            'index' => Pages\ListAchats::route('/'),
            'create' => Pages\CreateAchat::route('/create'),
            'edit' => Pages\EditAchat::route('/{record}/edit'),
        ];
    }
}
