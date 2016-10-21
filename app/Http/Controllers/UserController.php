<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Interests;
use Image;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
	public function profile(){
		//I didn't setup authentication so we are just going to grab the first user in the database
		//Could always Do Auth::user() to get logged in user or JWT depends on what you are using.
		$user = User::findOrFail(1);

		//grab all interests
		$interests = Interests::all();

		return view('profile', compact('user', 'interests'));
	}

	public function updatePicture(Request $request){

		//handle user image upload
		//Users Intervention Image as a provider and Image Facade provided by Intervention
		if($request->hasFile('picture')){
			$picture = $request->file('picture');
			$filename = time() . '.' . $picture->getClientOriginalExtension();
			Image::make($picture)->resize(150, 150)->save(public_path('/uploads/pictures/' . $filename));

			$user = User::findOrFail(1);
			$user->picture = $filename;
			$user->save();

		}
		return view('profile', array('user' => User::findOrFail(1)));
	}

	//Updates the user profile
	public function updateData(Request $request){

		//The checkboxes comes in as an array, so I am just converting them into a string to store in the DB
		$interestsToString = implode(",", $request->get('interests'));


		$info = [
			'name' => $request->name,
			'email' => $request->email,
			'phone' => $request->phone,
			'interests' => $interestsToString
		];

		//Didn't setup authentication so we are just going to update user 1
		//Could always Do Auth::user() to get logged in user or JWT depends on what you are using.
		$user = User::findOrFail(1);
		$rules = array(
			'name' => 'required|min:2|max:20',
			'email' => 'required|email',
			'phone' => 'required|max:14'
		);

		$validation = Validator::make($request->all(), $rules);

		if($validation->fails()){
			//Do soemthing if Validation fails

		}else{

			//if Validation passes, store the stuff
			$user->fill($info);
			$user->save();

		}
		// just return to the profile page
		return $this->profile();
	}

	public function getUserList(){
		//this just grabs all the users in the data base and passes it. This route is guarded by the middleware admin on the routes.
		return User::all();
	}
}
