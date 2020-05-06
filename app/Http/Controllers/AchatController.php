<?php

namespace App\Http\Controllers;

use App\Achat;
use App\DetailAchat;
use App\Fournisseur;
use App\Produit;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public $racine_path = 'vendor.voyager';

    public function __construct()
    {
        $this->middleware('admin.user');
    }

    public function index(Request $request)
    {
        // $host = $request->getHttpHost();
        $achats = Achat::select('fournisseurs.nom_complet as nom_fournisseur', 'achats.date_achat as date_achat', 'achats.id as achat_id', 'achats.Total_Achat as Total_Achat')
            ->join('fournisseurs', 'fournisseurs.id', '=', 'achats.fournisseur_id')
            ->orderBy('achats.id', 'desc')
            ->get();
        return view($this->racine_path . '.achats.index', compact('achats'));
    }

    public function create()
    {
        $fournisseurs = $this->get_all_fournisseurs();
        $produits = $this->get_all_produits();
        return view($this->racine_path . '.achats.create', compact('fournisseurs', 'produits'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $redirect = redirect(route('index_achats'))->with(['message' => "Your Success Message", 'alert-type' => 'success']);
        $fournisseur = $input["ufournisseurs"];
        $date_achats = $input["date_achat"];
        $achat = new Achat();
        $achat->fournisseur_id = $fournisseur;
        $achat->date_achat = $date_achats;
        $achat->save();
        $achat_id = $achat->id;
        if (!empty($input["outer-list"])) {
            if (count($input["outer-list"]) > 0) {
                foreach ($input["outer-list"] as $in) {
                    $detail_achat = new DetailAchat();
                    $detail_achat->produit_id = $in["uproduits"];
                    $detail_achat->quantite = $in["quantite"];
                    $detail_achat->achat_id = $achat_id;
                    $detail_achat->prix = $in["prix"];
                    $detail_achat->save();
                }
            }
        } else {
            $achat_delete = Achat::where('id', '=', $achat_id)->delete();
            $redirect = redirect()->back()->with(['message' => "Remplir tous les champts", 'alert-type' => 'warning']);
        }
        return $redirect;
    }

    public function destroy($achat_id)
    {
        $detail_achat_selected = DetailAchat::select('produit_id', 'quantite')->where('achat_id', '=', $achat_id)->get();
        foreach ($detail_achat_selected as $dach) {
            $produit = Produit::where('id', '=', $dach->produit_id)->first();
            $produit->qte_stock = $produit->qte_stock - $dach->quantite;
            $produit->save();
        }
        $detail_achat_deleted = DetailAchat::where('achat_id', '=', $achat_id)->delete();
        $achat_delete = Achat::where('id', '=', $achat_id)->delete();
        return redirect(route('index_achats'))->with(['message' => "Your Success Message", 'alert-type' => 'success']);
    }

    public function invoice($achat_id)
    {
        return view($this->racine_path . '.achats.invoice');
    }

    /* ---- Febut Funtion -------*/
    public function get_all_fournisseurs()
    {
        $fournisseurs = Fournisseur::select('id', 'nom_complet')->get();
        return $fournisseurs;
    }

    public function get_all_produits()
    {
        $produits = Produit::select('id', 'nom')->get();
        return $produits;
    }

    public function outProducts()
    {
        $produits = Produit::where('qte_stock', '<=', 2)->get();
        return view($this->racine_path . '.achats.outProducts', compact('produits'));
    }

    /* ---- Fin Funtion -------*/
}
