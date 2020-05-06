<?php

namespace App\Http\Controllers;

use App\Achat;
use App\Client;
use App\DetailAchat;
use App\DetailVente;
use App\Fournisseur;
use App\Produit;
use App\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public $racine_path = 'vendor.voyager';

    public function __construct()
    {
        $this->middleware('admin.user');
    }

    public function index(Request $request)
    {
        // $host = $request->getHttpHost();
        $ventes = Vente::select('clients.nom_complet as nom_client', 'ventes.date_vente as date_vente', 'ventes.id as vente_id', 'ventes.Total_vente as Total_vente')
            ->join('clients', 'clients.id', '=', 'ventes.client_id')
            ->orderBy('ventes.id', 'desc')
            ->get();
        return view($this->racine_path . '.ventes.index', compact('ventes'));
    }

    public function create()
    {
        $clients = $this->get_all_clients();
        $produits = $this->get_all_produits();
        return view($this->racine_path . '.ventes.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $redirect = redirect(route('index_ventes'))->with(['message' => "Your Success Message", 'alert-type' => 'success']);
        $client = $input["uclients"];
        $date_vente = $input["date_vente"];
        $vente = new Vente();
        $vente->client_id = $client;
        $vente->date_vente = $date_vente;
        $vente->save();
        $vente_id = $vente->id;
        if (!empty($input["outer-list"])) {
            if (count($input["outer-list"]) > 0) {
                foreach ($input["outer-list"] as $in) {
                    $detail_vente = new DetailVente();
                    $detail_vente->produit_id = $in["uproduits"];
                    $detail_vente->quantite = $in["quantite"];
                    $detail_vente->vente_id = $vente_id;
                    $detail_vente->prix = $in["prix"];
                    $detail_vente->save();
                }
            }
        } else {
            $vente_delete = Vente::where('id', '=', $vente_id)->delete();
            $redirect = redirect()->back()->with(['message' => "Remplir tous les champts", 'alert-type' => 'warning']);
        }
        return $redirect;
    }

    public function destroy($vente_id)
    {

        $detail_vente_selected = DetailVente::select('produit_id', 'quantite')->where('vente_id', '=', $vente_id)->get();
        foreach ($detail_vente_selected as $dach) {
            $produit = Produit::where('id', '=', $dach->produit_id)->first();
            $produit->qte_stock = $produit->qte_stock + $dach->quantite;
            $produit->save();
        }
        $detail_vente_deleted = DetailVente::where('vente_id', '=', $vente_id)->delete();
        $vente_delete = Vente::where('id', '=', $vente_id)->delete();
        return redirect(route('index_ventes'))->with(['message' => "Your Success Message", 'alert-type' => 'success']);
    }

    public function invoice($achat_id)
    {
        return view($this->racine_path . '.ventes.invoice');
    }

    /* ---- Febut Funtion -------*/
    public function get_all_clients()
    {
        $clients = Client::select('id', 'nom_complet')->get();
        return $clients;
    }

    public function get_all_produits()
    {
        $produits = Produit::select('id', 'nom')->where('qte_stock', '>', 0)->get();
        return $produits;
    }

    public function checkQteStock(Request $request)
    {
        $input = $request->all();
        $produit_id = $input["produit"];
        $produit = Produit::where('id', '=', $produit_id)->first();
        $produit_count = $produit->qte_stock;
        return $produit_count;
    }
    /* ---- Fin Funtion -------*/
}
