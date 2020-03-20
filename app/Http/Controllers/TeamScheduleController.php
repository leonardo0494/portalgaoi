<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamScheduleController extends Controller
{
    public function construct(){ 
        $this->middleware('auth');
    }


    public function index(){
        return view('calendar.index');
    }

}
