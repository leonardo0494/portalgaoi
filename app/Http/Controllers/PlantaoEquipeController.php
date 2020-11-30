<?php

namespace App\Http\Controllers;

use App\PlantaoEquipe;
use App\User;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
class PlantaoEquipeController extends Controller
{
    public function index()
    {
        $users = User::select("rowid", "name")->get();

        $diaDaSemana = date('w', strtotime(date('Y-m-d')));
        $domingoPassado = ($diaDaSemana == 0) ? date('Y-m-d', strtotime("-6 days")) : date('Y-m-d', strtotime("-$diaDaSemana days"));
        $plantoes = PlantaoEquipe::select('id', 'start_date', 'end_date')
            ->whereRaw(" date(start_date) > ? ", $domingoPassado)
            ->skip(0)
            ->take(8)
            ->get();
        return view("plantao.index",
            [
                "users" => $users,
                "plantoes" => $plantoes
            ]
        );
    }

    public function salvarPlantao(Request $request)
    {
        // Inserindo semanas
        $quantidadeSemans = 5;

        for ($x=1; $x<$quantidadeSemans; $x++) {
            if ($request->input("usuarios-semana-$x")) {

                $data = explode('-', $request->input("semana$x"));
                $startDate = (string) trim($data[0]) . " 00:00:00";
                $endDate   = (string) trim($data[1]) . " 00:00:00";

                $startDateWithoutHour = Utils::converterDataParaPadraoAmericanoSemHora($startDate);

                /**
                 * VERIFICANDO SE JÁ EXISTE A SEMANA CADASTRADA.
                 *
                 * Se já existir, vamos apagar os usuários alocados e reinserir
                 * com os novos.
                 *
                 * */

                $plantao = PlantaoEquipe::select('id')->whereRaw( 'date(start_date) = ? ', $startDateWithoutHour)->first();

                if ($plantao) {

                    DB::table('plantao_equipe_users')->where('plantao_equipe_id', $plantao->id)->delete();

                } else {

                    $startDate = Utils::converterDataParaPadraoAmericano($startDate);
                    $endDate   = Utils::converterDataParaPadraoAmericano($endDate);

                    $plantao = new PlantaoEquipe();
                    $plantao->start_date = $startDate;
                    $plantao->end_date = $endDate;
                    $plantao->save();

                }

                // Inserção de Usuários no plantão.

                $usuariosPlantao = [];

                foreach($request->input("usuarios-semana-$x") as $usuario){
                    $usuariosPlantao[] = [
                        "user_id" => $usuario,
                        "plantao_equipe_id" => $plantao->id
                    ];
                }

                DB::table('plantao_equipe_users')->insert($usuariosPlantao);

            }
        }

        session()->flash('status', "Semana(s) salva com sucesso.");

        return redirect()->back();

    }

}
