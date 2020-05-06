<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DetailVente extends Model
{
    public function save(array $options = [])
    {
        $vente_id=$this->vente_id;
        $prix=$this->prix;
        $qte=$this->quantite;
        $produit_id=$this->produit_id;

        $vente = Vente::where('id', '=', $vente_id)->first();
        $vente->Total_vente= $vente->Total_vente+($prix*$qte);
        $vente->save();


        $produit = Produit::where('id', '=', $produit_id)->first();
        $produit->qte_stock = $produit->qte_stock - $qte;
        $produit->save();
        parent::save();
    }
}
