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

    public static function calcularIntervaloDeHoras($horaEntrada, $horaSaida, $dataEntrada, $dataSaida){
        $horaEntrada = explode(":",$horaEntrada);
        $horaSaida   = explode(":",$horaSaida);
        $dataEntrada = explode("-", $dataEntrada)[2];
        $dataSaida   = explode("-", $dataSaida)[2];

        if($dataSaida > $dataEntrada){

            $horaEntradaPonto = 23 - $horaEntrada[0];
            $horaTotal        = ($horaEntradaPonto + $horaSaida[0]) + floor(($horaEntrada[1] + $horaSaida[1]) /60 );
            $minutosTotal     = floor(($horaEntrada[1] + $horaSaida[1]) % 60 );

            $horaTotal       = ($horaTotal < 10) ? "0" . $horaTotal : $horaTotal;
            $minutosTotal    = ($minutosTotal < 10) ? "0" . $minutosTotal : $minutosTotal;

            return $horaTotal . ":" . $minutosTotal;

        } else {

            $acumulador1 = ($horaEntrada[0] * 3600) + ($horaEntrada[1] * 60) + $horaEntrada[2];
            $acumulador2 = ($horaSaida[0] * 3600) + ($horaSaida[1] * 60) + $horaSaida[2];

            $resultado = $acumulador2 - $acumulador1;
            $hora_ponto = (floor($resultado / 3600) < 10) ? "0" . floor($resultado / 3600) : floor($resultado / 3600);
            $resultado = $resultado - ($hora_ponto * 3600);
            $min_ponto = (floor($resultado / 60) < 10) ? "0" . floor($resultado / 60) : floor($resultado / 60);

            return $hora_ponto.":".$min_ponto;
        }

    }

}
