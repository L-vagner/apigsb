<?php

namespace App\Dao;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class ServiceVisiteur
{
    public static function getTypeVisiteur($idVisiteur): JsonResponse|int
    {
        try {
            $typeVisiteur = DB::table('visiteur')
                ->where('id_visiteur', '=', $idVisiteur)
                ->value('type_visiteur');


            switch ($typeVisiteur) {
                case 'I':
                    return 2;
                case 'A':
                    return 3;
                case 'C':
                    return 4;
                case 'V':
                default:
                    return 1;
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Request failed'], 500);
        }
    }
}
