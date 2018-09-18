<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Server;

class RetrieveController extends Controller
{
    public function index()
    {

        // $period = \App\Period::getInstance();
        // dd($period->getDays());

        // $server = new \App\ServerDataFormatter();
        
        
        $report = new \App\Report();
        dd($report->generate());
        
        // dd($server->get());


        // dd($server->getBatchImportDates(env('SERVICENOW_IMPORT_AIG_LOCATION_SYSID'), ['','18/09/2018']));
    }
}
