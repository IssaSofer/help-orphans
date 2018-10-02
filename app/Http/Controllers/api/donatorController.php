<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\api\BaseController as Base;
use Illuminate\Http\Request;
use App\Donator;
use App\User;
use App\Donator;
use Validator;
use Response;
use DB;
use Gate;
use Auth;

class donatorController extends Base
{

    public function __construct()
    {
        if (Gate::denies('kind', Auth::user())){
             $this->middleware('auth:api', ['except'=>['index']]);
        }
    }
    // show donate for crop
    public function index()
    {
        $user = User::all('id');

        $donate = Donator::all()->where('user_id', $user->id);

        return $this->sendResponse($donate->toArray(),'Post read Succesfully');
    }

    //insert data in database
    public function story($id, Request $request)
    {
        $input = $request->all();
        $val = Validator::make($input,[
            'asia'        => 'required|integer',
            'zain'        => 'required|integer',
            'card'        => 'required|integer'
            ]);

        if($val -> fails()){
            return $this->sendError('error validation', $val ->errors());
        }

        $donate = Donator::create($input);
        return $this->sendResponse($donate->toArray(),'Donate Create Succesfully');
    }

    // update post whene edit post
    public function update(Request $request, Donator $donate) {
        $input = $request->all();
        $val = Validator::make($input,[
            'asia'        => 'required|integer',
            'zain'        => 'required|integer',
            'card'        => 'required|integer'
            ]);

        if($val -> fails()){
            return $this->sendError('error validation', $val ->errors());
        }

        $donate->save();
        return $this->sendResponse($donate->toArray(),'Donate Update Succesfully');

    } 

}
