<?php

namespace App\Http\Controllers;

use App\ActivityOnline;
use App\Defeito;
use App\Reports;
use App\Sistema;
use App\User;
use Illuminate\Http\Request;
use App\Utils;
use Hamcrest\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

date_default_timezone_set("America/Sao_Paulo");

class ReportsController extends Controller
{

    public function listReports()
    {
        if (Auth::user()->level_id == 1) {
            $reports = DB::table('reports')
                ->orderBy('final_atendimento', 'DESC')
                ->paginate(10);
        } else {
            $reports = DB::table('reports')
                ->where('user_id', Auth::user()->rowid)
                ->orderBy('final_atendimento', 'DESC')
                ->paginate(10);
        }

        foreach ($reports as $key => $value) { 
            /* Nome do Usuário */
            $username        = User::select('name')->where('rowid', $reports[$key]->user_id)->first(['name'])->name;
            $username        = explode(" ", $username);
            $username        = ucfirst(strtolower($username[0])) . " " . ucfirst(strtolower($username[count($username) - 1]));
            $horaDataInicial = explode(" ", $reports[$key]->inicio_atendimento);
            $horaDataFinal   = explode(" ", $reports[$key]->final_atendimento);

            $reports[$key]->sistema             = ($reports[$key]->sistema == "") ? "-" : $reports[$key]->sistema;
            $reports[$key]->tempo_atendimento   = Utils::calcularIntervaloDeHoras($horaDataInicial[1], $horaDataFinal[1], $horaDataInicial[0], $horaDataFinal[0]);
            $reports[$key]->username            = $username;
            $reports[$key]->inicio_atendimento  = Utils::converterDataParaPadraoBrasileiro($reports[$key]->inicio_atendimento);
            $reports[$key]->final_atendimento   = Utils::converterDataParaPadraoBrasileiro($reports[$key]->final_atendimento);

            unset($reports[$key]->user_id);
            unset($reports[$key]->created_at);
            unset($reports[$key]->updated_at);
        }

        return view('users.reports', ['relatorios' => $reports]);

    }

    public function detailsReports(Request $request) 
    {

        $reports                      = Reports::find($request->get('id'));
        $defeitos                     = $reports->defeitos()->get();
        $horaDataInicial              = explode(" ", $reports->inicio_atendimento);
        $horaDataFinal                = explode(" ", $reports->final_atendimento);
        $reports->tempo_atendimento   = Utils::calcularIntervaloDeHoras($horaDataInicial[1], $horaDataFinal[1], $horaDataInicial[0], $horaDataFinal[0]);
        $username                     = User::select('name')->where('rowid', $reports->user_id)->first(['name'])->name;
        $username                     = explode(" ", $username);
        $reports->username            = $username;
        $reports->inicio_atendimento  = Utils::converterDataParaPadraoBrasileiro($reports->inicio_atendimento);
        $reports->final_atendimento   = Utils::converterDataParaPadraoBrasileiro($reports->final_atendimento);

        return response()->json(
            [
                "reports" => $reports,
                "defeitos" => $defeitos
            ]
        );

    }

    public function saveReportsScreen() 
    {
        $activityOnline = ActivityOnline::where('user_id', Auth::user()->rowid)->first();
        $sistemas = Sistema::select('sistema')
            ->orderBy('sistema', 'ASC')
            ->distinct()
            ->get();

        if (($activityOnline) && ($activityOnline->hora_termino != "")) {
            return view(
                'users.save-reports', 
                [
                    "activityOnline" => $activityOnline, 
                    "sistemas" => $sistemas
                ]
            );
        } else {
            return redirect()->route('inicial');
        }

    }

    public function saveReports(Request $request) 
    {
        $reports        = new Reports();
        $activityOnline = ActivityOnline::find($request->input('id-atividade'));

        $reports->tipo = $request->input('tipo');
        $reports->sistema = $request->input('sistema');
        $reports->descricao = $request->input('descricao');
        $reports->inicio_atendimento = Utils::converterDataParaPadraoAmericano($activityOnline->hora_inicio);
        $reports->final_atendimento = Utils::converterDataParaPadraoAmericano($activityOnline->hora_termino);
        $reports->user_id = Auth::user()->rowid;

        $reports->save();

        if ($reports) {

            if ($reports->tipo== "DEFEITO" || $request->input('show_def')) {
                $this->_insertDefeitos($reports, $request);
            }

            
            if ($reports->tipo== "ARS" || $request->input('show_ars')) {
                $this->_insertArs($reports, $request);
            }
            
            ActivityOnline::find($request->input('id-atividade'))->delete();

        }

        session()->flash('status', "Atividade registrada com sucesso.");

        return redirect()->route('inicial');

    }

    public function exposeBusyResource() 
    {
        $activityOnline = new ActivityOnline();
        $activityOnline->recurso = Auth::user()->name;
        $activityOnline->user_id = Auth::user()->rowid;
        $activityOnline->hora_inicio = Utils::converterDataParaPadraoBrasileiro(date('Y-m-d H:i:s'));
        $activityOnline->save();

        return response()
            ->json(['id_atividade' => $activityOnline->id]);

    }

    public function completeBusyResourceActivity(Request $request) 
    {
        $activityOnline = ActivityOnline::find($request->input('id-atividade'));
        $activityOnline->hora_termino = Utils::converterDataParaPadraoBrasileiro(date('Y-m-d H:i:s'));
        $activityOnline->save();

        return redirect()->route('save-reports');
    }

    public function checkReport() 
    {

        $activityOnline = ActivityOnline::where(
            'user_id', 
            Auth::user()->rowid
        )->first();

        if ($activityOnline && $activityOnline->hora_termino != "") {
            return response()
                ->json(['existe' => 'finalizada']);
        } else if ($activityOnline && $activityOnline->hora_termino == "") {
            return response()
                ->json(
                    [
                        'existe' => 'iniciada',
                        'hora_inicio' => $activityOnline->hora_inicio,
                        'id_atividade' => $activityOnline->id
                    ]
                );
        }

        return response()
            ->json(['existe' => false]);

    }

    // PRIVATE METHODS 

    private function _insertDefeitos($reports, $request) 
    {
        foreach ($request->input('prj_ent') as $key => $value) {

            $prj_ent = $request->input('prj_ent')[$key];
            $defeito = $request->input('defeito')[$key];
            $categorie =  $request->input('categorie-def');
            
            if ($prj_ent == "" || $defeito == "") {
                continue;
            } else {
                $reports->defeitos()->create(
                    [
                        "prj_ent" => $prj_ent,
                        "def" => $defeito,
                        'categorie' => $categorie
                    ]
                );
            }

        }
    }

    private function _insertArs($reports, $request) 
    {
        $ars               = $request->input('chamado');
        $pendencia = $request->input('pendencia');
        $categorie   = $request->input('categorie-ars');

        $reports->arses()->create(
            [
                "ars" => $ars,
                "pendencia" => $pendencia,
                "categorie" => $categorie
            ]
        );     
    }

}
