<?php

namespace App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report {

    private $activeSheet;
    private $writer;
    private $cellData = [
        'A' => [
            'data' => [
                ['Bonjour,', 1, ''], // position 1( i.e. cell A1), no cell merging
                ['Veuillez trouver ci-dessous la météo des services Total ITSM NEXT, statut à 09h.', 2, 'D'], // position 2 (A2),  merge cells A to D
                ['Environnement PRODUCTION', 5, 'B'],
                ['Environnement PRE-PRODUCTION', 14, 'B'],
                ['Environnement INTEGRATION', 18, 'B'],
                ['Environnement RECETTE', 22, 'B'],
                ['Environnement DEVELOPPEMENT', 26, 'B'],
                ['Environnement RFM', 30, 'B'],
                ['Environnement BAC-A-SABLE', 34, 'B'],
                ['Environnement PPM', 38, 'B'],
                ['Environnement SAPHIR', 42, 'B'],
                ['Incidents P1 en cours - Aucun', 46, 'F'],
                ['Numéro', 47, '']
            ],
            'width' => 'auto'
        ],
        // 'B' => [
        //     'text' => [

        //     ],
        //     'width' => 'auto'
        // ]
    ];

    public function __construct()
    {
        $spreadsheet = new Spreadsheet();
        $this->activeSheet = $spreadsheet->getActiveSheet();
        $this->writer = new Xlsx($spreadsheet);
    }

    public function generate()
    {
        
        $this->setCellData();
        $this->writer->save('hello world.xlsx');
    }

    private function prepareTemplate()
    {

    }

    private function setCellData()
    {
        foreach ($this->cellData as $columnValue=>$cellValues) {

            if ($cellValues['width'] === 'auto') {
                $this->activeSheet->getColumnDimension($columnValue)->setAutoSize(true);
            } else {
                $this->activeSheet->getColumnDimension($columnValue)->setWidth($cellValues['width']);
            }

            foreach ($cellValues['data'] as $key=>$data) {
                $this->activeSheet->setCellValue($columnValue . $data[1], $data[0]);

                if ($data[2] !== '') {
                    $this->activeSheet->mergeCells($columnValue . $data[1] . ':' . $data[2] . $data[1]);
                }

            }
        }
    }


}