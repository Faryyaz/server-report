<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetrieveController extends Controller
{
    public function index()
    {

        // $period = new \App\ServerDataFormatter();
        // dd($period->get());
        
        $report = new \App\Report();
        $report->generate();
    }
}
