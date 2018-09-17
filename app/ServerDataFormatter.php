<?php

namespace App;

//Get the data from the different servers
class ServerDataFormatter {

    private $data = [];

    public function get() : array
    {
        $server = new Server();
        $period = Period::getInstance();
        
        return $this->data = [
            'prod' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_PROD_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
            'preprod' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_PPROD_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
            'int' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_INT_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
            'rec' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_REC_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
            'dev' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_DEV_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
            'form' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_FORM_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
            'bas' => [
                'availability' => $this->getAvailability(
                    env('IPLABEL_BAS_MONITOR_ID'),
                    $period->get()
                ),
                'backup' => $server->getBackupStatus()
            ],
        ];
    }

    /**
     * Get the server availability based on input dates
     *
     * @param string $monitorId
     * @param string $dates
     * @return array
     */
    private function getAvailability(string $monitorId,string $dates) : array
    {
        $server = new Server();
        $availability = [];
        for($i = 0; $i < count($dates) - 1; $i++) {

            $startDate = $dates[$i];
            $endDate = $dates[$i + 1];

            $availability[$endDate] = $server->getStatus(
                                $monitorId,
                                $startDate . ' 09:00:00',
                                $endDate . ' 09:00:00'
                            );

        }

        return $availability;
    }
    

    private function getBatchImportDates()
    {
        
    }
}