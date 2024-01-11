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
use Filament\Forms\Components\{Select, DatePicker};
use Filament\Forms\Components\Section;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\DB;

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
    public $qte_pqt;

    public $benefice=null;

    public  ?array $ventes =[];

    public function mount()
    {


        $this->form->fill();
    }
    public function form(Form $form): Form
    {

        return $form->schema([
            Grid::make('3')->schema([
                Select::make('produit_id')->label('Produit')
                    ->options(Produit::all()->pluck('nom', 'id'))
                    ->native(false),
                TextInput::make('qte_pqt')
                ->label('quantite en paquet')
                    ->live()
                    ->numeric(),
                Select::make('prix')
                ->options(HistoPrix::all()->pluck('prix_pqt', 'prix_pqt'))
                ->live()
                ->native(false),
                TextInput::make('montant')
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                    ->required()
                  ,
                TextInput::make('benefice')
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                    ,
                DatePicker::make('date_vente')
                ->required(),

            ]),

            ]);
    }

    public function updatingPrix($value)
    {
        $this->montant=$value * $this->qte_pqt;


    }





    public function save()
    {
        $this->form->validate();

        try{


            $price = HistoPrix::where('prix_pqt', $this->prix)->first();
            $product_name=Produit::find($this->produit_id);
            $qte_pc=$this->qte_pqt *12;


            if(empty($this->benefice) && !empty($price))
            {
                $this->benefice= $qte_pc * $price->benefice;
            }
            $data =
                [
                    'produit_id' => $this->produit_id,
                    'product_name'=> $product_name->nom,
                    'qte_pc' => $qte_pc,
                    'qte_pqt' =>$this->qte_pqt,
                    'montant'=>$this->montant,
                    'benefice'=>$this->benefice,
                    'histoPrix_id' => $price->id??null,
                    'date_vente' => $this->date_vente,
                ];




                $this->ventes[]=$data;



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

     $this->reset('montant', 'qte_pqt','benefice', 'produit_id', 'qte_pc', 'prix', 'date_vente');
     $this->montant=0;
        $this->benefice = 0;
    }


    public function validation()
    {
        // Vérifie si le tableau de ventes est vide
        if (empty($this->ventes)) {
            // Le tableau est vide

            Notification::make()
                ->danger()
                ->title('erreur')
                ->body('Le tableau de ventes est vide.')
                ->send();
        } else {

            try{

                DB::beginTransaction();
                // Le tableau n'est pas vide, continuez avec la validation
                foreach ($this->ventes as $venteData) {
                    // Crée une nouvelle instance du modèle Vente
                    $vente = new Vente;

                    // Remplit le modèle avec les données de la vente
                    $vente->fill($venteData);

                    // Sauvegarde le modèle dans la base de données
                    $vente->save();



                    $this->ventes = [];
                }

                DB::commit();
                Notification::make()
                ->success()
                    ->title('Sauvegarder avec succees')
                    ->send();

            }catch(\Exception $e){
                DB::rollBack();

                Notification::make()
                    ->danger()
                    ->title('erreur')
                    ->body($e->getMessage())
                    ->send();


            }

        }
    }


    protected function sendNotification(): void
    {
        Notification::make()
            ->success()
            ->title('Ajouter')
            ->send()
           ;
    }



}
