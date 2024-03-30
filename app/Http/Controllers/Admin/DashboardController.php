<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Place;
use App\Models\Report;

class DashboardController extends Controller
{
    public function __construct(User $user, Place $place, Report $report){
        $this->user = $user;
        $this->place = $place;
        $this->report = $report;
    }

    public function dashboard(Request $request){
        $all_reports = $this->report->latest('date')->get();
        $all_promoters = $this->user->all();
        $all_places = $this->place->all();
        $query = $this->report->latest('date');
        $query_date = $this->report->latest('date');
        $query_promoter_date = $this->report->latest('date');

        // "$request->input()" gets the input data
        $filter_promoter = $request->input('promoter_id');
        $filter_place = $request->input('place_id');
        $filter_date_start = $request->input('date_start');
        $filter_date_end = $request->input('date_end');

        // filtering the report by the input
        if($filter_promoter != null){
            $query->where('promoter_id', $filter_promoter);
            $query_promoter_date->where('promoter_id', $filter_promoter);
        }
        if($filter_place != null){
            $query->where('place_id', $filter_place);
        }
        if($filter_date_start != null){
            $query->where('date', '>=', $filter_date_start);
            $query_date->where('date', '>=', $filter_date_start);
            $query_promoter_date->where('date', '>=', $filter_date_start);
        }
        if($filter_date_end != null){
            $query->where('date', '<=', $filter_date_end);
            $query_date->where('date', '<=', $filter_date_end);
            $query_promoter_date->where('date', '<=', $filter_date_end);
        }

        $filtered_dashboard_reports = $query->get();
        $filtered_dashboard_reports_by_date = $query_date->get();
        $filtered_dashboard_reports_by_promoter_date = $query_promoter_date->get();

        // calculating income
        $income = [];
        foreach ($all_promoters as $promoter) {
            $income_eace_place = 0;
            foreach($all_places as $place){
                $income_eace_place += $place->fee * count($filtered_dashboard_reports_by_date->where('place_id', $place->id)->where('promoter_id', $promoter->id));
            }
            $income[] = $income_eace_place;
        }

        // preparing for graph
        $graph_labels = [];
        $graph_data = [];
        foreach($all_places as $place){
            $graph_labels[] = $place->name;
            $count_entries = 0;
            foreach($filtered_dashboard_reports_by_promoter_date as $filtered_dashboard_report_by_promoter_date){
                if($filtered_dashboard_report_by_promoter_date->place_id == $place->id){
                    $count_entries += $filtered_dashboard_report_by_promoter_date->entries;
                }
            }
            $graph_data[] = $count_entries;
        }

        return view('admin.dashboard')->with('all_reports', $all_reports)->with('all_promoters',$all_promoters)->with('all_places', $all_places)->with('filtered_dashboard_reports', $filtered_dashboard_reports)->with('filtered_dashboard_reports_by_date', $filtered_dashboard_reports_by_date)->with('income', $income)->with('graph_labels', $graph_labels)->with('graph_data', $graph_data);
    }
}
