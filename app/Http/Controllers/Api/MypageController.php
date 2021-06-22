<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;


class MypageController extends Controller
{
    public function index(){
        
    }

    public function editName(Request $request){
        User::where('id', $request->id)
        ->update(['name' => $request->name]);
    }
 
}
