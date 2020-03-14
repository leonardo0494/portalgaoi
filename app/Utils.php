<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    public static function converterDataParaPadraoAmericano($dataFormulario){
        $separaHoraDaData = explode(' ', $dataFormulario);
        $hora = $separaHoraDaData[1];
        $data = explode('/', $separaHoraDaData[0]);
    
        return $data[2] . "-" . $data[1] . "-" . $data[0] . " " . $hora;
    }
    
    public static function converterDataParaPadraoBrasileiro($dataFormulario, $hora=0){
        $separaHoraDaData = explode(' ', $dataFormulario);
        $hora = explode(':', $separaHoraDaData[1]);        
        $data = explode('-', $separaHoraDaData[0]);

        return $data[2] . "/" . $data[1] . "/" . $data[0] . " " . $hora[0] . ":" . $hora[1];
    }
}
