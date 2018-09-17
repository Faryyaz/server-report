<?php

namespace App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Generate the excel Report
 */
class Report extends Template {

    private $writer;
    // private $period;

    public function __construct()
    {
        parent::__construct();

        $this->writer = new Xlsx($this->spreadsheet);

        // $this->period = parent::period;
    }

    public function generate()
    {
        $this->setCellData();
        $this->processCellData();
        $this->writer->save('hello worldxx.xlsx');
    }

    protected function setCellData() : array
    {
        parent::setCellData();

        $days = $this->period->getDays();
        $server = new ServerDataFormatter();
        $serverData = $server->get();
        $count = 0;
        $borderThin = [
            'top' => 'BORDER_THIN', 
            'left' => 'BORDER_THIN', 
            'right' => 'BORDER_THIN',
            'bottom' => 'BORDER_THIN'
        ];

        $serverAvaPos = [6, 15, 19, 23, 27, 31, 35];

        foreach ($days as $date => $day) {

            $countPos = 0;

            foreach($serverData as $datum) {
                array_push($this->cellData[$this->cellMap[$count]]['data'], [
                    '', $serverAvaPos[$countPos], '', 'style' => 
                    $this->getStyle(
                        'HORIZONTAL_CENTER', 
                        $borderThin, 
                        $this->getAvaStatusColor($datum['availability'][$date]->SLA_AVAILABILITY))
                ]);
                $countPos++;
            }
            $count++;
        }

        return $this->cellData;
    }

}