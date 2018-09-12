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
            ]
        ];
    }

    private function getAvailability($monitorId, $dates) : array
    {
        $server = new Server();
        $availability = [];
        for($i = 0; $i < count($dates) - 1; $i++) {

            $startDate = $dates[$i] . ' 09:00:00';
            $endDate = $dates[$i + 1] . ' 09:00:00';

            array_push($availability,
                $server->getStatus(
                    $monitorId,
                    $startDate,
                    $endDate
                )
            );

        }

        return $availability;
    }
    
}