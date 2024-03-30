<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Place;

class PlacesController extends Controller
{
    private $place;

    public function __construct(Place $place){
        $this->place = $place;
    }

    public function index(){
        $all_places = $this->place->all();
        return view('admin.setting.places.index')->with('all_places', $all_places);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|min:1',
            'fee' => 'required|integer|min:0'
        ]);

        $this->place->name = $request->name;
        $this->place->fee = $request->fee;
        $this->place->save();

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|min:1',
            'fee' => 'required|integer|min:0'
        ]);

        $place = $this->place->findOrFail($id);
        $place->name = $request->name;
        $place->fee = $request->fee;
        $place->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->place->destroy($id);
        return redirect()->back();
    }
}
