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

    public static function calcularIntervaloDeHoras($entrada, $saida){
        $hora1 = explode(":",$entrada);
        $hora2 = explode(":",$saida);
        $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
        $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
        $resultado = $acumulador2 - $acumulador1;
        $hora_ponto = (floor($resultado / 3600) < 10) ? "0" . floor($resultado / 3600) : floor($resultado / 3600);
        $resultado = $resultado - ($hora_ponto * 3600);
        $min_ponto = (floor($resultado / 60) < 10) ? "0" . floor($resultado / 60) : floor($resultado / 60);
        return $hora_ponto.":".$min_ponto;
    }

}
