<?php

namespace App\Http\Controllers;
use App\Activity;
use App\Mail\NotificacaoGmud;
use App\User;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ActivityController extends Controller
{
    public function construct(){
        $this->middleware('auth');
    }

    public function index(){

        // Para consultar os levels, fazer select na tabela levels.
        $resultsPerPage = 10;
        $users = User::all();
        $activities = (\Auth::user()->level_id == 1) ? Activity::orderBy('status', 'asc')->paginate($resultsPerPage) : Activity::where('user_id', \Auth::user()->rowid)->orderby('status', 'asc')->paginate($resultsPerPage);

        return view('activity.list', ['atividades' => $activities, 'usuarios' => $users]);
    }

    public function create(Request $request){
        
        $activity = new Activity;
        $executor = User::find($request->input('user_id'));

        $activity->ars_number = $request->input('ars_number');
        $activity->ttype      = $request->input('ttype');
        $activity->user_id    = $request->input('user_id');
        $activity->start_date = Utils::converterDataParaPadraoAmericano($request->input('start_date'));
        $activity->end_date   = Utils::converterDataParaPadraoAmericano($request->input('end_date'));

        $activity->save();

        $activity->start_date = Utils::converterDataParaPadraoBrasileiro($activity->start_date);
        $activity->end_date   = Utils::converterDataParaPadraoBrasileiro($activity->end_date);

        Mail::to($executor->email)
            ->send(new NotificacaoGmud($activity, $executor));

        //dd($activity);

        return redirect()->route('atividades');

    }

    public function searchById(Request $request){
        $activity = Activity::find($request->get('id'));

        $atividade = [
            'tipo' => $activity->ttype,
            'numero_atividade' => $activity->ars_number,
            'data_inicio' => Utils::converterDataParaPadraoBrasileiro($activity->start_date),
            'data_fim' => Utils::converterDataParaPadraoBrasileiro($activity->end_date),
            'descricao' => $activity->description,
            'status' => $activity->status
        ];

        return $atividade;
    }

    public function update(Request $request){
        $activity = Activity::find($request->get('id'));
        $activity->status = ($request->get('tipo') == 'concluir') ? "CONCLUÍDO" : "CANCELADA";
        $activity->save();
        
        return $activity->status;
    }

}
