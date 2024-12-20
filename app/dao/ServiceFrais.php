<?php

namespace App\Dao;

use Illuminate\Support\Facades\DB;
use Exception;

class ServiceFrais
{
    public function getFrais($id)
    {
        try {
            $frais = DB::table('frais')
                ->join('etat', 'frais.id_etat', '=', 'etat.id_etat')
                ->where('id_frais', '=', $id)
                ->first();
        } catch (Exception $e) {
            return response()->json(['error' => 'Request failed'], 500);
        }

        return $frais;
    }


    public function addFrais($champsRequete)
    {
        {
            $anneemois = $champsRequete->anneemois;
            $idVisiteur = $champsRequete->id_visiteur;
            $nbjustif = $champsRequete->nbjustificatifs;

            try {
                DB::table('frais')->insert([
                    'anneemois' => $anneemois,
                    'id_visiteur' => $idVisiteur,
                    'nbjustificatifs' => $nbjustif,
                    'id_etat' => 2,
                    'montantvalide' => 0,
                    'datemodification' => now(),
                ]);

            } catch (Exception $e) {
                return response()->json(['error' => 'Request failed'], 500);
            }
            $idFrais = DB::table('frais')->orderBy('id_frais', 'desc')
                ->limit(1)->value('id_frais');

            return $idFrais;
        }
    }

    public function updateFrais($champsRequete)
    {
        $idFrais = $champsRequete->id_frais;
        $anneemois = $champsRequete->anneemois;
        $nbjustificatifs = $champsRequete->nbjustificatifs;
        $montantvalide = $champsRequete->montantvalide;
        $idVisiteur = $champsRequete->id_visiteur;
        $idEtat = $champsRequete->id_etat;

        try {
            DB::table('frais')
                ->where('id_frais', '=', $idFrais)
                ->update(['anneemois' => $anneemois,
                    'nbjustificatifs' => $nbjustificatifs,
                    'id_visiteur' => $idVisiteur,
                    'id_etat' => $idEtat,
                    'montantvalide' => $montantvalide,
                    'datemodification' => now()
                ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Request failed'], 500);
        }
        return $idFrais;

    }

    public function deleteFrais($idFrais)
    {
        try {
            DB::table('frais')
                ->where('id_frais', '=', $idFrais)
                ->delete();
        } catch (Exception $e) {
            return response()->json(['error' => 'Request failed'], 500);
        }
    }

    public function getListeFraisVisiteur(int $idVisiteur)
    {
        try {
            $listeFrais = DB::table('frais')
                ->where('id_visiteur', '=', $idVisiteur)
                ->get();
            return $listeFrais;
        } catch (Exception $e) {
            return response()->json(['error' => 'Request failed'], 500);
        }
    }

}
