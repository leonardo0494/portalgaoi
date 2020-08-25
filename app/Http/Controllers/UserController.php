<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Level;
use App\Activity;
use App\ActivityOnline;
use App\Notice;
use App\PlantaoEquipe;
use App\PlantaoEquipeUser;
use App\Reports;
use Illuminate\Support\Facades\Storage;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function construct(){
        $this->middleware('auth');
    }

    public function index(){

        $resultsPerPage = 10;
        $users = User::all();
        $notices = Notice::where('status', 'PENDENTE')->get();
        $activiyOnline = ActivityOnline::select('recurso', 'hora_inicio')->get();
        $activities = (Auth::user()->level_id == 1) ? Activity::where('status', 'ABERTO')->orderBy('status', 'asc')->paginate($resultsPerPage) : Activity::where('user_id', Auth::user()->rowid)->where('status', 'ABERTO')->orderby('status', 'asc')->paginate($resultsPerPage);

        $diaDaSemana     = date('w', strtotime(date('Y-m-d')));
        $domingoPassado  = ($diaDaSemana == 0) ? date('Y-m-d', strtotime("-6 days")) : date('Y-m-d', strtotime("-$diaDaSemana days"));
        $plantao         = PlantaoEquipe::select('id')->whereRaw(" date(start_date) > ? ", $domingoPassado)->skip(0)->take(1)->first();
	$usuariosPlantao = [];

	if ($plantao) {

		$equipePlantao   = PlantaoEquipeUser::select('user_id')->where('plantao_equipe_id', $plantao->id)->get();
        

	        foreach($equipePlantao as $recurso) {
        	    $usuario           = User::select('name', 'work_phone', 'personal_phone')->where('rowid', $recurso->user_id)->first();
	            $usuariosPlantao[] = [
        	        "name" => $usuario->name,
                	"work_phone" => $usuario->work_phone,
	                "personal_phone" => $usuario->personal_phone
        	    ];
	        }
	}

        return view('users.home',
            [
                'atividades' => $activities,
                'usuarios' => $users,
                'notices' => $notices,
                'recursosOcupados' => $activiyOnline,
                'usuariosPlantao' => $usuariosPlantao
            ]
        );
    }

    public function perfil(){
        return view('users.perfil')->with('mensagem', "Atividade registrada com sucesso.");
    }

    public function update(Request $request) {

        // UPLOAD PROFILE IMAGE

        $profileImage     = $request->file('profile_image');
        $profileImageName = "";

        if($profileImage != null){
            if(\Auth::user()->profile_image != "" && \Auth::user()->profile_image != "perfil-user.jpg")
                Storage::disk('public')->delete('imagens/' . $profileImage->hashName());

            Storage::disk('public')->put('imagens', $profileImage);

            $profileImageName = $profileImage->hashName();
        }

        // SALVANDO DADOS NO BANCO JUNTO COM A REFERÊNCIA DA IMAGEM
        $workPhohe        = $request->input('work_phone');
        $personalPhone    = $request->input('personal_phone');
        $loginOi          = $request->input('login_oi');
        $loginRemedy      = $request->input('login_remedy');
        $password         = ($request->input('password') != "") ? Hash::make($request->input('password')) : null;

        $selectUserLogado = User::find(\Auth::user()->rowid);
        $selectUserLogado->profile_image = $profileImageName;
        $selectUserLogado->work_phone = $workPhohe;
        $selectUserLogado->personal_phone = $personalPhone;
        $selectUserLogado->login_oi = $loginOi;
        $selectUserLogado->login_remedy = $loginRemedy;

        if($password != null)
            $selectUserLogado->password = $password;

        $selectUserLogado->save();

        return redirect()->route('perfil');

    }

    public function list() {
        $Users = User::all(['name', 'email', 'work_phone', 'personal_phone', 'login_oi', 'login_remedy', 'period']);
        return view('users.list', ['usuarios' => $Users]);
    }

}

