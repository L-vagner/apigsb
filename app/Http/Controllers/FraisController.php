<?php

namespace App\Http\Controllers;

use App\Dao\ServiceVisiteur;
use App\Models\Frais;
use Illuminate\Http\Request;
use App\Dao\ServiceFrais;
use Illuminate\Support\Collection;
use stdClass;
use Illuminate\Support\Facades\Auth;

class FraisController extends Controller
{
    public function getFraisById($id)
    {
        $serviceFrais = new ServiceFrais();
        $frais = $serviceFrais->getFrais($id);

        $visiteur = Auth::user();

        $typeVisiteur = ServiceVisiteur::getTypeVisiteur($visiteur->type_visiteur);

        if ($visiteur->id_visiteur != $frais->id_visiteur && $typeVisiteur <= 1) {
            return redirect(route('login'));
        }
        return json_encode($visiteur);
    }

    public function ajoutFrais(Request $request)
    {
        if ($request->isJson()) {
            $request->validate([
                'anneemois' => 'required',
                'id_visiteur' => 'required',
                'nbjustificatifs' => 'required',
            ]);

            $visiteur = Auth::user();

            $typeVisiteur = ServiceVisiteur::getTypeVisiteur($visiteur->type_visiteur);
            if ($visiteur->id_visiteur != $request->json('id_visiteur') && $typeVisiteur <= 2) {
                return redirect(route('login'));
            }

            $champsFrais = new stdClass();
            $champsFrais->anneemois = $request->json('anneemois');
            $champsFrais->id_visiteur = $request->json('id_visiteur');
            $champsFrais->nbjustificatifs = $request->json('nbjustificatifs');

            $serviceFrais = new ServiceFrais();
            $idFrais = $serviceFrais->addFrais($champsFrais);
            if ($idFrais) {
                return response()->json(['message' => 'Insertion réalisé',
                    'id_frais' => $idFrais]);
            }
            return response()->json(['error' => 'Request failed'], 500);

        }
        return response()->json(['error' => 'Request must be JSON.'], 415);
    }

    public function modifFrais(Request $request)
    {
        if ($request->isJson()) {
            $request->validate([
                'id_frais' => 'required',
                'anneemois' => 'required',
                'id_visiteur' => 'required',
                'nbjustificatifs' => 'required',
                'montantvalide' => 'required',
                'id_etat' => 'required',
            ]);

            $visiteur = Auth::user();

            $typeVisiteur = ServiceVisiteur::getTypeVisiteur($visiteur->type_visiteur);

            if ($visiteur->id_visiteur != $request->json('id_visiteur') && $typeVisiteur <=2) {
                return redirect(route('login'));
            }

            $champsFrais = new stdClass();
            $champsFrais->id_frais = $request->json('id_frais');
            $champsFrais->anneemois = $request->json('anneemois');
            $champsFrais->id_visiteur = $request->json('id_visiteur');
            $champsFrais->nbjustificatifs = $request->json('nbjustificatifs');
            $champsFrais->montantvalide = $request->json('montantvalide');
            $champsFrais->id_etat = $request->json('id_etat');

            $serviceFrais = new ServiceFrais();
            $idFrais = $serviceFrais->updateFrais($champsFrais);

            return response()->json(['message' => 'Modification réalisée.',
                'id_frais' => $idFrais]);
        }
        return response()->json(['error' => 'request must be JSON.'], 415);
    }

    public function supprFrais(Request $request)
    {
        if ($request->isJson()) {
            $request->validate([
                'id_frais' => 'required',
            ]);
            $idFrais = $request->json('id_frais');

            $serviceFrais = new ServiceFrais();
            $frais = $serviceFrais->getFrais($idFrais);

            $visiteur = Auth::user();
            if ($visiteur->id_visiteur != $frais->id_visiteur) {
                return redirect(route('login'));
            }

            $serviceFrais->deleteFrais($idFrais);

            return response()->json(['message' => 'Suppression réalisée',
                'id_frais' => $idFrais]);
        }
        return response()->json(['error' => 'request must be JSON.'], 415);
    }

    public function getListeVisiteur($idVisiteur)
    {
        if (intval($idVisiteur)) {
            $serviceFrais = new ServiceFrais();

            $visiteur = Auth::user();

            $typeVisiteur = ServiceVisiteur::getTypeVisiteur($visiteur->type_visiteur);

            if ($visiteur->id_visiteur != $idVisiteur && $typeVisiteur <= 1) {
                return redirect(route('login'));
            }

            $listeFrais = $serviceFrais->getListeFraisVisiteur($idVisiteur);

            return json_encode($listeFrais);
        }
        $typeId = gettype($idVisiteur);
        return response()->json(['error' => 'id value must be of type int, type ' . $typeId . ' given'], 400);
    }
}
