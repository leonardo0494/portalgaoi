<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Utils;
use App\feriasFolga;

class feriasFolgaController extends Controller
{
    public function index()
    {

        $diaDaSemana = date('w', strtotime(date('Y-m-d')));
        $domingoPassado = ($diaDaSemana == 0) ? date('Y-m-d', strtotime("-6 days")) : date('Y-m-d', strtotime("-$diaDaSemana days"));
        $usuariosEmRecesso = feriasFolga::whereRaw(" date(end_date) > ? ", $domingoPassado)
            ->paginate(10);
  
        $users = User::all();

        //dd($usuariosEmRecesso);

        foreach($usuariosEmRecesso as $recesso){
            $recesso->start_date_mod = Utils::converterDataParaPadraoBrasileiroSemHora($recesso->start_date);
            $recesso->end_date_mod = Utils::converterDataParaPadraoBrasileiroSemHora($recesso->end_date);
            $recesso->username = User::where("rowid", $recesso->user_id)->select('name')->first()['name'];
        }

        return view("ferias_folga.index",
            [
                "usuariosEmRecesso" => $usuariosEmRecesso,
                "users" => $users
            ]
        );
    }

    public function salvarFeriasFolga(Request $request)
    {   

        //dd($request);

        // Inserindo semanas
        $quantidadeSemans = 5;

        for ($x=1; $x<$quantidadeSemans; $x++) {
            if ($request->input("usuarios-semana-$x")) {
                $data = explode('-', $request->input("semana$x"));
                $usuario = $request->input("usuarios-semana-$x");
                $tipo = trim($request->input("usuario-tipo-$x"));
                $startDate = (string) trim($data[0]) . " 00:00:00";
                $endDate   = (string) trim($data[1]) . " 00:00:00";
                $startDateWithtHour = Utils::converterDataParaPadraoAmericano($startDate);
                $endDateWithtHour = Utils::converterDataParaPadraoAmericano($endDate);

                $feriasFolga = new feriasFolga();
                $feriasFolga->start_date = $startDateWithtHour;
                $feriasFolga->end_date = $endDateWithtHour;
                $feriasFolga->tipo = $tipo;
                $feriasFolga->user_id = $usuario;
                $feriasFolga->save();

            }
        }

        session()->flash('status', "Férias/Folgas cadastradas com sucesso.");

        return redirect()->back();

    }

    public function excluirFeriasFolga(int $id)
    {   
        feriasFolga::where('id', $id)->delete();
        session()->flash('status', "Férias/Folgas deletada com sucesso.");
        return redirect()->back();
    }

}
