<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class PromotersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $all_promoters = $this->user->latest()->get();
        return view('admin.setting.promoters.index')->with('all_promoters', $all_promoters);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|min:1',
            'email' => 'required',
            'role_id' => 'required'
        ]);

        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();
        
        return redirect()->back();
    }
}
