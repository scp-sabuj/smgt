<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;




// class AuthorityController extends Controller
class AuthorityController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        return view('admin.adminlist',['users' => $users]);
        // return view('admin.adminlist');
    }



    public function create(Request $request)
    {   

        // return $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'profit_percentage' => ['required'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        

        $fileNameToStore = "";
        
        if(request()->hasFile('profile_photo_path')){
    		// Get filename with the extension
            $filenameWithExt = $request->file('profile_photo_path')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('profile_photo_path')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= 'profile-photos/'.$filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('profile_photo_path')->storeAs('public', $fileNameToStore);
    	}

        

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->type = $request->user_type;
        $user->profit_percentage = $request->profit_percentage;
        $user->profile_photo_path = $fileNameToStore;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success');
        
    }

    public function delete($id)
    {
		$user = User::find($id);
        if($user->profile_photo_path){
		unlink('storage/'.$user->profile_photo_path);
		}
        $user->delete();
        if($user){
    		$notification = array(
	            'messege' => 'user deleted Successful',
	            'alert-type' => 'success',
	        );
    		return redirect()->back()->with($notification);
    	}else{
    		$notification = array(
	            'messege' => 'Ups..user not deleted',
	            'alert-type' => 'error',
	        );
	        return redirect()->back()->with($notification);
    	}
    }

    public function edit($id ,Request $request)
    {
		// return $id;
        $request->validate([
            'profit_percentage' => ['required'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        

        if (Auth::user()->type == 0) {

            if (Hash::check($request->password, Auth::user()->password)) {
                // $user = User::find($id);
                // return $user;

                $user= User::where('id',$id)->update(
                    [
                        'profit_percentage'=>$request->profit_percentage,
                        'type'=>$request->user_type,
                    ]
                );
            }

            
        }

        return redirect()->back();

    }

    


    
    
}
