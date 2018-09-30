<?php 
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\api\BaseController as Base;
use Illuminate\Http\Request;
use App\User;
use App\Posts;
use DB;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
use Token;
use Gate;
use Validator;


class profileController extends Base
{

	public function index()
	{
        $info = User::all()->where('id', auth()->user()->id);
        return $this->sendResponse($info->toArray(), ' gggggg');
     
	}


    public function update(Request $request,$id)
    {
        $u = User::all();
        $user = User::find($id);
        if ($id == Auth()->user()->id){
            $input = $request->all();

            $val = Validator::make($input,[ 'name' => 'required']);

            if($val -> fails()) { 
                return $this->sendError('error validation', $val ->errors()); 
            }

            if (!is_null($input['password'])) {
                $user->password = bcrypt($input['password']);
            }else{
                $user->password = Auth()->user()->password;
            }

            if (!is_null($input['asia'])) {
                $user->asia = $input['asia'];
            }else{
                $user->asia = Auth()->user()->asia;
            }

            if (!is_null($input['zain'])) {
                $user->zain = $input['zain'];
            }else{
                $user->zain = Auth()->user()->zain;
            }

            if (!is_null($input['card'])) {
                $user->card = $input['card'];
            }else{
                $user->card = Auth()->user()->card;
            }


            
            $user->kind = Auth()->user()->kind;
            $user->email = Auth()->user()->email;
            $user->save();
            return $this->sendResponse($user->toArray(),'User Update Succesfully');
        }else{
            return $this->sendError('Sorry you can\'t open this page');
        }



    }


	public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $id= (new Parser())->parse($value)->getHeader('jti');

        $token=  DB::table('oauth_access_tokens')
            ->where('id', $id)
            ->update(['revoked' => true]);

        $token = $request->user()->tokens->find($id);
        $token->revoke();
        $token->delete();

        $json = [
            'success' => true,
            'code' => 200,
            'message' => 'You are Logged out.',
        ];
        return response()->json($json, '200');
    }

}