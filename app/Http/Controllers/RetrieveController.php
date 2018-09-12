<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetrieveController extends Controller
{
    public function index()
    {

        // $period = \App\Period::getInstance();
        // dd($period->countDays());
        
        $report = new \App\Report();
        $report->generate();
    }
}
