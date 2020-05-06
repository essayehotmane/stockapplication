<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class DetailAchat extends Model
{
    protected $table='detail_achats';
    public function save(array $options = [])
    {
        $achat_id=$this->achat_id;
        $prix=$this->prix;
        $produit_id=$this->produit_id;
        $qte=$this->quantite;

        $achat = Achat::where('id', '=', $achat_id)->first();
        $achat->Total_Achat= $achat->Total_Achat+($prix*$qte);
        $achat->save();

        $produit = Produit::where('id', '=', $produit_id)->first();
        $produit->qte_stock = $produit->qte_stock + $qte;
        $produit->save();
        parent::save();
    }

}
