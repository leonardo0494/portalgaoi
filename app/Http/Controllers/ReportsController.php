<?php

namespace App\Http\Controllers;

use App\Reports;
use App\User;
use Illuminate\Http\Request;
use App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

date_default_timezone_set("America/Sao_Paulo");

class ReportsController extends Controller
{

    public function listReports(){
        if(Auth::user()->level_id == 1){
            $reports = DB::table('reports')->orderBy('inicio_atendimento', 'DESC')->get();
        } else {
            $reports = DB::table('reports')->where('user_id', Auth::user()->rowid)->orderBy('inicio_atendimento', 'DESC')->get();
        }
        
        foreach($reports as $key => $value){
            /* Nome do Usuário */
            $username        = User::select('name')->where('rowid', $reports[$key]->user_id)->first(['name'])->name;
            $username        = explode(" ", $username);
            $username        = ucfirst(strtolower($username[0])) . " " . ucfirst(strtolower($username[count($username) - 1]));
            $horaInicial     = explode(" ", $reports[$key]->inicio_atendimento)[1];
            $horaFinal       = explode(" ", $reports[$key]->final_atendimento)[1];
            
            $reports[$key]->prj_ent             = ($reports[$key]->prj_ent == "") ? "-" : $reports[$key]->prj_ent;
            $reports[$key]->def                 = ($reports[$key]->def == "") ? "-" : $reports[$key]->def;
            $reports[$key]->ars                 = ($reports[$key]->ars == "") ? "-" : $reports[$key]->ars;
            $reports[$key]->sistema             = ($reports[$key]->sistema == "") ? "-" : $reports[$key]->sistema;
            $reports[$key]->tempo_atendimento   = Utils::calcularIntervaloDeHoras($horaInicial, $horaFinal);
            $reports[$key]->username            = $username;
            $reports[$key]->inicio_atendimento  = Utils::converterDataParaPadraoBrasileiro($reports[$key]->inicio_atendimento);
            $reports[$key]->final_atendimento   = Utils::converterDataParaPadraoBrasileiro($reports[$key]->final_atendimento);

            unset($reports[$key]->user_id);
            unset($reports[$key]->created_at);
            unset($reports[$key]->updated_at);
        }

        return view('users.reports', ['relatorios' => $reports]);

    }

    public function saveReports(Request $request) {

        $reports = new Reports();

        $reports->tipo = $request->input('tipo');
        $reports->prj_ent = $request->input('prj_ent');
        $reports->def = $request->input('defeito');
        $reports->ars = $request->input('chamado');
        $reports->pendencia = $request->input('pendencia');
        $reports->sistema = $request->input('sistema');
        $reports->descricao = $request->input('descricao');
        $reports->inicio_atendimento = $request->input('hora-inicio-real');
        $reports->final_atendimento = $request->input('hora-fim-real');
        $reports->user_id = Auth::user()->rowid;

        $reports->save();

        return redirect()->route('home');

    }
}
