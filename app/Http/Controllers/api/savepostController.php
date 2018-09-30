<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\api\BaseController as Base;
use Illuminate\Http\Request;
use App\Posts;
use App\User;
use App\Savepost;
use Validator;
use Response;
use DB;
use Gate;
use Auth;

class savepostController extends Base
{
	public function index()
	{
		$save_post = Savepost::all()->where('user_id', auth()->user()->id);
		if (count($save_post) > 0) {

			foreach ($save_post as $post) {
			
				$posts = Posts::all()->where('id', $post->post_id);
				return $this->sendResponse($posts->toArray(), ' gggggg');
			}

		}else {
			return $this->sendResponse('', 'sorry you have not any post saved');
		}
	}
}