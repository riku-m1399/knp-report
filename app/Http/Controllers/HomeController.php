<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Place;
use App\Models\Report;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, Place $place, Report $report)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->place = $place;
        $this->report = $report;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $auth_reports = $this->report->where('promoter_id', Auth::user()->id)->latest('date')->get();
        $home_reports = [];
        foreach($auth_reports as $auth_report){
            $home_reports[] = $auth_report;
        }
        $all_places = $this->place->all();
        $query = $this->report->where('promoter_id', Auth::user()->id);

        // "$request->input()" gets the input data
        $filter_place = $request->input('place_id');
        $filter_date_start = $request->input('date_start');
        $filter_date_end = $request->input('date_end');

        // filtering the report by the input
        if($filter_place != null){
            $query->where('place_id', $filter_place);
        }
        if($filter_date_start != null){
            $query->where('date', '>=', $filter_date_start);
        }
        if($filter_date_end != null){
            $query->where('date', '<=', $filter_date_end);
        }

        $filtered_home_reports = $query->latest('date')->get();
        return view('promoter.home')->with('home_reports', $home_reports)->with('all_places', $all_places)->with('filtered_home_reports', $filtered_home_reports);
    }

    public function panel(){
        if(null !== $this->report->where('promoter_id', Auth::user()->id)->oldest('date')->first()){
            $oldest_date = $this->report->where('promoter_id', Auth::user()->id)->oldest('date')->first()->date;
            $latest_date = $this->report->where('promoter_id', Auth::user()->id)->latest('date')->first()->date;
            $oldest_year = date('Y', strtotime($oldest_date));
            $latest_year = date('Y', strtotime($latest_date));
            $oldest_month = date('m', strtotime($oldest_date));
            $latest_month = date('m', strtotime($latest_date));
            
            $monthly_reports = [];
            for($year = $latest_year; $year >= $oldest_year; $year--){
                if($latest_year == $oldest_year){
                    for($month = $latest_month; $month >= $oldest_month; $month--){
                        $month_name = $year."/".$month;
                        $report = $this->report->where('promoter_id', Auth::user()->id)->whereYear('date', $year)->whereMonth('date', $month)->get();
                        if($report){
                            $monthly_reports[$month_name] = $report;
                        }
                    }
                }elseif($year == $latest_year){
                    for($month = $latest_month; $month >= 1; $month--){
                        $month_name = $year."/".$month;
                        $report = $this->report->where('promoter_id', Auth::user()->id)->whereYear('date', $year)->whereMonth('date', $month)->get();
                        if($report){
                            $monthly_reports[$month_name] = $report;
                        }
                    }
                }elseif($year == $oldest_year){
                    for($month = 12; $month >= $oldest_month; $month--){
                        $month_name = $year."/".$month;
                        $report = $this->report->where('promoter_id', Auth::user()->id)->whereYear('date', $year)->whereMonth('date', $month)->get();
                        if($report){
                            $monthly_reports[$month_name] = $report;
                        }
                    }
                }else{
                    for($month = 12; $month >= 1; $month--){
                        $month_name = $year."/".$month;
                        $report = $this->report->where('promoter_id', Auth::user()->id)->whereYear('date', $year)->whereMonth('date', $month)->get();
                        if($report){
                            $monthly_reports[$month_name] = $report;
                        }
                    }
                }
            }
            $all_places = $this->place->all();

            return view('promoter.panel')->with('monthly_reports', $monthly_reports)->with('all_places', $all_places);
        }else{
            return redirect()->route('index');
        }
    }
}
