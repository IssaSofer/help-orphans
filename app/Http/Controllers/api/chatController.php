<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\api\BaseController as Base;
use Illuminate\Http\Request;
use App\Chat;
use App\User;
use App\Posts;
use Validator;
use Response;
use DB;
use Gate;
use Auth;
class chatController extends Base
{
    public function getMessage($id, $donate, $post)
    {
        if ($id > 0 and $donate > 0 and $post > 0 ){

            if ($id == auth()->user()->id or $donate == auth()->user()->id ){

                $message = Chat::orderBy('created_at', 'desc')->get()->where( 'user_1', '=', $donate, 'user_2', '=', $id, 'post_id', '=', $post);
               
                return $this->sendResponse($message, 'get message sucssfuly');   
            }else{
                return $this->sendResponse('', 'get message sucssfuly');
            }

        }else{
            return $this->sendResponse('', 'Sorry');
        }
        
    }
    public function sendMessage(Request $request, $id, $donate, $post)
    {
        $input = $request->all();
        $input['user_1'] = $donate;
        $input['user_2'] = $id;
        $input['post_id'] = $post;
        $val = Validator::make($input,[
            'message' => 'required'
            ]);
        if($val -> fails()){
            return $this->sendError('error validation', $val->errors());
        }
        $massege = Chat::create($input);
        return $this->sendResponse($massege,'Message Create Succesfully');
    }
}
