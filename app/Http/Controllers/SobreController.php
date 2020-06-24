<?php

namespace App\Http\Controllers;

use App\Sobre;
use Illuminate\Http\Request;

class SobreController extends Controller
{
    public function index(){
        $sobre = Sobre::select('id', 'sobre')->first();
        return view('sobre.index', [
            "sobre" => $sobre
        ]);
    }

    public function save(Request $request, int $id){
        $sobre = Sobre::find($id);
        $sobre->sobre = $request->input('sobre');
        $sobre->save();

        return redirect()->back()->withSuccess('Página atualizada');

    }

}
