<?php

namespace App\Http\Controllers;

use App\PlantaoEquipe;
use App\User;
use App\Utils;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
class PlantaoEquipeController extends Controller
{
    public function index()
    {
        $users = User::select("rowid", "name")->get();
        return view("plantao.index",
            [
                "users" => $users
            ]
        );
    }

    public function salvarPlantao(Request $request)
    {

        dd($request);


        /*

        $dataFormulario = explode('-', $request->input('plantao'));
        $startDate      = (string) trim($dataFormulario[0]) . " 00:00:00";
        $endDate        = (string) trim($dataFormulario[1]) . " 00:00:00";
        $startDate      = Utils::converterDataParaPadraoAmericano($startDate);
        $endDate        = Utils::converterDataParaPadraoAmericano($endDate);

        dd($startDate);

        */

    }

}
