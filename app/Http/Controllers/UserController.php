<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Level;
use App\Activity;
use App\Notice;
use App\TeamSchedule;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

    public function construct(){
        $this->middleware('auth');
    }

    public function index(){
        
        $resultsPerPage = 10;
        $users = User::all();
        $notices = Notice::where('status', 'PENDENTE')->get();
        $activities = (\Auth::user()->level_id == 1) ? Activity::orderBy('status', 'asc')->paginate($resultsPerPage) : Activity::where('user_id', \Auth::user()->rowid)->orderby('status', 'asc')->paginate($resultsPerPage);

        return view('users.home', ['atividades' => $activities, 'usuarios' => $users, 'notices' => $notices]);
    }

    public function perfil(){
        return view('users.perfil');
    }

    public function update(Request $request){

        // UPLOAD PROFILE IMAGE

        $profileImage     = $request->file('profile_image');
        $profileImageName = "";

        if($profileImage != null){
            if(\Auth::user()->profile_image != "")
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

}

