<?php 
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\api\BaseController as Base;
use Illuminate\Http\Request;
use App\User;
use App\Posts;
use DB;
use Illuminate\Support\Facades\Auth;
use Token;
use Gate;
class searchController extends Base
{
	public function list()
	{
		// redirect to profile becuse not user
		if (Gate::allows('kind', Auth::user())){
			return redirect('profile');
		}

		// get information for crop to show on user for search
		if (Gate::denies('kind', Auth::user())){

			$crop = User::all('name', 'kind', 'region')->where('kind', '1')->whereIn('region', Auth()->user()->region);
			
            return $this->sendResponse($crop, ' gggggg');
		}
	}


	public function showcrop($id)
	{
		// redirect to profile becuse not user
		if (Gate::allows('kind', Auth::user())){
			return redirect('profile');
		}

		// get all post for crop
		if (Gate::denies('kind', Auth::user())){

			$post = Posts::all()->where('kind_id', $id, 'status', '1');

			return $this->sendResponse($post, ' gggggg');
		}	
	}


}