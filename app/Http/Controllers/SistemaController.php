<?php

namespace App\Http\Controllers;

use App\Sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPExcel_IOFactory;

class SistemaController extends Controller
{
    public function index(){
        return view('sistemas.index');
    }

    public function save(Request $request){

        $this->_truncateSystemTable();
        $arrayDeSistemas = $this->_processarPlanilhaDeSistemas($request->file('sistemas'));
        DB::table('sistemas')->insert($arrayDeSistemas);
        return redirect()->back()->withSuccess("Sistemas cadastrados");

    }

    private function _processarPlanilhaDeSistemas($file){
        date_default_timezone_set('America/Sao_Paulo');
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj    = $excelReader->load($file);
        $excelArray = $excelObj->getActiveSheet()->toArray(null, true, true, true);
        array_shift($excelArray);
        $newSystemArray = [];

        foreach($excelArray as $systemArray){
            foreach($systemArray as $systemName){
                if($systemName != "")
                    $newSystemArray[] = [
                        "sistema" => $systemName
                    ];
            }
        }

        return $newSystemArray;

    }

    private function _truncateSystemTable(){
        $sistema = new Sistema();
        $sistema->delete();
    }

}
