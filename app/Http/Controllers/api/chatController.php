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
    public function getMessage($id, $post )
    {
		if ($id > 0 and $post > 0){
			
	    	$user = User::all('id');

	    	$post_id = Posts::all()->where('id', '=', $post, 'kind_id', '=', $user);

	    	
	    	foreach ($post_id as $p) {

	    		$message = Chat::orderBy('created_at', 'desc')->get()->where( 'user_1', '=', auth()->user()->id, 'user_2', '=', $id, 'post_id', '=', $p->id);

	    		return $this->sendResponse($message, 'get message sucssfuly');
	    	}


		}else{
			return $this->sendResponse('', 'Sorry');
		}
    	
    }

    public function sendMessage(Request $request, $id, $crop, $post)
    {

        $input = $request->all();
        $input['user_1'] = $crop;
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
