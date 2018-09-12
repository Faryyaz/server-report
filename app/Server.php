<?php

namespace App;

//Get the data from the different servers
class Server {

    // get data of IPLABEL
    public function getStatus(int $monitorId, string $startDate, string $endDate) : array
    {
        $url = env('IPLABEL_API_URL') . 'Get_KPI/';
        $username = env('IPLABEL_API_USERNAME');
        $password = env('IPLABEL_API_PASSWORD');
        $query = [
            'monitor_id' => $monitorId,
            'date_value1' => $startDate,
            'date_value2' => $endDate,
        ];

        $serverData = new ServerData(
            $url,
            $username,
            $password,
            $query
        );
        return $serverData->get()->Ipln_WS_REST_datametrie->Get_KPI->response;
    }

    public function getBackupStatus()
    {
        // backup server logic here
        return [];
    }
    
}