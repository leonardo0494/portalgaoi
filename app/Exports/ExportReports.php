<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportReports implements FromQuery, WithHeadings
{

    use Exportable;

    public function __construct(string $start_date, string $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function query()
    {

        return DB::table('reports')
            ->join('users', 'reports.user_id', '=', 'users.rowid')
            ->selectRaw(
                "id,
                TIPO, 
                SISTEMA, 
                REPLACE(REPLACE(CONCAT('''', DESCRICAO), \";\", \"\"), \"\r\n\", \" \") as 'DESCRIÇÃO', 
                CASE 
                  WHEN reports.inicio_atendimento_editado IS NULL THEN 
                      TIME(reports.inicio_atendimento)
                  ELSE 
                      TIME(reports.inicio_atendimento_editado)
                END as 'INICIO',
                CASE 
                  WHEN reports.inicio_atendimento_editado IS NULL THEN 
                      TIME(reports.final_atendimento)
                  ELSE 
                      TIME(reports.final_atendimento_editado)
                END as 'FINAL',
                CASE 
                  WHEN reports.inicio_atendimento_editado IS NULL THEN 
                      TIMEDIFF(reports.final_atendimento, reports.inicio_atendimento)
                  ELSE 
                      TIMEDIFF(reports.final_atendimento_editado, reports.inicio_atendimento_editado)
                 END  as 'DURACAO',
                users.name as 'RECURSO'"
            )
            ->whereRaw('reports.user_id = users.rowid')
            ->whereRaw(' date(inicio_atendimento) BETWEEN ? AND ?', [$this->start_date, $this->end_date])
            ->orderBy('inicio_atendimento');

        // return DB::table('reports')
        //     ->join('defeitos', 'reports.id', '=', 'defeitos.reports_id')
        //     ->join('arss', 'reports.id', '=', 'arss.reports_id')
        //     ->join('users', 'reports.user_id', '=', 'users.rowid')
        //     ->selectRaw(
        //         'reports.tipo as TIPO_ATIVIDADE,
        //         reports.sistema as SISTEMA,
        //         reports.descricao as DESCRICAO,
        //         reports.inicio_atendimento as DATA_INICIO,
        //         reports.final_atendimento as DATA_FIM,
        //         TIMEDIFF(reports.final_atendimento, reports.inicio_atendimento) as TOTAL_HORAS,
        //         defeitos.prj_ent as PROJETO,
        //         defeitos.def as NUMERO_DEFEITO,
        //         defeitos.categorie as NATUREZA,
        //         arss.ars as ARS_NUMERO,
        //         arss.categorie as ARS_CATEGORIA,
        //         arss.pendencia as PENDENCIA,
        //         users.name as USUARIO'
        //     )
        //     ->whereRaw(' date(inicio_atendimento) BETWEEN ? AND ?', [$this->start_date, $this->end_date])
        //     ->orderBy('inicio_atendimento');
    }

    public function headings(): array
    {
        return [
            'ID',
            'TIPO', 
            'SISTEMA',
            'DESCRIÇÃO',
            'INICIO',
            'FINAL',
            'DURACAO',
            'RECURSO'
        ];

        // return [
        //     'TIPO_ATIVIDADE',
        //     'SISTEMA',
        //     'DESCRICAO',
        //     'DATA_INICIO',
        //     'DATA_FIM',
        //     'TOTAL_HORAS',
        //     'PROJETO',
        //     'NUMERO_DEFEITO',
        //     'NATUREZA',
        //     'ARS_NUMERO',
        //     'ARS_CATEGORIA',
        //     'PENDENCIA',
        //     'USUARIO'
        // ];
    }

}
