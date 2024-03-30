<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Place;
use App\Models\Report;

class ReportController extends Controller
{
    private $report;

    public function __construct(User $user, Place $place, Report $report){
        $this->user = $user;
        $this->place = $place;
        $this->report = $report;
    }

    public function create(){
        $all_users = $this->user->all();
        $all_places = $this->place->all();
        return view('report.create')->with('all_users', $all_users)->with('all_places', $all_places);
    }

    public function store(Request $request){
        #1 Validation
        $request->validate([
            'promoter_id' => 'integer|min:1|required',
            'place_id' => 'integer|min:1|required',
            'entries' => 'integer|min:0|required',
            'date' => 'date|required',
            'note' => 'nullable'
        ]);

        #2 Recieve all date from the form
        $this->report->promoter_id = $request->promoter_id;
        $this->report->place_id = $request->place_id;
        $this->report->entries = $request->entries;
        $this->report->date = $request->date;
        $this->report->note = $request->note;

        $this->report->save();

        #3 Go back to homepage
        return redirect()->route('index');
    }

    public function edit($id){
        $report = $this->report->findOrFail($id);

        // If tha auth user is neither the promoter of the report nor the admins, redirect to homepage
        if(Auth::user()->id != $report->promoter_id && Auth::user()->role_id != 1){
            return redirect()->route('index');
        }

        $all_users = $this->user->all();
        $all_places = $this->place->all();

        return view('report.edit')->with('report', $report)->with('all_users', $all_users)->with('all_places', $all_places);
    }

    public function update(Request $request, $id){
        #1 Validation
        $request->validate([
            'promoter_id' => 'integer|min:1|required',
            'place_id' => 'integer|min:1|required',
            'entries' => 'integer|min:0|required',
            'date' => 'date|required',
            'note' => 'nullable'
        ]);

        #2 Update the report
        $report = $this->report->findOrFail($id);

        $report->promoter_id = $request->promoter_id;
        $report->place_id = $request->place_id;
        $report->entries = $request->entries;
        $report->date = $request->date;
        $report->note = $request->note;

        $report->save();

        #3 Redirect to home
        return redirect()->route('index');
    }

    public function destroy($id){
        $this->report->destroy($id);

        return redirect()->back();
    }
}
