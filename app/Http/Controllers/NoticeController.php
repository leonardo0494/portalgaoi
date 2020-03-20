<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\NotificaoNotice;
use Illuminate\Support\Facades\Mail;

class NoticeController extends Controller
{
    public function construct(){
        $this->middleware('auth');
    }

    public function create(Request $request){
        $notice = new Notice();
        $notice->title = $request->input('title');
        $notice->description = $request->input('description');
        $notice->status = 'PENDENTE';
        $notice->user_id = Auth::user()->rowid;
        $notice->save();

        Mail::to('leonardo.lima@trescon.com.br')->send(new NotificaoNotice($notice, \App\User::find($notice->user_id)->name));

        return redirect()->route('home');

    }

    public function destroy($id){
        $notice = Notice::where('rowid', $id)->first();

        if($notice != null){
            $notice->status = 'CONCLUÍDO';
            $notice->save();
        }

        return redirect()->route('home');

    }

}
