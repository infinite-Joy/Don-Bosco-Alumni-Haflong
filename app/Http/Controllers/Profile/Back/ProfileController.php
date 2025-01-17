<?php

namespace App\Http\Controllers\Profile\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function viewProfile(){

    
      
        return view('profile.view');
    }

    public function editProfile(){

        return view('profile.edit');
    }

    public function updateProfile(Request $request){
      

          $request->validate([
            'first_name' =>'required|string',
            'last_name' =>'required|string',
            'dob'=> 'date|nullable',
            'phone'=>'numeric|nullable',
            'pin_code'=>'numeric|nullable',
            'city'=>'required|string',
            'country'=>'string|nullable',
            'state' =>'string|nullable',
            'occupation'=>'string|nullable',
            'blood_group'=>'required|string',
            'blood_donor' =>'boolean',
        ]);

        $blood_donor= $request->boolean('blood_donor');

        if($blood_donor && $request->phone == Null){
            return redirect()->route('profile.edit')->with('failure', 'Mobile no. is mandatory for blood donor');
        }

        $updated = auth()->user()->update([
            'first_name' =>Str::ucfirst($request->first_name) ,
            'middle_name'  =>Str::ucfirst($request->middle_name),
            'last_name' =>Str::ucfirst($request->last_name),
            'phone'=> $request->phone,
            'dob'=>$request->dob,
            'occupation'=> Str::ucfirst($request->occupation),
            'city'=> Str::ucfirst($request->city),
            'state'=> Str::ucfirst($request->state),
            'country'=> Str::ucfirst($request->country),
            'pin_code'=> $request->pin_code,
            'aboutme'=> $request->aboutme,
            'blood_group'=>Str::upper($request->blood_group),
            'blood_donor'=>$blood_donor,
        ]);
     
        return redirect()->route('profile.view')->with('success', 'Profile updated successfully');

    }


    public function editPassword() {
        
            return view('profile.change-password');
    }

    public function changePassword(Request $request){
    
         $request->validate([
            'passphrase' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if($request->passphrase == auth()->user()->passphrase){
            $updated= auth()->user()->update([
           'password' =>bcrypt($request->password), ]);
            return redirect()->route('edit.password')->with('success', 'Password changed successfully');
        }
        else{
            return redirect()->route('edit.password')->with('failure', 'Wrong passphrase');
        }

    }

    public function editPassphrase(){

        return view ('profile.change-passphrase');
    }
    

    public function changePassphrase(Request $request){
        
        
        $request->validate([
            'passphrase' => 'required',
            'password' => 'required',
        ]);

        $password = $request->password;
        $hashPassword = auth()->user()->password;

       //dd(Hash::check($password, $hashPassword));

        if(Hash::check($password, $hashPassword)){
            $updated= auth()->user()->update([
           'passphrase' =>$request->passphrase, ]);
            return redirect()->route('edit.passphrase')->with('success', 'Passphrase changed successfully');
        }
        else{
            return redirect()->route('edit.passphrase')->with('failure', 'Wrong password');
        }
    }

     
    
    public function updateProfilePic(Request $request){

     
        $request->validate(
            [
                'profile_picture' => 'image|mimes:png,jpg|max:2048',
            ]
        );


        if($request->hasFile('profile_picture')){
            
            if(file_exists(public_path('images/profile/'.auth()->user()->profile_picture)) AND !empty(auth()->user()->profile_picture)){

            unlink(public_path('images/profile/'.auth()->user()->profile_picture));
        }
            $image = $request->file('profile_picture');
            $extension = $image->extension();
            $profile_picture_name = date('dmYHis').'.'.$extension;
            $resize= Image::make($image)->resize(224,224);
            $final_image= $resize->insert('images/misc/watermark.png','bottom-right', 30, 10);
            $final_image->save('images/profile/'.$profile_picture_name);
        }
    
   
        $updated= auth()->user()->update([
            'profile_picture' => $profile_picture_name,
        ]);

       return redirect()->route('profile.view')->with('success', 'Profile Picture changed successfully');
        
    }

    public function removeProfilePic(Request $request){
       
       $request->validate([
            'profile_picture' => 'string|nullable'
        ]);

    $user = auth()->user()->profile_picture;

    unlink(public_path('images/profile/'.auth()->user()->profile_picture));
    
        $updated= auth()->user()->update([
            'profile_picture' => $request->profile_picture,
        ]);

       return redirect()->route('profile.view')->with('success', 'Profile Picture removed successfully');
    }
    
}
