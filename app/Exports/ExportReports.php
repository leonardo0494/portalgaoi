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
            ->join('defeitos', 'reports.id', '=', 'defeitos.reports_id')
            ->join('arss', 'reports.id', '=', 'arss.reports_id')
            ->join('users', 'reports.user_id', '=', 'users.rowid')
            ->selectRaw(
                'reports.tipo as TIPO_ATIVIDADE,
                reports.sistema as SISTEMA,
                reports.descricao as DESCRICAO,
                reports.inicio_atendimento as DATA_INICIO,
                reports.final_atendimento as DATA_FIM,
                TIMEDIFF(reports.final_atendimento, reports.inicio_atendimento) as TOTAL_HORAS,
                defeitos.prj_ent as PROJETO,
                defeitos.def as NUMERO_DEFEITO,
                defeitos.categorie as NATUREZA,
                arss.ars as ARS_NUMERO,
                arss.categorie as ARS_CATEGORIA,
                arss.pendencia as PENDENCIA,
                users.name as USUARIO'
            )
            ->whereRaw(' date(inicio_atendimento) BETWEEN ? AND ?', [$this->start_date, $this->end_date])
            ->orderBy('inicio_atendimento');
    }

    public function headings(): array
    {
        return [
            'TIPO_ATIVIDADE',
            'SISTEMA',
            'DESCRICAO',
            'DATA_INICIO',
            'DATA_FIM',
            'TOTAL_HORAS',
            'PROJETO',
            'NUMERO_DEFEITO',
            'NATUREZA',
            'ARS_NUMERO',
            'ARS_CATEGORIA',
            'PENDENCIA',
            'USUARIO'
        ];
    }

}
