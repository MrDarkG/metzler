<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\CostumImageValidation;
use App\Rules\PhoneNumberValidation;
use App\Rules\RoleValidation;
use Hash;
use App\Models\User;
use App\Models\Posts;
use App\Models\User_profile;
use Storage;
use Auth;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with(["user_profile","roles"])->get();
        return view("admin.index",["users"=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            "email"=>'required|string|email|max:255|unique:users',
            "picture"=>["required", new CostumImageValidation],
            "name"=>"required|string|max:255",
            "surname"=>"nullable|string",
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', new RoleValidation ],
            'phone' => ['nullable', new PhoneNumberValidation]

        ]);
        $user=User::create([
            'name'=>$request->input("name"),
            'email'=>$request->input("email"),
            "password"=>$request->input("password"),
        ]);
        $image_name=uniqid().time().".jpg";
        $base64_image = $request->input("picture");
        $data = substr($base64_image, strpos($base64_image, ',') + 1);
        $data = base64_decode($data);
        Storage::disk('avatars')->put($image_name, $data);
        
        User_profile::create([
            "avatar"=>"/avatars/".$image_name,
            "surname"=>$request->input("surname"),
            "telephone"=>$request->input("phone"),
            "user_id"=>$user->id
        ]);
        $user->assignRole($request->input("role"));
        return route('user.admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return Auth::user()->hasRole("admin");
        $user=User::where("id",$id)->with(["roles","user_profile"])->firstOrFail();
        return view("admin.edit",["user"=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole($user_id,$role)
    {
        $user=User::where("id",$user_id)->with(["roles"])->firstOrFail();
        if (!$user->hasRole($role)) {
            foreach ($user->roles as $usr) {
                $user->removeRole($usr->name);
            }
            $user->assignRole($role);

        }
    }
    public function deleteoldpicture($name)
    {
        if ($name!="/avatars/default_logo.png") {
            // return $name;
            Storage::disk("delete")->delete($name);
        }
        return $image_name=uniqid().time().".jpg";
        
    }
    public function update(Request $request )
    {
        $this->validate($request,[
            "email"=>'required|string|email|max:255',
            "picture"=>["nullable", new CostumImageValidation],
            "name"=>"required|string|max:255",
            "surname"=>"nullable|string",
            'role' => ['required', new RoleValidation ],
            'user_id' => ['required',"numeric"],
            'phone' => ['nullable', new PhoneNumberValidation]
        ]);
        $user=User::where([
            ["email",$request->input("email")],
            ["id",$request->input("user_id")],
        ])->count();
        if ($user==0) {
            $this->validate($request,[
                "email"=>'required|string|email|max:255|unique:users',
            ]);
        }
        $user_old_picture=User_profile::where("user_id",$request->input("user_id"))->firstOrFail()->avatar;
        $picture_name="default_logo.png";
        if (!is_null($request->input("picture"))) {
            $picture_name=$this->deleteoldpicture($user_old_picture);
            $base64_image = $request->input("picture");
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            Storage::disk('avatars')->put($picture_name, $data);
            
        }
        User::where("id",$request->input("user_id"))->update([
            'name'=>$request->input("name"),
            'email'=>$request->input("email")
        ]);
        User_profile::where("user_id",$request->input("user_id"))->update([
            "avatar"=>"/avatars/".$picture_name,
            "surname"=>$request->input("surname"),
            "telephone"=>$request->input("phone"),
        ]);
        $this->updateRole($request->input("user_id"),$request->input("role"));
        return route('user.admin.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletefile($name)
    {
        if ($name!="/posts/coverimagevsfeaturedimage.png") {

             Storage::disk("delete")->delete($name);
        }
    }
    public function deletepostpictures($user_id)
    {
        $posts=Posts::where("user_id",$user_id);
        foreach ($posts->get() as $post) {
            
            $this->deletefile($post->picture);

        }
        $posts->delete();
        
    }
    public function deleteuserrolesbyid($user_id)
    {
        $user=User::where("id",$user_id)->with(["roles"])->firstOrFail();
        foreach ($user->roles as $role) {
            $user->removeRole($role->name);
        }
        $user_avatar=User_profile::where("user_id",$user_id)->firstOrFail()->avatar;
        $this->deleteoldpicture($user_avatar);
        User_profile::where("user_id",$user_id)->delete();
        User::where("id",$user_id)->delete();

    }
    public function destroy(Request $request)
    {
        $this->deleteuserrolesbyid($request->input("id"));
        $this->deletepostpictures($request->input("id"));
        return redirect()->back();
    }
}
