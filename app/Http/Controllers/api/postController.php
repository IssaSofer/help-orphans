<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\api\BaseController as Base;
use Illuminate\Http\Request;
use App\Posts;
use App\User;
use Validator;
use Response;
use DB;
use Gate;
use Auth;

class postController extends Base
{

    public function __construct()
    {
        if (Gate::denies('kind', Auth::user())){
             $this->middleware('auth', ['except'=>['index','show']]);
        }
    }

	public function index() 
	{
        // get name user
		$name = User::all('name', 'id')->where('id', auth()->user()->id);
        

		// get all post for user login 
		$post_user = Posts::all()->where('kind_id', auth()->user()->id);

        $array = [$post_user,$name];

        if (Gate::allows('kind', Auth::user())) {

            if (count($post_user) > 0) {
               return $this->sendResponse($array, ' gggggg');
            }else{
              return $this->sendResponse('', ' gggggg');  
            }
        	
        }

        if (Gate::denies('kind', Auth::user())) {
            return $this->sendError('Sorry you can\'t open this page');
        	// $this->sendResponse($post_user->toArray(), ' hgfffg');
        }


	}

    // save data post in database
    public function store(Request $request) {
        if (Gate::allows('kind', Auth::user())){
            $input = $request->all();
            $input['kind_id'] = auth()->user()->id;
            $val = Validator::make($input,[
                'name'          => 'required',
                'description'   => 'required',
                'category'      => 'required|string',
                'degree'        => 'required|string',
                ]);

            if($val -> fails()){
                return $this->sendError('error validation', $val ->errors());
            }

            $post = Posts::create($input);
            return $this->sendResponse($post->toArray(),'Post Create Succesfully');
        }

        if (Gate::denies('kind', Auth::user())) {
            return $this->sendError('Sorry you can\'t open this page');
            // $this->sendResponse($post_user->toArray(), ' hgfffg');
        }

    }	

    // show all content post for user
    public function show($id) {

        $post = Posts::find($id);
        $name = User::all('name')->where('name', auth()->user()->name);
        $array = [$post,$name];
        if(is_null($post)){
            return $this->sendError('Post not found');
        }

        
        return $this->sendResponse($array,'Post read Succesfully');

    }

    // update post whene edit post
    public function update(Request $request, Posts $post) {
        $input = $request->all();
        $val = Validator::make($input,[
            'name' => 'required',
            'description' => 'required',
            ]);

        if($val -> fails()){
            return $this->sendError('error validation', $val ->errors());
        }

        $post->name = $input['name'];
        $post->description = $input['description'];
        $post->save();
        return $this->sendResponse($post->toArray(),'Post Update Succesfully');

    } 


    // close post and open post
    public function change($id) {

        $post = Posts::find($id);

        if($post->status == 1){

            $post->status = 0;
        }

        else{

            $post->status = 1;
        }
        

        $post->save();

        return redirect('home');

    } 


    // delete post
    public function destroy($id)
    {
        $post = Posts::find($id);
        $post->delete();
        return $this->sendResponse($post->toArray(), 'Post Delete Succesfully');
    }

}