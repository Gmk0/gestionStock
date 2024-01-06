<?php

namespace App\Filament\Pages;

use App\Models\HistoPrix;
use App\Models\Produit;
use App\Models\vente;
use Filament\Forms\Components\DateTimePicker;
use Filament\Pages\Page;
use Filament\Forms\Components\Grid;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

class VenteJour extends Page implements HasForms
{
     use InteractsWithForms;
    protected static ?string $title = 'Ventes du jour';
    protected static ?string $navigationIcon = 'heroicon-m-shopping-cart';

    protected static string $view = 'filament.pages.vente-jour';

    public $montant;
    public $prix;
    public $qte_pc;
    public $date_vente;

    public $produit_id;
    public function mount()
    {

        $this->form->fill();
    }
    public function form(Form $form): Form
    {

        return $form->schema([
            Grid::make('2')->schema([
                Select::make('produit_id')->label('Produit')
                    ->options(Produit::all()->pluck('nom', 'id'))
                    ->native(false),
                TextInput::make('qte_pc')
                    ->live()
                    ->numeric(),
                Select::make('prix')
                ->options(HistoPrix::all()->pluck('prix_unit', 'prix_unit'))
                ->live()
                ->native(false),
                TextInput::make('montant')
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                    ->required(),
                DateTimePicker::make('date_vente'),

            ]),

            ]);
    }

    public function updatingPrix($value)
    {

        $this->montant=$value * $this->qte_pc;
    }

    public function save()
    {
        $this->form->validate();

        try{
            $price = HistoPrix::where('prix_unit', $this->prix)->first();

            $data =
                [
                    'produit_id' => $this->produit_id,
                    'qte_pc' => $this->qte_pc,
                    'qte_pqt' =>round($this->qte_pc / 12),
                    'montant'=>$this->montant,
                    'histoPrix_id' => $price->id??null,
                    'date_vente' => $this->date_vente,
                ];




            $vente=vente::create($data);

            $this->resetAll();

            $this->sendNotification();

        }catch(\PDOException $e) {

            Notification::make()
                ->danger()
                ->title('erreur')
                ->body($e->getMessage())

                ->send();

        }




    }

    function resetAll()
    {

     $this->reset('montant', 'produit_id', 'qte_pc', 'prix', 'date_vente');

    }

    protected function sendNotification(): void
    {
        Notification::make()
            ->success()
            ->title('Vos modifications ont ete pris en charge')
            ->send()
           ;
    }



}
