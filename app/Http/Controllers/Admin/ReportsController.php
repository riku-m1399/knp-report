<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Report;

class ReportsController extends Controller
{
    private $report;

    public function __construct(Report $report){
        $this->report = $report;
    }

    public function index(){
        $all_reports = $this->report->latest('date')->paginate(10);
        return view('admin.setting.reports.index')->with('all_reports', $all_reports);
    }
}
