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

class homeController extends Base
{
	public function index()
	{
        
        if (Gate::allows('kind', Auth::user())) {

            // get name user
            $name = User::all('name', 'id', 'region', 'kind')->where('id','=', auth()->user()->id, 'kind', '=', '1');

            // get all post for user login 
            $post_user = Posts::orderBy('created_at', 'desc')->take(5)->get()->where('kind_id', '=', auth()->user()->id, 'status', '=', '1');

            $array = [$post_user,$name];

            return $this->sendResponse($array, 'post');
        }

        if (Gate::denies('kind', Auth::user())) {
            $user = User::all('region', 'id')->where('id', auth()->user()->id);

            foreach ($user as $u) {

                $crop = User::all('name','region', 'id', 'kind')->where('kind','=', '1', 'region','=', $u->region);

                if (count($crop) > 0) {

                    foreach ($crop as $c) {

                        // get all post for user login 

                        $post_user = Posts::orderBy('created_at')->get()->where('kind_id','=', $c->id, 'status','=', '1'); 

                         $array = [$post_user,$c->name];
                    
                        return $this->sendResponse($array, ' gggggg'); 
                    }

                }else{
                    return $this->sendResponse('', ' gggggg'); 
                }
            }


        }
	}

    // Not login any user. This page for start app 
    public function welcome()
    {
        // get all post for user login 
        $posts = Posts::inRandomOrder()->get()->take(5)->where('status', '1');

        foreach ($posts as $post) {
            $name_crop = User::all('name', 'id')->where('id', $post->kind_id);

            $array = [$posts,$name_crop];
    
            return $this->sendResponse($array, ' gggggg'); 
        }

    }
   
}