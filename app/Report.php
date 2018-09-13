<?php

namespace App;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * Generate the excel report
 */
class Report {

    private $activeSheet;
    private $writer;
    private $period;
    const titleStyleLeftAligned = [ 
        'font' => [
            'bold' => true,
            'color' => ['rgb'=>'3366ff']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_LEFT,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => Border::BORDER_MEDIUM,
            ],
            'left' => [
                'borderStyle' => Border::BORDER_MEDIUM,
            ],
            'bottom' => [
                'borderStyle' => Border::BORDER_MEDIUM,
            ],
            'right' => [
                'borderStyle' => Border::BORDER_MEDIUM,
            ]
        ]
    ];   

    private $cellData = [
        'A' => [
            'data' => [
                ['Bonjour,', 1, ''], // position 1( i.e. cell A1), no cell merging
                ['Veuillez trouver ci-dessous la météo des services Total ITSM NEXT, statut à 09h.', 2, 'E'], // position 2 (A2),  merge cells A to E
                ['Environnement PRODUCTION', 5, 'B',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Environnement PRE-PRODUCTION ', 14, 'B',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Environnement INTEGRATION', 18, 'B',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Environnement RECETTE', 22, 'B',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Environnement DEVELOPPEMENT', 26, 'B',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Environnement RFM', 30, 'B',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Environnement BAC-A-SABLE', 34, 'B',
                    'style' => self::titleStyleLeftAligned
            ],
                ['Incidents P1 en cours - Aucun', 38, 'F',
                    'style' => self::titleStyleLeftAligned
                ],
                ['Numéro', 39, '']
            ],
            'width' => 'auto'
        ],
        'B' => [
            'data' => [
                ['Disponibilité de service', 6, ''],
                ['Sauvegarde', 7, ''],
                ['Batch AIG Location', 8, ''],
                ['Batch AIG Department', 9, ''],
                ['Batch AIG Users', 10, ''],
                ['TGS HYPERVISEUR', 11, ''],
                ['Disponibilité de service', 6, ''],
                ['Sauvegarde', 7, ''],
                ['Disponibilité de service', 15, ''],
                ['Sauvegarde', 16, ''],
                ['Disponibilité de service', 19, ''],
                ['Sauvegarde', 20, ''],
                ['Disponibilité de service', 23, ''],
                ['Sauvegarde', 24, ''],
                ['Disponibilité de service', 27, ''],
                ['Sauvegarde', 28, ''],
                ['Disponibilité de service', 31, ''],
                ['Sauvegarde', 32, ''],
                ['Détails', 39, 'F'],
                ['', 40, 'F'],
                ['', 41, 'F'],
                ['', 42, 'F'],
                ['', 43, 'F']
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
     * set values,style and size of excel sheet's cells
     *
     * @return void
     */
    private function processCellData() : void
    {
        
        foreach ($this->cellData as $columnValue=>$cellValues) {

            if (isset($cellValues['width'])) {
                if ($cellValues['width'] === 'auto') {
                    $this->activeSheet->getColumnDimension($columnValue)->setAutoSize(true);
                } else {
                    $this->activeSheet->getColumnDimension($columnValue)->setWidth($cellValues['width']);
                }
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
                    ['Statut', 5, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ],
                    ['Statut', 14, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ],
                    ['Statut', 18, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ],
                    ['Statut', 22, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ],
                    ['Statut', 26, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ],
                    ['Statut', 30, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ],
                    ['Statut', 34, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ]
                ],
                'width' => '22'
            ];

            $this->cellData[$this->cellMap[$count + 1]] = [
                'data' => [
                    ['Notes', 5, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['Notes', 14, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['Notes', 18, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['Notes', 22, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['Notes', 26, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['Notes', 30, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['Notes', 34, '',
                        'style' => $this->getStyle('HORIZONTAL_LEFT')
                    ],
                    ['', 6, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 7, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 8, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 9, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 10, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 11, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 15, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 16, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 19, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 20, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 23, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 24, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 27, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 28, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 31, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 32, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 35, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 36, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])]
                ],
                'width' => '50'
            ];

            if (count($days) > 1) {
                array_unshift(
                    $this->cellData[$this->cellMap[$count]]['data'],
                    [strtoupper($day), 4, '',
                        'style' => $this->getStyle('HORIZONTAL_CENTER')
                    ]
                );
            }

            $count++;
        }

        $incidentTableData = [
            ['', 39, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
            ['', 40, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
            ['', 41, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
            ['', 42, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
            ['', 43, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])]
        ];

        if (isset($this->cellData['F'])) {
            foreach($incidentTableData as $tableData) {
                array_push($this->cellData['F']['data'], $tableData);
            }
        } else {
            // set the border for incident p1 table
            $this->cellData['F'] = [
                'data' => [
                    ['', 39, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 40, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 41, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 42, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])],
                    ['', 43, '', 'style' => $this->getStyle('HORIZONTAL_CENTER', ['right'=>'BORDER_MEDIUM'])]
                ]
            ];
        }

        return $this->cellData;
    }

    /**
     * Return the style for title
     *
     * @param string $textAlignment HORIZONTAL_CENTER | HORIZONTAL_LEFT | HORIZONTAL_RIGHT
     * @param array $border ['top'=> 'BORDER_THICK', 'left'=> 'BORDER_THIN', 'right'=> 'BORDER_MEDIUM']
     * @return array
     */
    private function getStyle(
        string $textAlignment = 'HORIZONTAL_CENTER', 
        array $border = [
                            'top' => 'BORDER_MEDIUM', 
                            'left' => 'BORDER_MEDIUM', 
                            'right' => 'BORDER_MEDIUM',
                            'bottom' => 'BORDER_MEDIUM',
                        ]
    ) : array
    {
        return [
            'font' => [
                'bold' => true,
                'color' => ['rgb'=>'3366ff']
            ],
            'alignment' => [
                'horizontal' => constant('\PhpOffice\PhpSpreadsheet\Style\Alignment::' . $textAlignment),
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => isset($border['top']) ? constant('\PhpOffice\PhpSpreadsheet\Style\Border::' . $border['top']) : Border::BORDER_NONE,
                ],
                'left' => [
                    'borderStyle' => isset($border['left']) ? constant('\PhpOffice\PhpSpreadsheet\Style\Border::' . $border['left']) : Border::BORDER_NONE,
                ],
                'bottom' => [
                    'borderStyle' => isset($border['bottom']) ? constant('\PhpOffice\PhpSpreadsheet\Style\Border::' . $border['bottom']) : Border::BORDER_NONE,
                ],
                'right' => [
                    'borderStyle' => isset($border['right']) ? constant('\PhpOffice\PhpSpreadsheet\Style\Border::' . $border['right']) : Border::BORDER_NONE,
                ]
            ]
        ];
    }


}