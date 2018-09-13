<?php

namespace App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Generate the excel report
 */
class Report {

    private $activeSheet;
    private $writer;
    private $period;

    private $cellData = [
        'A' => [
            'data' => [
                ['Bonjour,', 1, ''], // position 1( i.e. cell A1), no cell merging
                ['Veuillez trouver ci-dessous la météo des services Total ITSM NEXT, statut à 09h.', 2, 'E'], // position 2 (A2),  merge cells A to E
                ['Environnement PRODUCTION', 5, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement PRE-PRODUCTION ', 14, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement INTEGRATION', 18, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement RECETTE', 22, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement DEVELOPPEMENT', 26, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement RFM', 30, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement BAC-A-SABLE', 34, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement PPM', 38, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Environnement SAPHIR', 42, 'B',
                    'style' => [ 
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Incidents P1 en cours - Aucun', 46, 'F',
                    'style' => [
                        'font' => [
                            'bold' => true,
                            'color' => ['rgb'=>'3366ff']
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        ],
                        'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            ]
                        ]
                    ]
                ],
                ['Numéro', 47, '']
            ],
            'width' => 'auto'
        ],
        'B' => [
            'data' => [
                ['Détails', 47, 'F'],
                ['', 48, 'F'],
                ['', 49, 'F'],
                ['', 50, 'F'],
                ['', 51, 'F'],
                ['', 52, 'F']
            ],
            'width' => '22'
        ]
    ];

    /**
     * Excel columns, use for dynamic day
     */
    private $cellMap = [
        'C', 'D', 'E', 'F', 'G', 'H'
    ];

    public function __construct()
    {
        $spreadsheet = new Spreadsheet();
        $this->activeSheet = $spreadsheet->getActiveSheet();
        $this->writer = new Xlsx($spreadsheet);

        $this->period = Period::getInstance();
    }

    public function generate()
    {
        $this->setCellData();
        $this->processCellData();
        $this->writer->save('hello world.xlsx');
    }

    private function prepareTemplate()
    {

    }

    /**
     * set values and size of excel sheet's cells
     *
     * @return void
     */
    private function processCellData()
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

                if (array_key_exists('style', $data)) {
                    if ($data[2] !== '') {
                        $this->activeSheet->getStyle($columnValue . $data[1] . ':' . $data[2] . $data[1])->applyFromArray($data['style']);
                    } else {
                        $this->activeSheet->getStyle($columnValue . $data[1])->applyFromArray($data['style']);
                    }
                }

            }
        }
    }


    /**
     * Dynamically Add data the array cellData based on day's count
     *
     * @return array
     */
    private function setCellData() : array
    {
        $days = $this->period->getDays();
        $count = 0;

        foreach ($days as $date => $day) {
            $this->cellData[$this->cellMap[$count]] = [
                'data' => [
                    ['Statut', 5, ''],
                    ['Statut', 14, ''],
                    ['Statut', 18, ''],
                    ['Statut', 22, ''],
                    ['Statut', 26, ''],
                    ['Statut', 30, ''],
                    ['Statut', 34, ''],
                    ['Statut', 38, ''],
                    ['Statut', 42, '']
                ],
                'width' => '22'
            ];

            $this->cellData[$this->cellMap[$count + 1]] = [
                'data' => [
                    ['Notes', 5, ''],
                    ['Notes', 14, ''],
                    ['Notes', 18, ''],
                    ['Notes', 22, ''],
                    ['Notes', 26, ''],
                    ['Notes', 30, ''],
                    ['Notes', 34, ''],
                    ['Notes', 38, ''],
                    ['Notes', 42, '']
                ],
                'width' => '50'
            ];

            if (count($days) > 1) {
                array_unshift(
                    $this->cellData[$this->cellMap[$count]]['data'],
                    [strtoupper($day), 4, ''] 
                );
            }

            $count++;
        }

        return $this->cellData;
    }


}